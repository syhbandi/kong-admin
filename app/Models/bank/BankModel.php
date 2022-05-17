<?php

namespace App\Models\bank;

use CodeIgniter\Model;

class BankModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_bank';
    protected $primaryKey       = 'kd_bank';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'kd_bank', 'nama_bank',
    ];

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

    public function updatebank($code, $kd_bank, $nama_bank)
    {
        $update = $this->db->query("UPDATE m_bank SET 
                                     kd_bank = ".$this->db->escape($kd_bank).", 
                                     nama_bank = ".$this->db->escape($nama_bank)."
                                     WHERE kd_bank = '$code' ");
        
        return $update;
    }

    public function insertb($kd_bank, $nama_bank)
    {
        $insert = $this->db->query("INSERT INTO m_bank(kd_bank, nama_bank) VALUES(".$this->db->escape($kd_bank).", ".$this->db->escape($nama_bank)." )");

        return $insert;
    }
}

