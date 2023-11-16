<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\bank\BankModel;


class BankController extends BaseController
{
	public function __construct()
	{
		$this->session = \Config\Services::session();
		if (!$this->session->has('login')) {
			header("Location: /login");
			die();
		}
		$this->BankModel = new BankModel();
	}
	public function index()
	{
		return view('bank/databank');
	}
	public function getbank()
	{
		$search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');
		$result = $this->BankModel->getbank($search, $start, $limit, null)->getResult();
		$totalCount = count($this->BankModel->getbank($search, '', '')->getResultArray());

		$no = $start + 1;
		$data = [];

		foreach ($result as $key => $value) {
			$data[$key] = [
				$no,
				$value->kd_bank,
				$value->nama_bank,
				'<button class="btn btn-info edit" id="edit" data-bank="'.$value->kd_bank.'"><i class="fas fa-edit mr-1"></i></button>',
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
		$kd_bank = $this->request->getVar('kd_bank');
		$data = $this->BankModel->getbank(null, null, null, $kd_bank)->getResult();
		return json_encode($data);
	}

	public function editbank()
	{
		$code = $this->request->getVar('kd');
		$kd_bank = $this->request->getVar('code');
		$nama_bank = $this->request->getVar('bank');
		$update = $this->BankModel->updatebank($code, $kd_bank, $nama_bank);
		if ($update == 'TRUE') {
			$this->session->setFlashdata('sukses', 'Data bank Berhasil Di Ubah'); 
			return json_encode([
				'success' => true,
				'redirect' => base_url('bank'),
			]);
		}
		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan Update data'
		]);
	}

	public function insertb()
	{
		$kd_bank = $this->request->getVar('code');
		$nama_bank = $this->request->getVar('nama_bank');
		$add = $this->BankModel->insertb($kd_bank, $nama_bank);
		if ($add == TRUE) {
			$this->session->setFlashdata('sukses', 'Data Bank Berhasil Di Tambahkan'); 
			return json_encode([
				'success' => true,
				'redirect' => base_url('bank'),
			]);
		}
		return json_encode([
			'success' => false,
			'msg' => 'Gagal Menambah Data Bank'
		]);
	}
}
