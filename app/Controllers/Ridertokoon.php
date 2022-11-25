<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Ridertoko\Ridertoko;

class Ridertokoon extends BaseController
{
    private $ridertokoModel;

    public function __construct()
    {
        $this->ridertokoModel = new Ridertoko();
    }

    public function index()
    {
        return view('ridertokoon/rideron');
    }

    public function getRider($jenis = null)
    {
        $search = $this->request->getPost('search')['value'];
        $order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
        $start = $this->request->getPost('start');
        $limit = $this->request->getPost('length');

        $result = $this->ridertokoModel->getRider($search, $start, $limit, $jenis)->getResult();
        $totalCount = count($this->ridertokoModel->getRider($search, '', '', $jenis)->getResultArray());

        $no = $start + 1;
        $data = [];
        foreach ($result as $key => $value) {
            $status = $value->driver_state;
            if ($status == 1) {
                $online = 'Online';
                $text = 'text-success';
            }else {
                $tanggal = date_diff(date_create($value->terakhir_online), date_create());
                $online = $tanggal->format('Terakhir Online %d Hari Lalu');
                $text = 'text-danger';
            }
            if ($value->jml_transaksi_rider == 0) {
                $transaksi = 'belum ada transaksi';
                $warna = 'text-warning';
            }else {
                $transaksi = $value->jml_transaksi_rider;
                $warna = 'text-dark';
            }
            $data[$key] = [
                $no,
                $value->nama_depan,
                $value->alamat_tinggal,
                $value->hp2,
                $value->terakhir_online,
                '<span class="' . $text . ' font-weight-bold">' . $online . '</span>',
                '<span class="' . $warna . ' font-weight-bold">' . $transaksi . '</span>',
                '<button class="btn btn-success btn-sm"><i class="fas fa-phone-alt mr-1"></i> WhatsApp</button>'
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
