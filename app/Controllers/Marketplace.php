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
        
}