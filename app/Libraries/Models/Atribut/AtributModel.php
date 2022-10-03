<?php

namespace App\Models\Atribut;

use CodeIgniter\Model;

class AtributModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'atributs';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function getbank($cari = null, $start = null, $limit = null, $kd_bank = null)
    {
        $key = [
			"kd_bank" => $cari,
            "nama_bank" => $cari,
		];

        $builder = $this->db->table("m_bank");

		if ($cari != null) {
			$builder->like("kd_bank", $cari);
			$builder->orLike($key);
		}

		$builder->select("*");

        if($kd_bank != null){
            $builder->where('kd_bank', $kd_bank);
        }

        $builder->where("kd_bank != ", '');

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}
		return $builder->get();
    }
    public function getattr($cari = null, $start = null, $limit = null, $kd_attr = null)
    {
        $key = [
			"b.driver_attr_id" => $cari,
			"a.nama" => $cari,
		];

        $builder = $this->db->table("m_driver_attr a");

		if ($cari != null) {
			$builder->like("b.driver_attr_id", $cari);
			$builder->orLike($key);
		}

		$builder->select("a.nama, a.`status` AS jenis, a.keterangan, b.*");
		$builder->join("m_driver_attr_satuan b", "a.id = b.driver_attr_id", "INNER");

        if($kd_attr != null){
            $builder->where('b.driver_attr_id', $kd_attr);
        }

        $builder->where("b.driver_attr_id != ", '');

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}
		return $builder->get();
    }
    public function updat_attr($code, $harga)
    {
        $update = $this->db->query("UPDATE m_driver_attr_satuan SET 
                                     harga_jual = ".$this->db->escape($harga)."
                                     WHERE driver_attr_id = '$code' ");
        
        return $update;
    }
}
