<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Rider\PencairanModel;
use App\Models\Rider\RiderModel;
use App\Models\Rider\TopUpModel;

class Rider extends BaseController
{
	private $riderModel;
	private $topUpModel;
	private $pencairanModel;

	public function __construct()
	{
		$this->riderModel = new RiderModel();
		$this->topUpModel = new TopUpModel();
		$this->pencairanModel = new PencairanModel();
	}

	// ========================================================================================================================================
	// Fitur verifikasi pendaftaran Rider
	// ========================================================================================================================================

	public function index()
	{
		return view('rider/dataRider');
	}

	public function getRider($jenis = null)
	{
		$search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');

		$result = $this->riderModel->getRider($search, $start, $limit, null, $jenis)->getResult();
		$totalCount = count($this->riderModel->getRider($search, '', '', '', $jenis)->getResultArray());

		$no = $start + 1;
		$data = [];

		foreach ($result as $key => $value) {
			switch ($value->status) {
				case '-1':
					$status = 'Pre Registrasi';
					$text = 'text-dark';
					break;
				case '0':
					$status = 'Telah Registrasi';
					$text = 'text-danger';
					break;
				case '1':
					$status = 'Pengajuan';
					$text = 'text-indigo';
					break;
				case '2':
					$status = 'Pengembalian';
					$text = 'text-warning';
					break;
				case '3':
					$status = 'Aktif';
					$text = 'text-success';
					break;

				default:
					$status = 'Nonaktif';
					$text = 'text-gray';
					break;
			}

			$data[$key] = [
				$no,
				$value->no_ktp,
				$value->nama_depan,
				$value->alamat_tinggal,
				$value->hp1 . "<br>" . $value->hp2,
				$value->email,
				'<span class="' . $text . ' font-weight-bold">' . $status . '</span>',
				'<a href="' . base_url('rider/detail/' . $value->kd_driver) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>',
				$jenis == 'baru' ? '<button class="btn btn-primary btn-sm verifikasi" data-driver="' . $value->kd_driver . '"><i class="fas fa-check mr-1"></i> Verifikasi</button>' : '',
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

	public function detail($kd_driver)
	{
		$rider = $this->riderModel->getRider(null, null, null, $kd_driver)->getRowArray();
		$tahun_lahir = substr($rider['no_ktp'], 10, 2);
		$data['rider'] = [
			'No. Ktp' => $rider['no_ktp'],
			'Nama Rider' => $rider['nama_depan'],
			'Tgl. Lahir' => substr($rider["no_ktp"], 6, 2) . '-' . substr($rider["no_ktp"], 8, 2) . '-' . (date('y') - intval($tahun_lahir) <= 0 ? '19' . $tahun_lahir : '20' . $tahun_lahir),
			'Jenis Kelamin' => intval(substr($rider['no_ktp'], 6, 2)) > 40 ? 'Perempuan' : 'Laki-laki',
			'Alamat' => $rider['alamat_tinggal'],
			'No. Hp' => $rider['hp1'] . ' - ' . $rider['hp2'],
			'Email' => $rider['email'],
			'Zona' => $rider['deskripsi'],
			'Merk Kendaraan' => $rider['merk_nama'],
			'Model' => $rider['model_nama'],
			'Plat Nomor' => $rider['nomor_plat'],
			'Tahun Pembuatan' => $rider['tahun_pembuatan'],
			'Tgl Kadaluarsa STNK' => date('d/m/Y', strtotime($rider['STNK_expired'])),
			'Dokumen Data Diri' =>
			'
					<button class="btn bg-navy btn-sm btn-dok" data-source="https://www.misterkong.com/kajek/images/ktp/' . $rider['kd_driver'] . 'ktp.jpg">Foto KTP</button>
					<button class="btn bg-navy btn-sm btn-dok" data-source="https://www.misterkong.com/kajek/images/sim/' . $rider['kd_driver'] . 'sim.jpg">Foto SIM</button>
					<button class="btn bg-navy btn-sm btn-dok" data-source="https://www.misterkong.com/kajek/images/skck/' . $rider['kd_driver'] . 'skck.jpg">Foto skck</button>
			',
			'Dokumen Data Kendaraan' =>
			'
				<button class="btn bg-navy btn-sm btn-dok" data-source="https://www.misterkong.com/kajek/images/kendaraan/' . $rider['kd_kendaraan'] . $rider['kd_driver'] . 'stnk.jpg">Foto STNK</button>
				<button class="btn bg-navy btn-sm btn-dok" data-source="https://www.misterkong.com/kajek/images/kendaraan/' . $rider['kd_kendaraan'] . $rider['kd_driver'] . 'depan.jpg">Foto Tampak Depan</button>
				<button class="btn bg-navy btn-sm btn-dok" data-source="https://www.misterkong.com/kajek/images/kendaraan/' . $rider['kd_kendaraan'] . $rider['kd_driver'] . 'kanan.jpg">Foto Tampak Kanan</button>
				<button class="btn bg-navy btn-sm btn-dok" data-source="https://www.misterkong.com/kajek/images/kendaraan/' . $rider['kd_kendaraan'] . $rider['kd_driver'] . 'kiri.jpg">Foto Tampak Kiri</button>
			',
		];
		$data['kd_driver'] = $rider['kd_driver'];
		$data['status'] = $rider['status'];
		return view('rider/detailRider', $data);
	}

	public function verifikasi()
	{
		$kd_driver = $this->request->getPost('kd_driver'); // ambil kode driver dari request 
		$setLocation = $this->riderModel->db->query("UPDATE m_driver_location_log SET driver_state=1 WHERE kd_driver='$kd_driver'"); // update driver location log
		$setStatus = $this->riderModel->update($kd_driver, ['status' => '3']); // update status rider menjadi 3 (aktif)

		if ($setStatus && $setLocation) {
			$this->session->setFlashdata('sukses', 'Rider dengan id ' . $kd_driver . ' telah diverifikasi'); // tampilkan toast ke aplikasi
			$this->sendNotifToRider($kd_driver, 'Selamat, data anda sudah divalidasi. Silahkan Log Out dan Login kembali ke aplikasi untuk memulai aktifitas anda.'); //kirim notif ke rider
			return json_encode([
				'success' => true,
				'redirect' => base_url('rider'),
				'driver' => $kd_driver
			]);
		}

		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan validasi'
		]);
	}

	public function perbaikan()
	{
		$kd_driver = $this->request->getPost('kd_driver');
		$pesan = $this->request->getPost('pesan'); //pesan perbaikan
		$updateStatus = $this->riderModel->update($kd_driver, ['status' => '2']);

		if ($updateStatus) {
			$this->session->setFlashdata('sukses', 'Rider dengan id ' . $kd_driver . ' telah dikirimi pengajuan perbaikan data'); // tampilkan toast ke aplikasi
			$this->sendNotifToRider($kd_driver, $pesan); //kirim notif ke rider
			return json_encode([
				'success' => true,
				'redirect' => base_url('rider')
			]);
		}

		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan pengajuan perbaikan'
		]);
	}

	// ==========================================================================================================================================
	// Fitur verifikasi top up rider
	// ==========================================================================================================================================

	public function topUp()
	{
		return view('rider/topUp');
	}

	public function getTopUp($jenis = null)
	{
		$search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');

		$result = $this->topUpModel->getData($search, $start, $limit, $jenis)->getResult();
		$totalCount = count($this->topUpModel->getData($search, '', '', $jenis)->getResultArray());

		$no = $start + 1;
		$data = [];

		foreach ($result as $key => $value) {
			switch ($value->approve_state) {
				case '-1':
					$status = 'Belum Verifikasi';
					$textColor = 'text-danger';
					break;
				case '0':
					$status = 'Ditolak';
					$textColor = 'text-navy';
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
				$value->nama_depan,
				$value->hp1 . "<br>" . $value->hp2,
				'Rp ' . number_format($value->nominal, 0, ',', '.'),
				date('d/m/Y', strtotime($value->createat)),
				"<span class='$textColor font-weight-bold'>$status</span>",
				'<a href="' . base_url('rider/top-up/detail/' . $value->top_id) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>',
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

	public function detailTopUp($top_id)
	{
		$topUp = $this->topUpModel->getData('', '', '', '', $top_id)->getRow();
		$data['dataTopUp'] = $topUp;
		$disable = $topUp->filepath == '' ? 'disabled' : '';
		$data['topUp'] = [
			'Kode Top Up' => $topUp->top_id,
			'Nama Rider' => $topUp->nama_depan,
			'No. Hp' => $topUp->hp1 . ' - ' . $topUp->hp2,
			'Jumlah Top Up' => 'Rp ' . number_format($topUp->nominal, 0, ',', '.'),
			'Tanggal Top Up' => date('d/m/Y', strtotime($topUp->createat)),
			'Status' => ($topUp->approve_state == '-1' ? 'belum verifikasi' : ($topUp->approve_state == '1' ? 'Sudah diverifikasi' : 'Ditolak')),
			'Verifikasi Oleh' => $topUp->approveby ?? '-',
			'bukti Top Up' => '<button class="btn bg-navy btn-sm btn-dok" data-source="https://www.misterkong.com/kajek/images/' . $topUp->filepath . '" ' . $disable . '>Foto Bukti</button>',
		];

		return view('rider/detailTopUp', $data);
	}

	public function verifikasiTopUp()
	{
		$top_id = $this->request->getPost('top_id');
		$kd_driver = $this->request->getPost('kd_driver');
		$status = $this->request->getPost('status');
		$pesan = $status == 1 ? 'Top Up sudah diverifikasi, selamat bekerja!' : 'Top up ditolak karena ' . $this->request->getPost('pesan');

		$approved = $this->topUpModel->update($top_id, ['approveat' => date('Y-m-d H:i:s'), 'approve_state' => $status, 'approveby' => '1']);
		if ($approved) {
			$this->session->setFlashdata('sukses', $status == 1 ? 'Top Up diverifikasi' : 'Top Up ditolak'); // tampilkan toast ke aplikasi
			$this->sendNotifToRider($kd_driver, $pesan); //kirim notif ke rider
			return json_encode([
				'success' => true,
				'redirect' => base_url('rider/top-up'),
			]);
		}

		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan verifikasi top up'
		]);
	}

	// ===========================================================================================================================================
	// fitur pencairan saldo
	// ===========================================================================================================================================

	public function pencairan()
	{
		return view('rider/pencairanRider');
	}

	public function getPencairan($jenis, $status = null)
	{
		$search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');

		$result = $this->pencairanModel->getPencairan($search, $start, $limit, $jenis, $status)->getResult();
		$totalCount = count($this->pencairanModel->getPencairan($search, '', '', $jenis, $status)->getResultArray());

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
				$value->no_transaksi,
				$value->nama_depan,
				'Rp ' . number_format($value->nominal, 0, ',', '.'),
				$value->nama_bank,
				$value->no_rek_tujuan . '<br> A.N ' . $value->atas_nama,
				"<span class='$textColor font-weight-bold'>$status</span>",
				'<a href="' . base_url('rider/pencairan/detail/' . $value->no_transaksi) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>',
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

	public function detailPencairan($no_transaksi)
	{
		$pencairan = $this->pencairanModel->getPencairan('', '', '', '2', '', $no_transaksi)->getRow();

		$data['no_transaksi'] = $pencairan->no_transaksi;
		$data['kd_driver'] = $pencairan->id;
		$data['approveAt'] = $pencairan->approveat;
		$data['status'] = $pencairan->status;

		// hanya utk tampilan
		$data['pencairan'] = [
			'no transaksi' => $pencairan->no_transaksi,
			'nama rider' => $pencairan->nama_depan,
			'jumlah penarikan' => 'Rp ' . number_format($pencairan->nominal, 0, ',', '.'),
			'bank tujuan' => $pencairan->nama_bank,
			'rekening tujuan' => $pencairan->no_rek_tujuan . ' atas nama ' . strtoupper($pencairan->atas_nama),
			'tanggal pengajuan pencairan' => date('d/m/Y', strtotime($pencairan->tanggal)),
			'status' => $pencairan->status == 0 ? 'Belum diverifikasi' : 'Diterima',
			'keterangan' => $pencairan->keterangan ?? '-',
		];


		return view('rider/detailPencairan', $data);
	}

	public function verifikasiPencairan()
	{
		$no_transaksi = $this->request->getPost('no_transaksi');
		$kd_driver = $this->request->getPost('kd_driver');
		$status = $this->request->getPost('status');
		$pesan = $status == 1 ? 'Pengajuan pencairan saldo sudah diverifikasi' : 'Pengajuan pencairan saldo ditangguhkan karena ' . $this->request->getPost('pesan') . ', proses pencairan akan diproses apabila permohonan valid';

		$approved = $this->pencairanModel->update($no_transaksi, ['approveat' => date('Y-m-d H:i:s'), 'status' => $status,]);
		$pencairanValidasi = $this->pencairanModel->find($no_transaksi);
		$insertPencairan = $this->pencairanModel->insertPenarikan([
			'no_transaksi' => $pencairanValidasi["no_transaksi"],
			'tanggal' => date('Y-m-d H:i:s'),
			'id' => $pencairanValidasi["id"],
			'jenis_user' => $pencairanValidasi["jenis_user"],
			'nominal' => $pencairanValidasi["nominal"],
			'kd_bank' => $pencairanValidasi["kd_bank"],
			'no_rek_tujuan' => $pencairanValidasi["no_rek_tujuan"],
			'atas_nama' => strtoupper($pencairanValidasi["atas_nama"]),
		]);
		if ($approved && $insertPencairan) {
			$this->session->setFlashdata('sukses', $status == 1 ? 'Pengajuan pencairan diverifikasi' : 'pengajuan pencairan ditangguhkan'); // tampilkan toast ke aplikasi
			$this->sendNotifToRider($kd_driver, $pesan); //kirim notif ke rider
			return json_encode([
				'success' => true,
				'redirect' => base_url('rider/pencairan'),
			]);
		}

		return json_encode([
			'success' => false,
			'msg' => 'Gagal melakukan verifikasi pencairan'
		]);
	}


	// fungsi utk kirim notif ke aplikasi rider
	public function sendNotifToRider($kd_driver, $pesan)
	{
		$payload = array(
			'to' => '/topics/kongVal',
			'priority' => 'high',
			"mutable_content" => true,
			'data' => array(
				"id_dr" => $kd_driver,
				"psn" => $pesan
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
