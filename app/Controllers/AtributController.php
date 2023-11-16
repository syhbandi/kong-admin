<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Atribut\AtributModel;

class AtributController extends BaseController
{
	public function __construct()
	{
		$this->session = \Config\Services::session();
		if (!$this->session->has('login')) {
			header("Location: /login");
			die();
		}
		$this->AtributModel = new AtributModel();
	}
	public function index()
	{
		return view('atribut/dataatribut');
	}
	public function transaksi()
	{
		return view('atribut/transaksi');
	}
	public function getattr()
	{
		$search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');
		$result = $this->AtributModel->getattr($search, $start, $limit, null)->getResult();
		$totalCount = count($this->AtributModel->getattr($search, '', '')->getResultArray());

		$no = $start + 1;
		$data = [];

		foreach ($result as $key => $value) {
			$data[$key] = [
				$no,
				$value->nama,
				$value->keterangan,
				"Rp " . number_format((int)$value->harga_jual,0,',','.'),
				'<button class="btn btn-info edit" id="edit" data-attr="'.$value->driver_attr_id.'"><i class="fas fa-edit mr-1"></i></button>',
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
	public function getbaykd()
	{
		$kd_attr = $this->request->getVar('driver_attr_id');
		$data = $this->AtributModel->getattr(null, null, null, $kd_attr)->getResult();
		return json_encode($data);
	}
	public function editattr()
	{
		$code = $this->request->getVar('driver_attr_id');
		$harga = $this->request->getVar('harga_jual');
		$update = $this->AtributModel->updat_attr($code, $harga);
		if ($update == 'TRUE') {
			$this->session->setFlashdata('sukses', 'Data  Atribut Berhasil Di Ubah'); 
			return json_encode([
				'success' => true,
				'redirect' => base_url('atribut'),
			]);
		}
		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan Update data'
		]);
	}
}
