<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Misterkong\UserMpModel;

class Marketplace extends BaseController
{
    public function __construct()
	{
		$this->UserMpModel = new UserMpModel();
	}

    public function index()
    {
        return view('user_mp/datamp');
    }

	public function getmpUser($jenis = null)
	{
		$search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');

		$result = $this->UserMpModel->getuser($search, $start, $limit, null, $jenis)->getResult();
		$totalCount = count($this->UserMpModel->getuser($search, '', '', '', $jenis)->getResultArray());

		$no = $start + 1;
		$data = [];

		foreach ($result as $key => $value) {
			switch ($value->status) {
				case '0':
					$status = 'Non Aktif';
					$textColor = 'danger';
					break;
				case '1':
					$status = 'Aktif';
					$textColor = 'success';
					break;

				default:
					$status = 'terjadi kesalahan';
					$textColor = 'danger';
					break;
			}

			$data[$key] = [
				$no,
				$value->kd_user,
				$value->nama,
				$value->no_hp,
				$value->email,
				$value->no_rek,
				$value->date_add,
				"<span class='text-$textColor font-weight-bold'>$status</span>",
				'<a href="' . base_url('market/detailMp/' . $value->kd_user) . '" class="btn btn-'.$textColor.' btn-sm"><i class="fas fa-eye"></i></a>',
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

	public function detail_user($kd_user)
	{
		$user = $this->UserMpModel->getuser(null, null, null, $kd_user)->getRowArray();
		$data['user'] = [
			'Kode User' => $user['kd_user'],
			'Nama' => $user['nama'],
			'No. hp' => $user['no_hp'],
			'Email' => $user['email'],
			'status' => $user['status'],
			'Rekening' =>$user['nama_bank'],
			'No rekening' => $user['no_rek'],
		];
		$data['kd_user'] = $user['kd_user'];
		$data['status'] = $user['status'];
		return view('user_mp/detailMP', $data);
	}

	public function update()
	{
		$kd_user = $this->request->getVar('kd_user'); 
		$nama = $this->request->getVar('nama'); 
		$no_hp = $this->request->getVar('no_hp'); 
		$email = $this->request->getVar('email'); 
		$rekening = $this->request->getVar('kd_bank'); 
		$norek = $this->request->getVar('no_rek');
		$edit = $this->UserMpModel->updatev($kd_user, $nama, $no_hp, $email, $rekening, $norek);
		if ($edit == 'TRUE') {
			$this->session->setFlashdata('sukses', 'User dengan Company id ' . $kd_user . ' telah Berhasil Di Update'); 
			$this->sendNotifToUser($kd_user, 'Selamat, data Anda Sudah di Lengkapi. Silahkan Log Out dan Login kembali ke aplikasi untuk memulai aktifitas anda.'); 
			return json_encode([
				'success' => true,
				'redirect' => base_url('market'),
				'company' => $kd_user
			]);
		}
		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan validasi'
		]);
	}

	public function sendNotifToUser($kd_user, $pesan, $jenis = 0)
	{
		$payload = array(
			'to' => '/topics/kongVal',
			'priority' => 'high',
			"mutable_content" => true,
			'data' => array(
				"id_dr" => $kd_user,
				"psn" => $pesan,
				"mode" => '1',
				"jenis_notif" => $jenis
			),
		);
		$headers = array(
			'Authorization:key=AAAAJrZwZQg:APA91bEp4BYq1kZcVwUyuh02a_s5F3txxf_CJHNbvdwsdjs6qwdHuWIiS3BKN7ETR3gtQkVZgHebKCH4C6N-QaHeJTEC5m8pMT0MDD5i6oG2bqPwbPT3XR3dY9h_zku1TtamNt9_Tn9q', 'Content-Type: application/json',
		);

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
		$result = curl_exec($ch);
		curl_close($ch);
	}
        
}