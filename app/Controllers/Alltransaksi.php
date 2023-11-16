<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class Alltransaksi extends BaseController
{
    public function __construct()
    {
        $this->session = \Config\Services::session();
        if (!$this->session->has('login')) {
            header("Location: /login");
            die();
        }
        $this->TransaksiModel = new TransaksiModel();
    }
    public function index()
    {
        return view('transaksi/transaksi');
    }
}
