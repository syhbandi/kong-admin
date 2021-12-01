<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Verifikasi extends BaseController
{
    public function index()
    {
    }

    public function topUp()
    {
        return view('verifikasi/topUp');
    }
    public function pencairanRider()
    {
        return view('verifikasi/pencairanRider');
    }
    public function pencairanToko()
    {
        return view('verifikasi/pencairanToko');
    }
}
