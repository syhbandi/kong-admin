<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\kontrak\KontrakModel;

class KontrakController extends BaseController
{
    public function __construct()
	{
		$this->session = \Config\Services::session();
        if (!$this->session->has('login')) {
            header("Location: /login");
            die();
        }
		$this->Kontrak = new KontrakModel();
	}

    public function index()
    {
        return view('kontrak/kontrak');
    }

    public function getkontrak($jenis = null)
    {
        $search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');

		$result = $this->Kontrak->getkontrak($search, $start, $limit, null, $jenis)->getResult();
		$totalCount = count($this->Kontrak->getkontrak($search, '', '', '', $jenis)->getResultArray());

		$no = $start + 1;
		$data = [];

		foreach ($result as $key => $value) {
			switch ($value->status) {
				case '1':
					$status = 'aktif';
					$textColor = 'success';
					break;
				case '-2':
					$status = 'nonaktif';
					$textColor = 'danger';
					break;
				default:
					$status = 'terjadi kesalahan';
					$textColor = 'danger';
					break;
			}

			$data[$key] = [
				$no,
				$value->nama_usaha,
				$value->tujuan,
                $value->tanggal_request,
                $value->tanggal_response,
                $value->tanggal_kontrak,
				'<span class="font-weight">' . $value->periode_bulan . ' Bulan</span>',
                '<span class="text-' . $textColor . ' font-weight-bold">' . $status . '</span>',
				'<a href="' . base_url('kontrak/detailkontrak/' . $value->id) . '" class="btn btn-'.$textColor.' btn-sm"><i class="fas fa-eye"></i></a>',
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
    public function detailkontrak($id_kontrak)
    {
        $kontrak = $this->Kontrak->getkontrak(null, null, null, $id_kontrak)->getRowArray();

        $foto_kontrak = file_exists(FCPATH . '/../dist/img/kontra/' . $kontrak['path_image'] . 'kontrak.jpg') ? base_url() . '/../dist/img/kontra/' . $kontrak['path_image'] . 'kontrak.jpg' : base_url() . '/assets/file-not-found.png';

		$data['kontrak'] = [
			'Sumber' => $kontrak['nama_usaha'],
			'Tujuan' => $kontrak['tujuan'],
			'Tanggal Request' => $kontrak['tanggal_request'],
			'Tanggal Response' => $kontrak['tanggal_response'],
			'Tanggal Kontrak' => $kontrak['tanggal_kontrak'],
			'Tanggal Bayar' => $kontrak['tanggal_bayar'],
			'Tanggal Konfirmasi' =>$kontrak['tanggal_konfirmasi'],
			'Tanggal Jatuh Tempo' => $kontrak['tanggal_jatuh_tempo'],
			'Biyaya Kontrak' => $kontrak['nominal'],
			'Bukti Pembayaran' => '<img class="img-thumbnail btn-dok" src="' . $foto_kontrak . '" data-title="Foto Kontrak" data-id="'.$kontrak['id'].'"/>',
		];
		$data['id_kontrak'] = $kontrak['id'];
        $data['sumber'] = $kontrak['comp_id_sumber'];
        $data['tujuan'] = $kontrak['comp_id_tujuan'];
        $data['code_customer'] = $kontrak['kd_customer'];
        $data['comp_customer'] = $kontrak['customer_user_company_id'];
        $data['code_supplier'] = $kontrak['kd_supplier'];
        $data['comp_supplier'] = $kontrak['supplier_user_company_id'];
		$data['status'] = $kontrak['status'];
		return view('kontrak/detailkontrak', $data);
    }

    public function updatekontrak()
    {
        $code_customer = $this->request->getVar("code_customer");  
        $comp_customer = $this->request->getVar("comp_customer");  
        $code_supplier = $this->request->getVar("code_supplier");  
        $comp_suppiler = $this->request->getVar("comp_supplier"); 
        $id = $this->request->getVar("id");  
        $sumber = $this->request->getVar("sumber"); 
        $tujuan = $this->request->getVar("tujuan"); 
        $upstatus = $this->Kontrak->updatekontrak($code_customer, $comp_customer, $code_supplier, $comp_suppiler, $id, $sumber, $tujuan);
        if ($upstatus == TRUE) {
			$this->session->setFlashdata('sukses', 'Kontrak dengan code '.$id.' telah DI verivikasi'); 
			return json_encode([
				'success' => true,
				'redirect' => base_url('kontrak'),
			]);
		}
		return json_encode([
			'success' => false,
			'msg' => 'filed to update',
		]);

    }
}
