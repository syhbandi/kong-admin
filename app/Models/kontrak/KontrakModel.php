<?php

namespace App\Models\kontrak;

use CodeIgniter\Model;

class KontrakModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'h_kontrak_request';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];


    public function getkontrak($cari = null, $start = null, $limit = null, $id_kontrak = null, $jenis = null)
    {
        $key = [
			"b.nama_usaha" => $cari,
			"c.tujuan" => $cari,
		];

		$builder = $this->db->table("h_kontrak_request a");

		if ($cari != null) {
			$builder->like("a.id", $cari);
			$builder->orLike($key);
		}

		$builder->select("a.kd_customer, a.kd_supplier, a.id, a.comp_id_sumber, a.comp_id_tujuan, b.nama_usaha, c.nama_usaha AS tujuan, a.`status`, a.tanggal_request, a.tanggal_response,
		a.tanggal_kontrak, a.tanggal_bayar, a.tanggal_konfirmasi, a.periode_bulan, 
		a.tanggal_jatuh_tempo, d.path_image, e.nominal, f.customer_user_company_id, g.supplier_user_company_id");
		$builder->join("m_user_company b", "a.comp_id_sumber = b.company_id", "INNER");
		$builder->join("m_user_company c", "a.comp_id_tujuan = c.company_id", "INNER");
		$builder->join("t_kontrak_doc d", "a.id = d.kontrak_id", "INNER");
		$builder->join("t_kontrak_pembayaran e", "a.id = e.kontrak_id", "INNER");
		$builder->join("misterkong_comp2020110310015601.m_customer_config f", "a.kd_customer = f.kd_customer", "INNER");
		$builder->join("misterkong_comp2020110310070901.m_supplier_config g", "a.kd_supplier = g.kd_supplier", "INNER");

		if ($id_kontrak != null) {
			$builder->where('a.id', $id_kontrak);
		}

		switch ($jenis) {
			case 'aktif':
				$builder->where("a.`status`", 4);
				break;
			case 'nonaktif':
				$builder->where("a.`status`", -2);
				break;
			default:
				break;
		}
		$builder->where("a.id != ", '');
		$builder->groupBy('a.id');

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}
		// echo $builder->getCompiledSelect();
		return $builder->get();
    } 
	public function updatekontrak($code_customer, $comp_customer, $code_supplier, $comp_suppiler, $id, $sumber, $tujuan)
	{
		try {
			$this->db->transBegin();

			$this->db->query("UPDATE misterkong_$sumber.m_customer_config SET status = 1 WHERE kd_customer = '$code_customer' AND customer_user_company_id = $comp_customer");
			$this->db->query("UPDATE misterkong_$tujuan.m_supplier_config SET status = 2 WHERE kd_supplier = '$code_supplier' AND supplier_user_company_id =  $comp_suppiler");
			$this->db->query("UPDATE t_kontrak SET status = 1 WHERE id = $id");
			$this->db->query("UPDATE h_kontrak_request SET status = 4 WHERE comp_id_sumber = '$sumber' AND comp_id_tujuan = $tujuan");

			$this->db->transCommit();
			if ($this->db->transStatus() == false) {
				return false;
			} else {
				return true;
			}
		} catch (\Throwable $e) {
			$this->db->transRollback();
            return $e->getMessage();
		}
	}
}
