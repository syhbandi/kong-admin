<?php

namespace App\Controllers;
use App\Models\HomeModel;

class Home extends BaseController
{
    public function __construct()
	{
		$this->HomeModel = new HomeModel();
	}
    public function index()
    {
        $user_mp = $this->HomeModel->misterkong()->getRowArray();
        $user_pos = $this->HomeModel->kongpos()->getRowArray();
        $user_driver = $this->HomeModel->kongrider()->getRowArray();
        $barang = $this->HomeModel->barang()->getRowArray();
        $query = $this->HomeModel->query("SELECT m_driver_location_log.loc_lng, m_driver_location_log.loc_lat, m_driver_kendaraan.kd_jenis_kendaraan FROM m_driver_location_log INNER JOIN m_driver ON m_driver_location_log.kd_driver = m_driver.kd_driver 
        INNER JOIN m_driver_kendaraan ON m_driver.kd_driver = m_driver_kendaraan.kd_driver WHERE m_driver.status = 3 AND m_driver_location_log.driver_state = 1 AND m_driver_kendaraan.status = 2")->getResult();
        $data['user'] = [
            'user mp' => $user_mp['mp'],
            'user pos' => $user_pos['pos'],
            'user rider' => $user_driver['driver'],
            'barang' => $barang['barang'],
        ];
        $data['posisi'] = $query;
        // echo "<pre>";
        // print_r($data['posisi']);
        // echo "</pre>";
        return view('home', $data);
    }
    public function getrider()
    {
        $query = $this->HomeModel->query("SELECT loc_lng, loc_lat FROM m_driver_location_log")->getResult();
        foreach ($query as $key => $value) {
            $lat = $value->loc_lat;
            $lng = $value->loc_lng;
        }
        return view('home', $query);
    }
}
