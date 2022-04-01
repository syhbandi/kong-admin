<?php

namespace App\Models\Pos;

use CodeIgniter\Model;

class TokoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_user_company';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['company_id', 'status'];

    public function getToko($cari = null, $start = null, $limit = null, $company_id = null, $jenis = null, $id = null)
    {
        $key = [
			"a.nama_usaha" => $cari,
            "a.kategori_usaha" => $cari,
			"a.alamat" => $cari,
			"a.email_usaha" => $cari,
			"a.no_telepon" => $cari,
            "a.date_add" => $cari,
            "a.no_rek" => $cari,
            "b.province" => $cari,
            "c.nama" => $cari,
		];

        $builder = $this->db->table("m_user_company a");

		if ($cari != null) {
			$builder->like("company_id", $cari);
			$builder->orLike($key);
		}

		$builder->select("a.company_id, a.nama_usaha, d.nama as usaha, 
        a.alamat, a.email_usaha, a.no_telepon, a.date_add, a.no_rek,
        a.status, b.province, c.nama, f.nama_bank, a.no_rek, a.nama_pemilik_rekening,
        a.koordinat_lng, a.koordinat_lat");

		$builder->join("m_province b", "a.kd_provinsi = b.id", "INNER");
		$builder->join("m_userx AS c", "a.kd_user = c.id", "INNER");
        $builder->join("m_kategori_usaha AS d", "a.kategori_usaha = d.kd_kategori_usaha", "INNER");
        $builder->join("m_bank AS f", "a.kd_bank = f.kd_bank", "INNER");


        if($company_id != null){
            $builder->where('a.company_id', $company_id);
        }

        switch ($jenis) {
            case 'nonaktif':
                $builder->where("a.`status`", 0);
                break;
            
            case 'aktif':
                $builder->where("a.`status`", 1);
                break;

            default:
                break;
        }
        $builder->where("a.company_id != ", '');

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}
		return $builder->get();
    }
    public function version()
    {
       $builder = $this->db->table("g_app_version");
       $builder->select("*");
       return $builder->get();
    }

    public function updatev($id, $app_version)
    {
        $update = $this->db->query("UPDATE g_app_version SET app_store_version = '$app_version' WHERE id = '$id' ");
        
        // $q = ['id' => $id,];
        // $update = $this->db->update('g_app_version', $app_version, $q);
        
        return $update;
    }

    public function verivikasi($company_id)
    {
        $verivikasi = $this->db->query("UPDATE m_user_company SET status = '3' WHERE company_id = '$company_id'");
        return $verivikasi;
    }
}
