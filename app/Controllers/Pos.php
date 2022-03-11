<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\PencairanModel;

class Pos extends BaseController
{
	private $pencairanModel;

	public function __construct()
	{
		$this->pencairanModel = new PencairanModel();
	}

	public function index()
	{
		//
	}

	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
	// pencairan
	// ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++

	public function pencairan()
	{
		return view('pos/pencairanToko');
	}

	public function getPencairan($status = null)
	{
		$search = $this->request->getPost('search')['value'];
		$order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
		$start = $this->request->getPost('start');
		$limit = $this->request->getPost('length');

		$result = $this->pencairanModel->getPencairan($search, $start, $limit, '1', $status)->getResult();
		$totalCount = count($this->pencairanModel->getPencairan($search, '', '', '1', $status)->getResultArray());

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
				$value->nama_usaha,
				'Rp ' . number_format($value->saldo, 0, ',', '.'),
				'Rp ' . number_format($value->nominal, 0, ',', '.'),
				$value->nama_bank,
				$value->no_rek_tujuan . '<br> A.N ' . $value->atas_nama,
				"<span class='$textColor font-weight-bold'>$status</span>",
				'<a href="' . base_url('pos/pencairan/' . $value->no_transaksi) . '" class="btn btn-info btn-sm"><i class="fas fa-eye"></i></a>',
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
		$pencairan = $this->pencairanModel->getPencairan('', '', '', '1', '', $no_transaksi)->getRow();

		$data['dataPencairan'] = $pencairan;
		// hanya utk tampilan
		$data['pencairan'] = [
			'no transaksi' => $pencairan->no_transaksi,
			'nama usaha' => $pencairan->nama_depan,
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
		$data = $this->request->getPost();

		$pesan = $data['status'] == 1 ? "Pengajuan pencairan saldo telah diverifikasi" : "Pengajuan pencairan saldo ditangguhkan karena " . $data['pesan'] . ", mohon lengkapi persyaratan terlebih dahulu!";
	}

	public function cekStatus()
	{
		$id_penjualan = $this->request->getVar('id_penjualan');
		$id_driver = $this->request->getVar('id_driver');
		$isRejected = $this->pencairanModel->db->query("SELECT * FROM t_penjualan_driver_batal WHERE id_penjualan = '$id_penjualan' AND id_driver='$id_driver'")->getNumRows();

		if ($isRejected > 0) {
			return json_encode([
				'isRejected' => true
			]);
		}

		return json_encode([
			"isRejected" => false
		]);
	}
}
