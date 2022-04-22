<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class KontrakController extends BaseController
{
    public function index()
    {
        return view('kontrak/kontrak');
    }
}
