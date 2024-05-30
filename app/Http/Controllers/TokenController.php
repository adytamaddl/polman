<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Token;
use Illuminate\Support\Facades\Http;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Str;
use Hash;
use DB;
use Carbon;

class TokenController extends Controller
{
    public function qris(Request $request)
    {
        $cektoken = $this->cektoken($request->idpelanggan, $request->nominal);
        if($cektoken == '')
        {
            $response = $this->createqris($request);
            $qrcode = QrCode::size(200)->generate($response['qr']);

            return view('qris', ['keterangan' => $response['keterangan'], 'qr' => $qrcode, 'orderId' => $response['orderId'], 'idpelanggan' => $response['idpelanggan'],
                                'nominal' => $response['nominal']]);
        }
        else
        {
            $cekstatus = $this->status($cektoken->orderid);
            if($cekstatus == 'PENDING')
            {
                $qrcode = QrCode::size(200)->generate($cektoken->qrcode);
                return view('qris', ['keterangan' => 'Tidak Ditemukan', 'qr' => $qrcode, 'orderId' => $cektoken->orderid, 'idpelanggan' => $cektoken->idpelanggan,
                                'nominal' => $cektoken->nominal]);
            }
            else
            {
                $response = $this->createqris($request);
                $qrcode = QrCode::size(200)->generate($response['qr']);

                return view('qris', ['keterangan' => $response['keterangan'], 'qr' => $qrcode, 'orderId' => $response['orderId'], 'idpelanggan' => $response['idpelanggan'],
                                    'nominal' => $response['nominal']]);
            }
            
        }
    }

    public function createqris($request)
    {
        $date = Carbon\Carbon::now('+08:00')->toW3cString();
        $random = Str::random(25);
        $token = new Token;
        $token->idpelanggan = $request->idpelanggan;
        $token->nama = $request->namapelanggan;
        $token->nominal = $request->nominal;
        $token->orderid = $random;
        $hash = "M-00004203|" .$date. "|" . $request->nominal . "|dNVYlJsj";
        $hash = base64_encode(hash_hmac("sha256",$hash,"dNVYlJsj",true));
        $response = Http::withHeaders([
                'Content-Type' => 'application/json',
                'Authorization' => 'Basic TS0wMDAwNDIwMw==',
                'Codeauth' => 1,
                'Timestamp' => $date,
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
            $token->qrcode = $text['billingRef'];
        }
        else
        {
            $qr = 'Not Found';
            $token->qrcode = $qr;
        }
        $token->save();
        return (['keterangan' => $keterangan, 'qr' => $qr, 'orderId' => $random, 'idpelanggan' => $request->idpelanggan,
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
        ])->withUrlParameters(['id' => $id])->retry(3,3000)->get('https://fintech-dev.pactindo.com/api/v1/status/{id}', []);
        $status = json_decode($response->getBody(), true);
        if($status['responseCode'] == '200')
        {
            $status = $status['transactionStatus'];
        }
        else
        {
            $status = $status['responseDescription'];
        }
        return $status;
    }

    public function cektoken(string $idpelanggan, float $nominal)
    {
        $data = DB::table('token')->where('idpelanggan', $idpelanggan)->where('nominal', $nominal)->orderBy('created_at', 'desc')->first();
 
        return $data;
    }
}
