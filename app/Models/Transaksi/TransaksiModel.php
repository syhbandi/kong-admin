<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class TransaksiModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_driver_zona';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'deskripsi', 'batas_bawah', 'batas_atas', 
        'fee_minim_bawah', 'fee_minim_atas', 'jarak_pertama',
    ];

    public function tarif($cari = null, $start = null, $limit = null, $id = null)
    {
        $key = [
			"t.deskripsi" => $cari,
            "t.batas_bawah" => $cari,
			"t.batas_atas" => $cari,
			"t.fee_minim_bawah" => $cari,
			"t.fee_minim_atas" => $cari,
            "t.jarak_pertama" => $cari,
            "u.lokasi" => $cari,
            "v.nama" => $cari,
		];

        $builder = $this->db->table("m_driver_zona t");

		if ($cari != null) {
			$builder->like("t.id", $cari);
			$builder->orLike($key);
		}

		$builder->select("t.id, t.deskripsi, t.batas_bawah, t.batas_atas, 
        t.fee_minim_bawah, t.fee_minim_atas, t.jarak_pertama,
        u.lokasi,v.nama");

		$builder->join("m_driver_zona_lokasi u", "t.zona_id = u.kd_lokasi", "INNER");
		$builder->join("m_app_zona g", "t.app_id = g.id", "INNER");
        $builder->join("m_jenis_kendaraan v", "t.jenis_kendaraan_id = v.id", "INNER");


        if($id != null){
            $builder->where('a.company_id', $id);
        }

        $builder->where("t.id != ", '');

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}
		return $builder->get();
    }
    
    public function getlok()
    {
        
    }
}
