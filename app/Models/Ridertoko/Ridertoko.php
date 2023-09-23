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
		];

		$builder = $this->db->table("m_driver a");

		if ($cari != null) {
			$builder->like("a.kd_driver", $cari);
			$builder->orLike($key);
		}

		$builder->select("a.nama_depan, a.alamat_tinggal, r.saldo, a.hp2, case when ISNULL(b.jml_transaksi) then 0 ELSE b.jml_transaksi 
		END AS jml_transaksi_rider, c.date_modif, c.driver_state, e.nama");
		$builder->join("(SELECT id_driver, COUNT(no_resi) AS jml_transaksi 
		FROM t_pengiriman GROUP BY id_driver) AS b", "a.kd_driver = b.id_driver", "LEFT");
		$builder->join("m_driver_location_log c", "a.kd_driver = c.kd_driver", "LEFT")->where('a.status', 3)->orderBy('a.kd_driver');
		$builder->join("(SELECT kd_jenis_kendaraan, kd_driver FROM m_driver_kendaraan GROUP BY kd_driver) d", "a.kd_driver = d.kd_driver", 'INNER');
		$builder->join("m_jenis_kendaraan e", "d.kd_jenis_kendaraan = e.id", "INNER");
		$builder->join("m_saldo_driver r", "a.kd_driver = r.kd_driver", "LEFT");
		$builder->where('e.id', 1);

		// if ($kd_driver != null) {
		// 	$builder->where('a.kd_driver', $kd_driver);
		// }
		switch ($jenis) {
			case 'aktif':
				$builder->where("c.driver_state", 1)->where("b.jml_transaksi IS NOT NULL");
				break;
			case 'offline':
				$builder->where("c.driver_state", 0)->where("r.saldo <>", 0);
				break;
			case 'transaksi':
				$builder->where("b.jml_transaksi", Null)->where("c.driver_state", 1);
				break;
			case 'nosaldo':
				$builder->where("r.saldo", 0);
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
		// echo $builder->getCompiledSelect();
		return $builder->get();
	}
	public function getDriver($cari = null, $start = null, $limit = null,  $jenis = null)
	{
		$key = [
			"a.nama_depan" => $cari,
			"a.alamat_tinggal" => $cari,
			"a.email" => $cari,
			"a.hp1" => $cari,
			"a.hp2" => $cari,
			"a.no_ktp" => $cari,
			"b.tahun_pembuatan" => $cari,
		];

		$builder = $this->db->table("m_driver a");

		if ($cari != null) {
			$builder->like("a.kd_driver", $cari);
			$builder->orLike($key);
		}

		$builder->select("a.nama_depan, a.alamat_tinggal, a.hp2, case when ISNULL(b.jml_transaksi) then 0 ELSE b.jml_transaksi 
		END AS jml_transaksi_rider, c.date_modif, c.driver_state, e.nama");
		$builder->join("(SELECT id_driver, COUNT(no_resi) AS jml_transaksi 
		FROM t_pengiriman GROUP BY id_driver) AS b", "a.kd_driver = b.id_driver", "LEFT");
		$builder->join("m_driver_location_log c", "a.kd_driver = c.kd_driver", "LEFT")->where('a.status', 3)->orderBy('a.kd_driver');
		$builder->join("(SELECT kd_jenis_kendaraan, kd_driver FROM m_driver_kendaraan GROUP BY kd_driver) d", "a.kd_driver = d.kd_driver", 'INNER');
		$builder->join("(SELECT nama, id FROM m_jenis_kendaraan WHERE id = 3 OR id = 2) e", "d.kd_jenis_kendaraan = e.id", "INNER");

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
	public function getToko($cari = null, $start = null, $limit = null, $jenis = null)
    {
        $key = [
            "a.nama_usaha" => $cari,
            "a.kategori_usaha" => $cari,
            "a.alamat" => $cari,
            "a.email_usaha" => $cari,
            "a.no_telepon" => $cari,
            "a.date_add" => $cari,
            "a.no_rek" => $cari,
        ];

        $builder = $this->db->table("m_user_company a");

        if ($cari != null) {
            $builder->like("a.company_id", $cari);
            $builder->orLike($key);
        }

        $builder->select("a.company_id, a.nama_usaha, a.alamat, a.no_telepon,a.status,a.date_modif,
		case
		when 
		ISNULL(b.transaksi) then 0 ELSE b.transaksi
		END AS jml_transaksi");
        $builder->join("(SELECT COUNT(no_transaksi) AS transaksi, user_id_toko FROM t_penjualan WHERE status_barang = 1 GROUP BY user_id_toko) b", "a.id = b.user_id_toko", "LEFT");

        switch ($jenis) {
            case 'aktif':
                $builder->where("a.`status`", 1)->where("b.transaksi IS NOT NULL");;
                break;
            case 'offline':
                $builder->where("a.`status`", 0);
                break;
            case 'transaksi':
                $builder->where("b.transaksi", Null)->where('a.`status`', 1);
                break;
            default:
                break;
        }

        if ($start != null && $limit != null) {
            $builder->limit($limit, $start);
        }
        // echo $sql = $builder->getCompiledSelect();
        return $builder->get();
    }
}
