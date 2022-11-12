<?php

namespace App\Models\Rider;

use CodeIgniter\Database\MySQLi\Builder;
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
	protected $allowedFields    = ['kd_driver', 'status'];

	public function getRider($cari = null, $start = null, $limit = null, $kd_driver = null, $jenis = null)
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

		$builder->select("a.kd_driver,a.nama_depan,a.alamat_tinggal,a.hp1,a.hp2,
		a.email,a.no_ktp,a.kd_zona,a.status,c.merk_nama,d.model_nama, 
		b.nomor_plat,b.tahun_pembuatan,b.STNK_expired,b.kd_kendaraan, g.tanggal, i.nama AS nama_attr, h.harga_jual, j.nama as ukuran,
		e.deskripsi, f.saldo, a.avatar_path, GROUP_CONCAT(g.bukti_bayar ORDER BY g.tanggal DESC LIMIT 1) AS bukti_bayar");
		$builder->join("m_driver_kendaraan b", "a.kd_driver = b.kd_driver", "INNER");
		$builder->join("m_merk_kendaraan AS c", "c.merk_id = b.kd_merk", "INNER");
		$builder->join("m_model_kendaraan AS d", "d.model_id = b.kd_model", "INNER");
		$builder->join("m_driver_zona AS e", "d.model_id = b.kd_model", "INNER");
		$builder->join("m_saldo_driver f", "a.kd_driver = f.kd_driver", 'LEFT');
		$builder->join("t_penjualan_attr g", "a.kd_driver = g.driver_id", "LEFT");
		$builder->join("t_penjualan_attr_detail h", "g.id = h.penjualan_attr_id", "LEFT");
		$builder->join("m_driver_attr i", "h.driver_attr_id = i.id", "INNER");
		$builder->join("m_satuan_driver_attr j", "h.satuan_driver_attr_id = j.id", "LEFT");
		if ($kd_driver != null) {
			$builder->where('a.kd_driver', $kd_driver);
		}

		// seleksi rider berdasarkan jenis (baru, aktif, nonaktif, banned)
		switch ($jenis) {
			case 'registrasi':
				$builder->where("a.`status`", -1)->orwhere("a.`status`", 2)->orwhere("a.`status`", 5);
				break;
			case 'validasid':
				$builder->where("a.`status`", 0);
				break;
			case 'pengajuan':
				$builder->where("a.`status`", 1);
				break;
			case 'aktif':
				$builder->where("a.`status`", 3);
				break;
			case 'validasip':
				$builder->where("a.`status`", 4);
				break;
			case 'vattr':
				$builder->where("a.`status`", 6);
				break;
			case 'banned':
				$builder->where("a.`status`", 99);
				break;

			default:
				break;
		}
		$builder->where("b.kd_kendaraan != ", '');
		$builder->groupBy('a.kd_driver');

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}
		// echo $sql = $builder->getCompiledSelect();
		return $builder->get();
	}

	public function getUser($cari = null, $start = null, $limit = null)
	{
		$key = [
			'nama' => $cari
		];

		$builder = $this->db->table("m_userx");

		if ($cari != null) {
			$builder->like("kd_user", $cari);
			$builder->orLike($key);
		}

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}

		return $builder->get();
	}

	public function getKendaraan($cari = null, $start = null, $limit = null, $kd_kedaraan = null, $jenis = null)
	{
		$key = [
			"a.nama_depan" => $cari,
			"b.nomor_plat" => $cari,
			"c.merk_nama" => $cari,
			"d.model_nama" => $cari,
			"b.tahun_pembuatan" => $cari,
		];

		$builder = $this->db->table("m_driver a");

		if ($cari != null) {
			$builder->like("kd_kendaraan", $cari);
			$builder->orLike($key);
		}

		$builder->select("a.nama_depan, b.nomor_plat, b.kd_kendaraan, b.tahun_pembuatan,
		b.`status`, c.merk_nama, d.model_nama");
		$builder->join("m_driver_kendaraan b", "a.kd_driver = b.kd_driver", "INNER");
		$builder->join("m_merk_kendaraan c", "c.merk_id = b.kd_merk", "INNER");
		$builder->join("m_model_kendaraan d", "d.model_id = b.kd_model", "INNER");

		if ($kd_kedaraan != null) {
			$builder->where('b.kd_kendaraan', $kd_kedaraan);
		}

		// seleksi rider berdasarkan jenis (baru, aktif, nonaktif, banned)
		switch ($jenis) {
			case 'baru':
				$builder->where("b.`status`", 0);
				break;
			case 'aktif':
				$builder->where("b.`status`", 1);
				break;
			case 'nonaktif':
				$builder->where("b.`status`", 2);
				break;
			case 'banned':
				$builder->where("b.`status`", -1);
				break;

			default:
				break;
		}
		$builder->where("b.kd_kendaraan != ", '');
		$builder->groupBy('b.kd_kendaraan');

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}

		return $builder->get();
	}

	public function getsim($kd_driver)
	{
		$builder = $this->db->query("SELECT * FROM m_driver_sim WHERE kd_driver = '$kd_driver'");
		return $builder->getResult();
	}
}