<?php

namespace App\Models\Rider;

use CodeIgniter\Model;
use phpDocumentor\Reflection\Types\This;

class RiderModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_driver';
    protected $primaryKey       = 'kd_driver';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function getBaru($cari = null, $start = null, $limit = null)
    {
        $key = [
            "a.nama_depan" => $cari,
            "a.alamat_tinggal" => $cari,
            "a.email" => $cari,
            "a.hp1" => $cari,
            "a.hp2" => $cari,
            "a.no_ktp" => $cari,
            "b.nomor_plat" => $cari,
            "b.merk_nama" => $cari,
            "b.model_nama" => $cari,
            "b.tahun_pembuatan" => $cari,
        ];

        $builder = $this->db->table("m_driver a");

        if ($cari != '') {
            $builder->like("kd_driver", $cari);
            $builder->orLike($key);
        }

        $builder->select("a.kd_driver,a.nama_depan,a.alamat_tinggal,a.hp1,a.hp2,a.email,a.no_ktp,a.kd_zona,c.merk_nama,d.model_nama, b.nomor_plat,b.tahun_pembuatan,b.STNK_expired,b.kd_kendaraan");
        $builder->join("m_driver_kendaraan b", "a.kd_driver = b.kd_driver", "INNER");
        $builder->join("m_merk_kendaraan AS c", "c.merk_id = b.kd_merk", "INNER");
        $builder->join("m_model_kendaraan AS d", "d.model_id = b.kd_model", "INNER");
        $builder->where("a.`status` =0 OR a.`status` =1 OR a.`status`!=3 AND b.kd_kendaraan!='' GROUP BY a.kd_driver");
        $builder->limit($limit, $start);
        return $builder->get();
    }
}
