<?php

namespace App\Controllers;

use App\Controllers\BaseController;

class AtributController extends BaseController
{
    public function index()
    {
        return view('atribut/dataatribut.php');
    }
}