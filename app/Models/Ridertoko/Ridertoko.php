<?php

namespace App\Models\Ridertoko;

use CodeIgniter\Model;

class Ridertoko extends Model
{
    protected $DBGroup          = 'default';
	protected $table            = 'm_driver';
	protected $primaryKey       = 'kd_driver';
	protected $useAutoIncrement = false;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = ['kd_driver', 'status'];

    public function getRider($cari = null, $start = null, $limit = null,  $jenis = null)
	{
		$key = [
			"a.nama_depan" => $cari,
			"a.alamat_tinggal" => $cari,
			"a.email" => $cari,
			"a.hp1" => $cari,
			"a.hp2" => $cari,
			"a.no_ktp" => $cari,
			"b.nomor_plat" => $cari,
			"b.tahun_pembuatan" => $cari,
		];

		$builder = $this->db->table("m_driver a");

		if ($cari != null) {
			$builder->like("a.kd_driver", $cari);
			$builder->orLike($key);
		}

		$builder->select("a.nama_depan, a.alamat_tinggal, a.hp2, case when ISNULL(b.jml_transaksi) then 0 ELSE b.jml_transaksi 
		END AS jml_transaksi_rider, c.terakhir_online, c.driver_state");
		$builder->join("(SELECT id_driver, COUNT(no_resi) AS jml_transaksi 
		FROM t_pengiriman GROUP BY id_driver) AS b", "a.kd_driver = b.id_driver", "LEFT");
		$builder->join("(SELECT driver_state, kd_driver, DATE_ADD(NOW(), INTERVAL -5 DAY) AS terakhir_online FROM m_driver_location_log GROUP BY kd_driver)
		AS c", "a.kd_driver = c.kd_driver", "LEFT")->where('a.status', 3)->orderBy('a.kd_driver');

		// if ($kd_driver != null) {
		// 	$builder->where('a.kd_driver', $kd_driver);
		// }
		switch ($jenis) {
			case 'aktif':
				$builder->where("c.driver_state", 1)->where("b.jml_transaksi IS NOT NULL");
				break;
			case 'offline':
				$builder->where("c.driver_state", 0);
				break;
			case 'transaksi':
				$builder->where("b.jml_transaksi", Null)->where("c.driver_state", 1);
				break;
			default:
				break;
		}
		// seleksi rider berdasarkan jenis (baru, aktif, nonaktif, banned)
		// $builder->where("a. != ", '');
		// $builder->groupBy('a.kd_driver');

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}
		// echo $sql = $builder->getCompiledSelect();
		return $builder->get();
	}
}
