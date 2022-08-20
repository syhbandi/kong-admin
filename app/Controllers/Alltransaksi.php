<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Alltransaksi extends BaseController
{
    public function index()
    {
        return view('transaksi/transaksi');
    }
}
