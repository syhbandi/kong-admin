<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Transaksi\TransaksiModel;

class Transaksi extends BaseController
{
    public function index()
    { 
			$data['lokasi'] = [
				'code' => $this->TransaksiModel->getlokasi()->getResultArray(),
				'app' => $this->TransaksiModel->query('SELECT id, app_name FROM m_app_zona')->getResult(),
			];
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
				$value->app_name,
				$value->batas_bawah,
				$value->batas_atas,
				$value->fee_minim_bawah,
				$value->fee_minim_atas,
                $value->jarak_pertama,
				$value->deskripsi,
				$value->nama,
				// '<a href="'.$value->id.'" class="btn btn-info btn-sm" data-toggle="modal"  id="edit" data-id="12"><i class="fas fa-edit mr-1"></i></a>',
				'<button class="btn btn-info edit" id="edit" data-id="'.$value->id.'"><i class="fas fa-edit mr-1"></i></button>',
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

	public function show()
	{
		$id = $this->request->getVar('id');
		$data = $this->TransaksiModel->tarif(null, null, null, $id)->getResult();
		return json_encode($data);
	}

	public function addzona()
	{
		$zona = $this->request->getVar('zona'); 
		$app = $this->request->getVar('app'); 
		$kendaraan = $this->request->getVar('kendaraan'); 
		$deskripsi = $this->request->getVar('deskripsi'); 
		$bawah = $this->request->getVar('bawah');
		$atas = $this->request->getVar('atas');
		$feeb = $this->request->getVar('feeb'); 
		$feea = $this->request->getVar('feea'); 
		$jarak = $this->request->getVar('jarak');
		$add = $this->TransaksiModel->addzona($zona, $app, $kendaraan, $deskripsi, $bawah, $atas, $feeb, $feea, $jarak);
		if ($add != TRUE) {
			$this->session->setFlashdata('sukses', 'Data Trif Berhasil Di Tambahkan'); 
			return json_encode([
				'success' => true,
				'redirect' => base_url('tarif'),
			]);
		}
		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan validasi'
		]);
	}
	public function updatezona()
	{
		$id = $this->request->getVar('id'); 
		$zona = $this->request->getVar('zona'); 
		$app = $this->request->getVar('app'); 
		$kendaraan = $this->request->getVar('kendaraan'); 
		$deskripsi = $this->request->getVar('deskripsi'); 
		$bawah = $this->request->getVar('bawah');
		$atas = $this->request->getVar('atas');
		$feeb = $this->request->getVar('feeb'); 
		$feea = $this->request->getVar('feea'); 
		$jarak = $this->request->getVar('jarak');
		$edittarif = $this->TransaksiModel->updatezona($id, $zona, $app, $kendaraan, $deskripsi, $bawah, $atas, $feeb, $feea, $jarak);
		if ($edittarif == 'TRUE') {
			$this->session->setFlashdata('sukses', 'Data Trif Berhasil Di Ubah'); 
			return json_encode([
				'success' => true,
				'redirect' => base_url('tarif'),
			]);
		}
		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan validasi'
		]);
	}

}
