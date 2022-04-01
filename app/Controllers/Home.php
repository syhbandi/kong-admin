<?php

namespace App\Controllers;
use App\Models\HomeModel;

class Home extends BaseController
{
    public function __construct()
	{
		$this->HomeModel = new HomeModel();
	}
    public function index()
    {
        $user_mp = $this->HomeModel->misterkong()->getRowArray();
        $user_pos = $this->HomeModel->kongpos()->getRowArray();
        $user_driver = $this->HomeModel->kongrider()->getRowArray();
        $barang = $this->HomeModel->barang()->getRowArray();
        $data['user'] = [
            'user mp' => $user_mp['mp'],
            'user pos' => $user_pos['pos'],
            'user rider' => $user_driver['driver'],
            'barang' => $barang['barang'],
        ];
        return view('home', $data);
    }
}
