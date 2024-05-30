<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Str;
use Hash;

class QrisController extends Controller
{
    public function qris(Request $request) 
    {
        $random = Str::random(25);
        $hash = "M-00004203|2023-04-02T22:00:00.000+08:00|" . $request->nominal . "|dNVYlJsj";
        $hash = base64_encode(hash_hmac("sha256",$hash,"dNVYlJsj",true));
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic TS0wMDAwNDIwMw==',
            'Codeauth' => 1,
            'Timestamp' => '2023-04-02T22:00:00.000+08:00',
            'Signature' => $hash
        ])->retry(3,3000)->post('https://fintech-dev.pactindo.com/api/v1/charge', [
            'orderId' => $random,
            'terminalPac' => 'MT-PAC4421',
            'grossAmount' => $request->nominal,
            'paymentType' => 'QRis',
            'acqCode' => '000',
            'customerDetail' => [
                'phone' => '',
                'email' => '',
                'name' => ''
            ]
        ]);
        $text = json_decode($response->getBody(), true);
        $keterangan = $text['responseDescription'];
        if ($text['responseCode'] == '202')
        {   
            $qr = $text['billingRef'];
            $qrcode = QrCode::size(200)->generate($qr);
        }
        else
        {
            $qrcode = 'Not Found';
        }
        return view('qris', ['keterangan' => $keterangan, 'qr' => $qrcode, 'orderId' => $random, 'idpelanggan' => $request->idpelanggan,
                            'nominal' => $request->nominal]);
    }

    public function status(string $id)
    {
        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
            'Authorization' => 'Basic TS0wMDAwNDIwMw==',
            'Codeauth' => 1,
            'Timestamp' => '2022-10-26T09:08:58.430+08:00',
            'Signature' => '8IkJZoqqMmmKpTmbwBzM3bC3LrgIhbf77FMZ8ybNXFM='
        ])->withUrlParameters(['id' => $id])->get('https://fintech-dev.pactindo.com/api/v1/status/{id}', []);
        $status = json_decode($response->getBody(), true);
        if($status['transactionStatus'])
        {
            $status = $status['transactionStatus'];
        }
        else
        {
            $status = $status['responseDescription'];
        }
        return $status;
    }
}
