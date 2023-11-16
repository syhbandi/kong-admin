<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\MapperModel;

class MapperController extends BaseController
{
    public function __construct()
	{
        $this->session = \Config\Services::session();
        if (!$this->session->has('login')) {
            header("Location: /login");
            die();
        }
		$this->mapper = new MapperModel();
	}

    public function index()
    {
        $data['belum_bayar']=$this->mapper->getDataMapper(1)->getResult();
        $data['belum_verif']=$this->mapper->getDataMapper(2)->getResult();
        $data['sudah_verif']=$this->mapper->getDataMapper(3)->getResult();
        $data['expired']=$this->mapper->getDataMapper(4)->getResult();
        // print_r($data);
        // die();
        return view('mapper/home',$data);
    }
    public function verifikasiPembayaran()
    {
        $post_data=$this->request->getPost();
        $data_save=[
            "nominal"=>$post_data['nominal'],
            "awal"=>$post_data['awal'],
            "periode"=>$post_data['nominal'],
            "tarif_mapper_id"=>$post_data['nominal'],
            "tanggal_verifikasi"=>date('Y-m-d H:i:s')
        ];
        $condition=[
            "id" =>$post_data['other_cid']
        ];
        $exec=$this->mapper->verifikasiMapper($data_save,$condition);
        if($exec){
            print json_encode(["status"=>1]);
        }else{
            print json_encode(["status"=>0]);
        }
    }
}
