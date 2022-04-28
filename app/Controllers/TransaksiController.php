<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Transaksi\TransaksiModel;

class TransaksiController extends BaseController
{
    public function index()
    {
        return view('transaksi/tarif');
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
				'<a href="#" class="btn btn-info btn-sm"><i class="fas fa-edit"></i></a>',
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
