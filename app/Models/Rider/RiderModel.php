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
			"b.merk_nama" => $cari,
			"b.model_nama" => $cari,
			"b.tahun_pembuatan" => $cari,
		];

		$builder = $this->db->table("m_driver a");

		if ($cari != null) {
			$builder->like("kd_driver", $cari);
			$builder->orLike($key);
		}

		$builder->select("a.kd_driver,a.nama_depan,a.alamat_tinggal,a.hp1,a.hp2,a.email,a.no_ktp,a.kd_zona,a.status,c.merk_nama,d.model_nama, b.nomor_plat,b.tahun_pembuatan,b.STNK_expired,b.kd_kendaraan,e.deskripsi");
		$builder->join("m_driver_kendaraan b", "a.kd_driver = b.kd_driver", "INNER");
		$builder->join("m_merk_kendaraan AS c", "c.merk_id = b.kd_merk", "INNER");
		$builder->join("m_model_kendaraan AS d", "d.model_id = b.kd_model", "INNER");
		$builder->join("m_driver_zona AS e", "d.model_id = b.kd_model", "INNER");

		if ($kd_driver != null) {
			$builder->where('a.kd_driver', $kd_driver);
		}

		// seleksi rider berdasarkan jenis (baru, aktif, nonaktif, banned)
		switch ($jenis) {
			case 'baru':
				$builder->where("a.`status` =0 OR a.`status` =1 OR a.`status`!=3 AND b.kd_kendaraan!=''");
				break;
			case 'aktif':
				$builder->where("a.`status` =3 AND b.kd_kendaraan!=''");
				break;
			case 'nonaktif':
				$builder->where("a.`status` =-2 AND b.kd_kendaraan!=''");
				break;
			case 'banned':
				$builder->where("a.`status` =-3 AND b.kd_kendaraan!=''");
				break;

			default:
				break;
		}

		$builder->groupBy('a.kd_driver');

		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}



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
}
