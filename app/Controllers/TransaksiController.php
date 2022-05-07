<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Transaksi\TransaksiModel;

class TransaksiController extends BaseController
{
    public function index($id = null)
    {
		$tarif = $this->TransaksiModel->tarif(null, null, null, $id)->getRowArray();
			$data['tarif'] = [
				'lokasi' => $tarif['lokasi'],
				'bawah' => $tarif['batas_bawah'],
				'atas' => $tarif['batas_atas'],
				'fee bawah' => $tarif['fee_minim_bawah'],
				'fee atas' => $tarif['fee_minim_atas'],
				'jarak' => $tarif['jarak_pertama'],
				'deskripsi' => $tarif['deskripsi'],
				'nama' => $tarif['nama'],
				'code' => $this->TransaksiModel->query('SELECT kd_lokasi, lokasi AS lokasi1 FROM m_driver_zona_lokasi')->getResult()
				
			];
		
		$data['id'] = $tarif['id'];
		return view('transaksi/tarif', $data);
    }

    public function __construct()
	{
		$this->TransaksiModel = new TransaksiModel();
	}

    public function tarif()
    {
        $search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');

		$result = $this->TransaksiModel->tarif($search, $start, $limit, null)->getResult();
		$totalCount = count($this->TransaksiModel->tarif($search, '', '')->getResultArray());

		$no = $start + 1;
		$data = [];

		foreach ($result as $key => $value) {
			$data[$key] = [
				$no,
				$value->lokasi,
				$value->batas_bawah,
				$value->batas_atas,
				$value->fee_minim_bawah,
				$value->fee_minim_atas,
                $value->jarak_pertama,
				$value->deskripsi,
				$value->nama,
				'<a href="'.$value->id.'" class="btn btn-info btn-sm" data-toggle="modal" data-target="#modalEdit" id="edit"><i class="fas fa-edit mr-1"></i></a>',
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
