<?php

namespace App\Models\Misterkong;

use CodeIgniter\Model;

class UserMpModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_userx';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function getuser($cari = null, $start = null, $limit = null, $kd_user = null, $jenis = null, $id = null)
    {
        $key = [
			"nama" => $cari,
            "no_hp" => $cari,
			"kd_user" => $cari,
			"email" => $cari,
		];

        $builder = $this->db->table('m_userx a');

		if ($cari != null) {
			$builder->like("kd_user", $cari);
			$builder->orLike($key);
		}

		$builder->select('a.kd_user, a.nama, a.no_hp, a.email, a.date_add, a.`status`, a.no_rek, b.nama_bank');
        $builder->join("m_bank b", "a.kd_bank = b.kd_bank", "LEFT");
        $builder->where('kd_group', '2');

        if($kd_user != null){
            $builder->where('kd_user', $kd_user);
        }

        switch ($jenis) {
            case 'nonaktif':
                $builder->where("`status`", 0);
                break;
            
            case 'aktif':
                $builder->where("`status`", 1);
                break;

            default:
                break;
        }
        $builder->where("kd_user != ", '');

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}
		return $builder->get();
    }

    public function updatev($kd_user, $nama, $no_hp, $email, $rekening, $norek)
    {
        $update = $this->db->query("UPDATE m_userx SET nama = '$nama', no_hp= '$no_hp', email = '$email',
                                         kd_bank = '$rekening', no_rek = '$norek' WHERE kd_user = '$kd_user' ");
        return $update;
    }
    
}
