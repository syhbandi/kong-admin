<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\Ridertoko\Ridertoko;
use DateTime;

class Ridertokoon extends BaseController
{
    private $ridertokoModel;

    public function __construct()
    {
        $this->session = \Config\Services::session();
        if (!$this->session->has('login')) {
            header("Location: /login");
            die();
        }
        $this->ridertokoModel = new Ridertoko();
    }

    public function index()
    {
        return view('ridertokoon/rideron');
    }

    public function toko()
    {
        return view('ridertokoon/tokoon');
    }
    public function driver()
    {
        return view('ridertokoon/driveron');
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
            } else {
                if (date('Y-m-d', strtotime($value->date_modif)) == date('Y-m-d')) {
                    $tanggal = date_diff(date_create($value->date_modif), date_create());
                    $online = '' . $tanggal->h . ' jam, ' . $tanggal->i . ' menit yang lalu';
                    $text = 'text-danger';
                } else {
                    $tanggal = (new DateTime($value->date_modif))->diff(new DateTime(date('Y-m-d')))->days + 1;
                    $online = '' . $tanggal . ' hari yang lalu';
                    $text = 'text-danger';
                }
            }
            if ($value->jml_transaksi_rider == 0) {
                $transaksi = 'belum ada transaksi';
                $warna = 'text-warning';
            } else {
                $transaksi = $value->jml_transaksi_rider;
                $warna = 'text-dark';
            }
            $data[$key] = [
                $no,
                $value->nama_depan,
                $value->alamat_tinggal,
                $value->hp2,
                'Rp.'.$value->saldo,
                '<span class="' . $text . ' font-weight-bold">' . $online . '</span>',
                '<span class="' . $warna . ' font-weight-bold">' . $transaksi . '</span>',
                '<a href="https://wa.me/+62' . $value->hp2 . '?text=Selamat%20pagi/siang/sore/malam.%20Halo%20Kak%20'.$value->nama_depan.',%20kamu%20terlihat%20sudah%20'.$online.'%20hari%20tidak%20online%20nih%20di%20KongRider.
                Hayuk%20sekarang%20juga%20online%20kan%20aplikasi%20KongRider%20untuk%20mendapatkan%20orderan"><button class="btn btn-success btn-sm"><i class="fas fa-phone-alt mr-1"></i> WhatsApp</button></a>'
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
    public function getDriver($jenis = null)
    {
        $search = $this->request->getPost('search')['value'];
        $order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
        $start = $this->request->getPost('start');
        $limit = $this->request->getPost('length');

        $result = $this->ridertokoModel->getDriver($search, $start, $limit, $jenis)->getResult();
        $totalCount = count($this->ridertokoModel->getDriver($search, '', '', $jenis)->getResultArray());

        $no = $start + 1;
        $data = [];
        foreach ($result as $key => $value) {
            $status = $value->driver_state;
            if ($status == 1) {
                $online = 'Online';
                $text = 'text-success';
            } else {
                if (date('Y-m-d', strtotime($value->date_modif)) == date('Y-m-d')) {
                    $tanggal = date_diff(date_create($value->date_modif), date_create());
                    $online = '' . $tanggal->h . ' jam, ' . $tanggal->i . ' menit yang lalu';
                    $text = 'text-danger';
                } else {
                    $tanggal = (new DateTime($value->date_modif))->diff(new DateTime(date('Y-m-d')))->days + 1;
                    $online = '' . $tanggal . ' hari yang lalu';
                    $text = 'text-danger';
                }
            }
            if ($value->jml_transaksi_rider == 0) {
                $transaksi = 'belum ada transaksi';
                $warna = 'text-warning';
            } else {
                $transaksi = $value->jml_transaksi_rider;
                $warna = 'text-dark';
            }
            $data[$key] = [
                $no,
                $value->nama_depan,
                $value->alamat_tinggal,
                $value->hp2,
                '<span class="' . $text . ' font-weight-bold">' . $online . '</span>',
                '<span class="' . $warna . ' font-weight-bold">' . $transaksi . '</span>',
                '<a href="https://wa.me/' . $value->hp2 . '?text=Selamat%20pagi/siang/sore/malam.%20Halo%20Kak%20'.$value->nama_depan.',%20kamu%20terlihat%20sudah%20'.$online.'%20hari%20tidak%20online%20nih%20di%20KongRider.
                Hayuk%20sekarang%20juga%20online%20kan%20aplikasi%20KongRider%20untuk%20mendapatkan%20orderan"><button class="btn btn-success btn-sm"><i class="fas fa-phone-alt mr-1"></i> WhatsApp</button></a>'
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
    public function getToko($jenis = null)
    {
        $search = $this->request->getPost('search')['value'];
        $order = !empty($this->request->getPost('order')) ? $this->request->getPost('order') : '';
        $start = $this->request->getPost('start');
        $limit = $this->request->getPost('length');

        $result = $this->ridertokoModel->getToko($search, $start, $limit, $jenis)->getResult();
        $totalCount = count($this->ridertokoModel->getToko($search, '', '', $jenis)->getResultArray());

        $no = $start + 1;
        $data = [];
        foreach ($result as $key => $value) {
            if ($value->status == 1) {
                $online = 'Online';
                $text = 'text-success';
            } else {
                if (date('Y-m-d', strtotime($value->date_modif)) == date('Y-m-d')) {
                    $tanggal = date_diff(date_create($value->date_modif), date_create());
                    $online = '' . $tanggal->h . ' jam, ' . $tanggal->i . ' menit yang lalu';
                    $text = 'text-danger';
                } else {
                    $tanggal = (new DateTime($value->date_modif))->diff(new DateTime(date('Y-m-d')))->days + 1;
                    $online = '' . $tanggal . ' hari yang lalu';
                    $text = 'text-danger';
                }
            }
            if ($value->jml_transaksi == 0) {
                $transaksi = 'belum ada transaksi';
                $warna = 'text-warning';
            } else {
                $transaksi = $value->jml_transaksi;
                $warna = 'text-dark';
            }
            $data[$key] = [
                $no,
                $value->company_id,
                $value->nama_usaha,
                $value->alamat,
                $value->no_telepon,
                '<span class="' . $text . ' font-weight-bold">' . $online . '</span>',
                '<span class="' . $warna . ' font-weight-bold">' . $transaksi . '</span>',
                '<a href="https://wa.me/' . $value->no_telepon . '?text=Selamat%20pagi/siang/sore/malam%20halo%20mitra%20POS%20'.$value->nama_usaha.',%20terpantau%20tokomu%20'.$online.'%20ini%20tutup%20terus%20:(%20Yuk%20buka%20tokomu%20kembali%20agar%20omsetmu%20bertambah%20dan%20pelangganmu%20tidak%20sedih"><i class="fas fa-phone-alt mr-1"></i> WhatsApp</button></a>'
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
