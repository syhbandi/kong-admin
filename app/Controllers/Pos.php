<?php

namespace App\Controllers;

use App\Controllers\BaseController;
// use App\Models\TokoModel;
use App\Models\Pos\TokoModel;
use App\Models\PencairanModel;

class Pos extends BaseController
{
	private $TokoModel;
	private $pencairanModel;

	public function __construct()
	{
		$this->session = \Config\Services::session();
        if (!$this->session->has('login')) {
            header("Location: /login");
            die();
        }
		$this->TokoModel = new TokoModel();
		$this->pencairanModel = new PencairanModel();
	}

	public function index()
	{
		$version = $this->TokoModel->version()->getRowArray();
		$data['pos'] = [
			'version app' => $version['app_store_version'],
			'id version' => $version['id'],
		];
		return view('pos/dataPos', $data);
	}

	public function barang()
	{
		return view('pos/databarang');
	}

	public function barangc($company_id)
	{
		$data = [
			'company_id' => $company_id
		];
		return view('pos/jml_barang', $data);
	}
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// pencairan
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function pencairan()
	{
		return view('pos/pencairanToko');
	}
	public function getToko($jenis = null)
	{
		$search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');

		$result = $this->TokoModel->getToko($search, $start, $limit, null, $jenis)->getResult();
		$totalCount = count($this->TokoModel->getToko($search, '', '', '', $jenis)->getResultArray());

		$no = $start + 1;
		$data = [];

		foreach ($result as $key => $value) {
			switch ($value->status) {
				case '-2':
					$status = 'Banned';
					$textColor = 'danger';
					break;
				case '1':
					$status = 'Aktif';
					$textColor = 'success';
					break;
				case '-1' :
					$status = 'Nonaktif';
					$textColor = 'info';
					break;
				case '0' :
					$status = 'Tutup';
					$textColor = 'warning';
					break;
				default:
					$status = 'terjadi kesalahan';
					$textColor = 'danger';
					break;
			}

			$data[$key] = [
				$no,
				$value->nama_usaha,
				$value->usaha,
				$value->no_telepon,
				$value->email_usaha,
				$value->nama,
				$value->province,
				$value->date_add,
				'<a href="' . base_url('pos/detailPos/' . $value->company_id) . '" class="btn btn-'.$textColor.' btn-sm"><i class="fas fa-eye"></i></a>',
				
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
	public function detailPos($company_id)
	{
		$pos = $this->TokoModel->getToko(null, null, null, $company_id)->getRowArray();
		$data['pos'] = [
			'Company Id' => $pos['company_id'],
			'Nama Usaha' => $pos['nama_usaha'],
			'Kategori Usaha' => $pos['usaha'],
			'Alamat' => $pos['alamat'],
			'Email' => $pos['email_usaha'],
			'No. Hp' => $pos['no_telepon'],
			'Rekening' =>$pos['bank'].' <br> '. $pos['no_rek'] . ' - ' . $pos['nama_pemilik_rekening'],
			'Province' => $pos['province'],
			'Jumlah Barang' => '<a href="' . base_url('pos/barangc/' . $pos['company_id']) . '" class="btn btn-info btn-sm">'.$pos['jml_barang'].' Barang</a>',
			'Lat' => $pos['koordinat_lat'],
			'Lng' => $pos ['koordinat_lng'],
			'Location' => '<div id="map" class="border-2" style="width: 100%; height: 200px;"></div>',
			// 'version app' => $version['app_store_version'],
		];
		$data['company_id'] = $pos['company_id'];
		$data['status'] = $pos['status'];
		return view('pos/detailPos', $data);
	}

	public function updatever()
	{
		$id = $this->request->getVar('id');
		$app_version = $this->request->getVar('version');
		$this->TokoModel->updatev($id, $app_version);
		return redirect()->to('pos');
	}

	public function editkategori()
	{
		$company_id = $this->request->getVar('company_id');
		$kategori = $this->request->getVar('kategori');
		$setkategori = $this->TokoModel->editkategori($kategori, $company_id);

		if ($setkategori == 'TRUE') {
			$this->session->setFlashdata('sukses', 'Toko dengan Company id ' . $company_id . ' telah Berhasil Di Update'); 
			$this->sendNotifToToko($company_id, 'Selamat, Kategori Usaha Anda Sudah di Update. Silahkan Log Out dan Login kembali ke aplikasi untuk memulai aktifitas anda.'); 
			return json_encode([
				'success' => true,
				'redirect' => base_url('pos'),
				'company' => $company_id
			]);
		}
		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan validasi'
		]);
	}

	public function verivikasiToko()
	{
		$company_id = $this->request->getVar('company_id');
		$status = $this->request->getVar('status');
		$setStatus = $this->TokoModel->verivikasi($status, $company_id);

		if ($setStatus == 'TRUE') {
			$this->session->setFlashdata('sukses', 'Toko dengan Company id ' . $company_id . ' telah diverifikasi'); 
			$this->sendNotifToToko($company_id, 'Selamat, data anda sudah divalidasi. Silahkan Log Out dan Login kembali ke aplikasi untuk memulai aktifitas anda.'); 
			return json_encode([
				'success' => true,
				'redirect' => base_url('pos'),
				'company' => $company_id
			]);
		}
		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan validasi'
		]);

	}
	public function update_app()
	{
		$status =  $this->request->getVar('status');
		$versi_app = $this->request->getVar('versi_app');
		$notif = $this->request->getVar('notif');
		if ($notif == 10) {
			$pesan = "Ada Update Terbaru nih dari KongPos Yuk Buruan di Update ke Version Terbaru Agar transaksi Lancar";
			$jenis = 10;
			$redirect = 'pos';
		}else {
			$pesan = "Yuk Buruan Top Up saldo Misterkongmu Agar Dapat melakukan transaksi";
			$jenis = 11;
			$redirect = 'rider/top-up';
		}
		$payload = array(
			'to' => '/topics/kongpos',
			'priority' => 'high',
			"mutable_content" => true,
			'data' => array(
				"title" => "New Version",
				"body" => $pesan,
				"mode" => '1',
				"jenis_notif" => $jenis,
				"version" => $versi_app,
			),
		);
		$headers = array(
			'Authorization:key=AAAAf50odws:APA91bERBP6tLNfAWz_aeNhmXjbOOItI2aZ_bZEy1xNX47SWCr8LbrfNVQfuVJ8xYT7_mCFKRn6pBW7_qO-fG5qFNfIU-8nfWm1-M_zhezLK12dlsIeFi8ZfYeizEhPVQTdIbGj0DtUt', 'Content-Type: application/json',
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
		$this->session->setFlashdata('sukses', $status == 1 ? 'Notifikasi Berhasil Dikirim' : 'Notifikasi gagal dikirim'); // tampilkan toast ke aplikasi
		return json_encode([
			'success' => true,
			'redirect' => base_url($redirect),
		]);
	}
	public function sendNotifToToko($company_id, $pesan, $jenis = 0)
	{
		$payload = array(
			'to' => '/topics/kongpos',
			'priority' => 'high',
			"mutable_content" => true,
			'data' => array(
				"id_toko" => $company_id,
				"psn" => $pesan,
				"mode" => '1',
				"jenis_notif" => $jenis
			),
		);
		$headers = array(
			'Authorization:key=AAAAf50odws:APA91bERBP6tLNfAWz_aeNhmXjbOOItI2aZ_bZEy1xNX47SWCr8LbrfNVQfuVJ8xYT7_mCFKRn6pBW7_qO-fG5qFNfIU-8nfWm1-M_zhezLK12dlsIeFi8ZfYeizEhPVQTdIbGj0DtUt', 'Content-Type: application/json',
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

	public function getPencairan($jenis, $status = null)
	{
		$search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');
		$jenis = $this->request->getVar('jenis');
		$akhir = $this->request->getVar('akhir');
		$result = $this->pencairanModel->getpenarikantoko($search, $start, $limit, $jenis, $akhir)->getResult();
		$totalCount = count($this->pencairanModel->getpenarikantoko($search, '',  $jenis, $akhir)->getResultArray());

		$no = $start + 1;
		$data = [];

		foreach ($result as $key => $value) {
			switch ($value->status) {
				case '0':
					$status = 'Belum Verifikasi';
					$textColor = 'text-danger';
					break;
				case '1':
					$status = 'Diterima';
					$textColor = 'text-success';
					break;
				default:
					$status = 'terjadi kesalahan';
					$textColor = 'text-danger';
					break;
			}
			$data[$key] = [
				$no,
				$value->company_id,
				$value->jenis_transaksi,
				$value->nama_usaha,
				'Rp ' . number_format($value->total_transfer, 0, ',', '.'),
				"<span class='$textColor font-weight-bold'>$status</span>",
				'<a href="' . base_url('pos/detailPencairan/' . $value->company_id) .'/'.$akhir.'/'.$jenis.'" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>',
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
	public function detailPencairan($company_id, $akhir, $jenis)
	{
		$pencairan['data'] = $this->pencairanModel->getdetail($company_id, $akhir, $jenis)->getResult();
		return view('pos/detailPencairan', $pencairan);
	}

	public function verifikasiPencairan()
	{
		
		$company_id = $this->request->getPost('company_id');
		$akhir = $this->request->getPost('akhir');
		$data = $this->pencairanModel->verifpencairantoko($company_id, $akhir);

		if ($data) {
			$this->session->setFlashdata('sukses', 'Toko dengan Company_id ' . $company_id . ' telah diverifikasi'); // tampilkan toast ke aplikasi
			$this->sendNotifToToko($company_id, 'Selamat, data anda sudah divalidasi. Silahkan Log Out dan Login kembali ke aplikasi untuk memulai aktifitas anda.'); //kirim notif ke rider
			return json_encode([
				'success' => true,
				'redirect' => base_url('pos/pencairan'),
				'driver' => $company_id
			]);
		}
		$pesan = $data['status'] == 1 ? "Pengajuan pencairan saldo telah diverifikasi" : "Pengajuan pencairan saldo ditangguhkan karena " . $data['pesan'] . ", mohon lengkapi persyaratan terlebih dahulu!";
	}

	public function cekStatus()
	{
		$id_penjualan = $this->request->getVar('id_penjualan');
		$id_driver = $this->request->getVar('id_driver');
		$isRejected = $this->TokoModel->db->query("SELECT * FROM t_penjualan_driver_batal WHERE id_penjualan = '$id_penjualan' AND id_driver='$id_driver'")->getNumRows();

		if ($isRejected > 0) {
			return json_encode([
				'isRejected' => true
			]);
		}

		return json_encode([
			"isRejected" => false
		]);
	}

	public function getBarang($jenis = null)
	{
		$search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');

		$result = $this->TokoModel->getbarang($search, $start, $limit, null, $jenis)->getResult();
		$totalCount = count($this->TokoModel->getbarang($search, '', '', '', $jenis)->getResultArray());

		$no = $start + 1;
		$data = [];

		foreach ($result as $key => $value) {
			switch ($value->status_barang) {
				case '0':
					$status = 'Non Aktif';
					$textColor = 'danger';
					break;
				case '1':
					$status = 'Aktif';
					$textColor = 'success';
					break;
				case '-1':
					$status = 'Non Verification';
					$textColor = 'warning';
					break;

				default:
					$status = 'terjadi kesalahan';
					$textColor = 'danger';
					break;
			}

			$data[$key] = [
				$no,
				$value->kd_barang,
				$value->nama,
				$value->kategori,
				$value->merk,
				$value->nama_usaha,
				$value->date_add,
				$value->date_modif,
				'<a href="' . base_url('pos/detailBarang/' . $value->code) . '" class="btn btn-'.$textColor.' btn-sm"><i class="fas fa-eye"></i></a>',
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
	public function getjmlbrng($jenis = null, $company_id = null)
	{
		// echo $company_id;
		$search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');

		$result = $this->TokoModel->getjmlbrng($search, $start, $limit, $company_id, null, $jenis)->getResult();
		$totalCount = count($this->TokoModel->getjmlbrng($search, '', '', '', '', $jenis)->getResultArray());

		$no = $start + 1;
		$data = [];

		
		foreach ($result as $key => $value) {
			switch ($value->status_barang) {
				case '0':
					$status = 'Non Aktif';
					$textColor = 'danger';
					break;
				case '1':
					$status = 'Aktif';
					$textColor = 'success';
					break;
				case '-1':
					$status = 'Non Verification';
					$textColor = 'warning';
					break;

				default:
					$status = 'terjadi kesalahan';
					$textColor = 'danger';
					break;
			}
			$foto_barang = file_exists(FCPATH . '/../back_end_mp/'.$value->company_id.'_config/images/' . $value->gambar . '') ? base_url() . '/../back_end_mp/'.$value->company_id.'_config/images/' . $value->gambar . '' : base_url() . '/assets/file-not-found.png';
			$data[$key] = [
				'<input type="checkbox" value="'.$value->code.'" >',
				$no,
				$value->kd_barang,
				$value->nama,
				$value->kategori,
				$value->merk,
				$value->nama_usaha,
				'
					<img class="img-thumbnail btn-dok" src="' . $foto_barang . '" data-title="Foto Barang" width="95%"/>
				',
				$value->date_add,
				'<a href="' . base_url('pos/detailBarang/' . $value->code) . '" class="btn btn-'.$textColor.' btn-sm"><i class="fas fa-eye"></i></a>',
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

	public function detailBarang($kd_barang)
	{
		$barang = $this->TokoModel->getbarang(null, null, null, $kd_barang)->getRowArray();

		// Foto Barang
		$foto_barang = file_exists(FCPATH . '/../back_end_mp/'.$barang['company_id'].'_config/images/' . $barang['gambar'] . '') ? base_url() . '/../back_end_mp/'.$barang['company_id'].'_config/images/' . $barang['gambar'] . '' : base_url() . '/assets/file-not-found.png';
		$data['barang'] = [
			'Kode Barang' => $barang['kd_barang'],
			'Nama Produk' => $barang['nama'],
			'Kategori  Barang' => $barang['kategori'],
			'Model Barang' => $barang['model'],
			'Merk Barang' => $barang['merk'],
			'Bahan' => $barang['bahan'],
			'Warna Barang' => $barang['warna'],
			'Ukuran Barang' => $barang['ukuran'],
			'Satuan' =>$barang['satuan'],
			'Nama Toko'  => $barang['nama_usaha'],
			'Keterangan' => $barang['keterangan'],
			'company_id' => $barang['company_id'],
			'Foto Barang' => 
			'
					<img class="img-thumbnail btn-dok" src="' . $foto_barang . '" data-title="Foto Barang" />
			'
		];

		$data['code'] = $barang['code'];
		$data['status_barang'] = $barang['status_barang'];
		return view('pos/barangdetail', $data);
	}

	public function verivikasiBarang()
	{
		$kd_barang = $this->request->getVar('kd_barang');
		$status = $this->request->getVar('status');
		$company_id = $this->request->getVar('id');
		$setStatus = $this->TokoModel->verivikasiBarang($status, $kd_barang);

		if ($setStatus == 'TRUE') {
			$this->session->setFlashdata('sukses', 'Barang dengan kode ' . implode(',', $kd_barang) . ' telah diverifikasi'); 
			$this->sendNotifToToko($kd_barang, 'Selamat, data anda sudah divalidasi. Silahkan Log Out dan Login kembali ke aplikasi untuk memulai aktifitas anda.'); 
			return json_encode([
				'success' => true,
				'redirect' => base_url('pos/barangc/'.$company_id),
				'company' => $kd_barang
			]);
		}
		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan validasi',
			'data' => $setStatus
		]);

	}
	public function induk($company_id, $akhir, $jenis)
	{
		$pencairan['data'] = $this->pencairanModel->induk($company_id, $akhir)->getResult();
		return view('pos/detailriwayat', $pencairan);
	}

}
