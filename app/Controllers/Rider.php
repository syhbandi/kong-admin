<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Rider\RiderModel;

class Rider extends BaseController
{
    private $riderModel;

    public function __construct()
    {
        $this->riderModel = new RiderModel();
    }

    public function index()
    {
        return view('rider/dataRider',);
    }

    public function getBaru()
    {
        $search = $this->request->getPost('search')['value'];
        $order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
        $start = $this->request->getPost('start');
        $limit = $this->request->getPost('length');

        $result = $this->riderModel->getBaru($search, $start, $limit)->getResult();
        $totalCount = !empty($result) ? \count($result) : 0;

        $no = $start + 1;
        $data = [];

        foreach ($result as $key => $value) {
            $data[$key] = [
                $no,
                $value->kd_driver,
                $value->nama_depan,
                $value->alamat_tinggal,
                $value->hp1,
                $value->hp2,
                $value->email,
                $value->no_ktp,
                $value->kd_zona,
                $value->merk_nama,
                $value->model_nama,
                $value->nomor_plat,
                $value->tahun_pembuatan,
                $value->STNK_expired,
                $value->kd_kendaraan,
                '<a href="' . base_url() . '/rider/verifikasi/' . $value->kd_driver . '" class="btn btn-primary btn-sm"><i class="fas fa-check mr-1"></i> Verifikasi</a>',
            ];
            $no++;
        }

        return \json_encode([
            "draw" => $_POST['draw'],
            "recordsTotal" => $totalCount,
            "recordsFiltered" => $totalCount,
            "data" => $data,
        ]);
    }
}
