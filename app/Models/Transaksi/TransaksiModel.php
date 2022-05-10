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

		$builder->select("t.id, t.zona_id, t.app_id, t.jenis_kendaraan_id, t.deskripsi, t.batas_bawah, t.batas_atas, 
        t.fee_minim_bawah, t.fee_minim_atas, t.jarak_pertama,
        u.lokasi, v.nama, g.app_name");

		$builder->join("m_driver_zona_lokasi u", "t.zona_id = u.kd_lokasi", "INNER");
		$builder->join("m_app_zona g", "t.app_id = g.id", "INNER");
        $builder->join("m_jenis_kendaraan v", "t.jenis_kendaraan_id = v.id", "INNER");


        if($id != null){
            $builder->where('t.id', $id);
        }

        $builder->where("t.id != ", '');

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}
		return $builder->get();
    }
    
    public function updatezona($id, $zona, $app, $kendaraan, $deskripsi, $bawah, $atas, $feeb, $feea, $jarak)
    {
        $update = $this->db->query("UPDATE m_driver_zona SET zona_id = ".$this->db->escape($zona).", app_id= ".$this->db->escape($app).", jenis_kendaraan_id = ".$this->db->escape($kendaraan).",
                                         deskripsi = ".$this->db->escape($deskripsi).", batas_bawah = ".$this->db->escape($bawah).", batas_atas = ".$this->db->escape($atas).", 
                                         fee_minim_bawah = ".$this->db->escape($feeb).", fee_minim_atas = ".$this->db->escape($feea).", jarak_pertama = '$jarak' WHERE id = $id ");
        return $update;
    }

    public function getlokasi()
    {
        $builder = $this->db->table('m_driver_zona_lokasi');
        $builder->select('kd_lokasi, lokasi');

        return $builder->get();
    }

    public function addzona($zona, $app, $kendaraan, $deskripsi, $bawah, $atas, $feeb, $feea, $jarak)
    {
        $insert = $this->db->query("INSERT INTO m_driver_zona(zona_id, app_id, jenis_kendaraan_id, 
		deskripsi, batas_bawah, batas_atas, fee_minim_bawah, fee_minim_atas, jarak_pertama)
		VALUES(".$this->db->escape($zona).",".$this->db->escape($app).", ".$this->db->escape($kendaraan).", 
		".$this->db->escape($deskripsi).", ".$this->db->escape($bawah).", ".$this->db->escape($atas).",
		".$this->db->escape($feeb).", ".$this->db->escape($feea).",".$this->db->escape($jarak).")");
    }
}
