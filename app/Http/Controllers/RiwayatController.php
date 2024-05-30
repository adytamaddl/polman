<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RiwayatController extends Controller
{
    public function riwayat()
    {
        $token = DB::select('select * from token');
        foreach ($token as $tkn)
        echo $tkn->nama;

    }
}