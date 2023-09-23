<?php

namespace App\Models;

use CodeIgniter\Model;

class PencairanModel extends Model
{
	protected $DBGroup          = 'default';
	protected $table            = 't_penarikan_validasi';
	protected $primaryKey       = 'no_transaksi';
	protected $useAutoIncrement = true;
	protected $insertID         = 0;
	protected $returnType       = 'array';
	protected $useSoftDeletes   = false;
	protected $protectFields    = true;
	protected $allowedFields    = [
		'no_transaksi',
		'status',
		'approveat',
	];

	// Dates
	protected $useTimestamps = false;
	protected $dateFormat    = 'datetime';
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
	protected $deletedField  = 'deleted_at';

	// Validation
	protected $validationRules      = [];
	protected $validationMessages   = [];
	protected $skipValidation       = false;
	protected $cleanValidationRules = true;

	// Callbacks
	protected $allowCallbacks = true;
	protected $beforeInsert   = [];
	protected $afterInsert    = [];
	protected $beforeUpdate   = [];
	protected $afterUpdate    = [];
	protected $beforeFind     = [];
	protected $afterFind      = [];
	protected $beforeDelete   = [];
	protected $afterDelete    = [];


	public function getPencairan($cari = null, $start = null, $limit = null, $jenis = null, $status = null, $no_transaksi = null)
	{
		$key = [
			'id' => $cari,
			'nominal' => $cari,
			't_penarikan_validasi.atas_nama' => $cari,
			't_penarikan_validasi.status' => $cari,
			'keterangan' => $cari,
		];

		$builder = $this->db->table($this->table);

		switch ($jenis) {
			case '2': // penarikan saldo driver
				$builder->select('t_penarikan_validasi.*, m_driver.nama_depan, m_bank.nama_bank, m_saldo_driver.saldo')
					->join('m_driver', "t_penarikan_validasi.id = m_driver.kd_driver")
					->join('m_saldo_driver', 't_penarikan_validasi.id = m_saldo_driver.kd_driver');

				break;
			case '1': //penarikan saldo toko
				$builder->select("t_penarikan_validasi.*, company.nama_usaha, m_bank.nama_bank, m_saldo_toko.saldo")
					->join("(SELECT id, nama_usaha from m_user_company) company", "t_penarikan_validasi.id = company.id")
					->join('m_saldo_toko', 't_penarikan_validasi.id = m_saldo_toko.kd_toko');
				break;
			default:
				$builder->select("*");
				break;
		}

		$builder->join('m_bank', "t_penarikan_validasi.kd_bank = m_bank.kd_bank");

		if ($cari != '') {
			$builder->like('no_transaksi', $cari)->orLike($key);
		}

		$builder->where('jenis_user', $jenis); //sesuai jenis

		if ($no_transaksi != '') { // khusus tampilkan detail penarikan
			$builder->where('no_transaksi', $no_transaksi);
		}

		if ($status == 'unverif') { //utk status belum verifikasi
			$builder->where('t_penarikan_validasi.status', '0');
		}

		$builder->orderBy('tanggal', 'DESC');

		if ($limit != '' && $start != '') {
			$builder->limit($limit, $start);
		}



		return $builder->get();
	}

	public function insertPenarikan($data)
	{
		$builder = $this->db->table('t_penarikan');
		return $builder->insert($data);
	}

	public function getpenarikantoko($cari = null, $start = null, $limit = null, $jenis = null, $akhir = null)
	{
		$akhir = is_null($akhir) ? date("Y-m-d") : $akhir;
		$key = [
			"c.nama_usaha" => $cari,
            "c.company_id" => $cari,
			"a.jenis_transaksi" => $cari,
		];

        $builder = $this->db->table("t_penjualan a");

		if ($cari != null) {
			$builder->like("a.id", $cari);
			$builder->orLike($key);
		}

		if ($jenis == "unverif") {
			$test = "NOT IN";
			$select_status = "0 as status";
		}else {
			$test = "IN";
			$select_status = "1 as status";
		}
		$limit = "";
		if ($start != null && $limit != null) {
			$limit = "limit $limit , $start";
		}
	$builder = $this->db->query("SELECT 
		c.`company_id`,$select_status, penjualan.`jenis_transaksi`, c.`nama_usaha`, 0 as `status`, c.`no_rek`, `j`.`nama_bank`, `c`.`nama_pemilik_rekening`, total_transfer-potongan_toko AS total_transfer
		 FROM
		(
			SELECT user_id_toko,'FOOD' AS jenis_transaksi,potongan_toko,
			SUM(
				(harga_jual - (CASE WHEN jl_dt.diskon<1 THEN harga_jual*diskon/100 ELSE diskon END)) *qty
			) AS total_transfer
			FROM 
			t_penjualan jl
			INNER JOIN t_penjualan_detail jl_dt
			ON jl.no_transaksi=jl_dt.no_transaksi
			INNER JOIN `t_pengiriman` `d` ON jl.`no_transaksi` = `d`.`no_resi`
			INNER JOIN 
			(SELECT no_resi,GROUP_CONCAT(status ORDER BY waktu_status DESC LIMIT 1) AS status FROM t_pengiriman_status GROUP BY no_resi) e ON d.no_resi = `e`.`no_resi`
			WHERE jenis_transaksi='FOOD'
			AND `tanggal` <= CONCAT('$akhir', ' 12:00:00')
			AND jl.no_transaksi $test (SELECT no_transaksi FROM t_penarikan)
			AND (status_barang=1)
			GROUP BY user_id_toko
		) penjualan
		INNER JOIN m_user_company c ON c.id=penjualan.user_id_toko
		LEFT JOIN `m_bank` `j` ON `c`.`kd_bank` = `j`.`kd_bank`
		WHERE c.`status`=1 $limit");

		// print_r($builder->getResult());
		return $builder;
	}

	public function getdetail($company_id = null, $akhir = null, $jenis = null)
	{
		$builder = $this->db->table("t_penjualan a");
		if ($jenis == "unverif") {
			$test = "NOT IN";
		}else {
			$test = "IN";
		}
		$builder->select("c.company_id, a.jenis_transaksi,
		c.nama_usaha, a.no_transaksi, j.nama_bank, c.nama_pemilik_rekening, b.qty, c.no_rek,COUNT(a.no_transaksi) AS jumlah_item,
		SUM((b.harga_jual - (b.harga_jual * b.diskon / 100)) * b.qty - a.potongan_toko) AS total_transfer");
		$builder->join("t_penjualan_detail b", "a.no_transaksi = b.no_transaksi", "INNER");
		$builder->join("m_user_company c", "a.user_id_toko = c.id", "INNER");
		$builder->join("m_bank j", "c.kd_bank = j.kd_bank", "LEFT");
        $builder->join("t_pengiriman d", "a.no_transaksi = d.no_resi", "INNER");
		$builder->join("t_pengiriman_status e", "a.no_transaksi = e.no_resi", "INNER");
        $builder->where("e.`status` = 2 AND a.jenis_transaksi = 'FOOD' AND tanggal <= CONCAT('$akhir', ' 12:00:00')
		AND a.no_transaksi $test (SELECT no_transaksi FROM t_penarikan) AND 
		c.company_id = '$company_id'");
		$builder->groupBy('a.no_transaksi, a.jenis_transaksi, c.nama_usaha');
		return $builder->get();
	}
	 public function verifpencairantoko($company_id, $akhir)
	 {
		
		 $this->db->transStart();
			$insertp = "INSERT INTO t_penarikan(no_transaksi,tanggal,id,jenis_user,nominal,kd_bank,no_rek_tujuan,atas_nama)
			SELECT a.no_transaksi,NOW(),user_id_toko,2,
			SUM((b.harga_jual - (b.harga_jual * b.diskon / 100)) * b.qty - a.potongan_toko) AS total_transfer,
			kd_bank,no_rek,nama_pemilik_rekening
			FROM t_penjualan a
			INNER JOIN t_penjualan_detail b ON a.no_transaksi = b.no_transaksi
			INNER JOIN m_user_company c ON a.user_id_toko = c.id
			INNER JOIN t_pengiriman d ON a.no_transaksi = d.no_resi
			INNER JOIN t_pengiriman_status e ON a.no_transaksi = e.no_resi
			WHERE e.`status` = 2 AND a.jenis_transaksi = 'FOOD' AND tanggal <= CONCAT('$akhir', ' 12:00:00')
			AND a.no_transaksi NOT IN (SELECT no_transaksi FROM t_penarikan) AND 
			c.company_id = '$company_id'
			GROUP BY a.no_transaksi, a.jenis_transaksi, c.nama_usaha";
			$this->db->query($insertp);
			$insertVp = "INSERT INTO t_penarikan_validasi(no_transaksi,tanggal,id,jenis_user,nominal,kd_bank,no_rek_tujuan,atas_nama,status)
			SELECT a.no_transaksi,NOW(),user_id_toko,1,
			SUM((b.harga_jual - (b.harga_jual * b.diskon / 100)) * b.qty - a.potongan_toko) AS total_transfer,
			kd_bank,no_rek,nama_pemilik_rekening,1
			FROM t_penjualan a
			INNER JOIN t_penjualan_detail b ON a.no_transaksi = b.no_transaksi
			INNER JOIN m_user_company c ON a.user_id_toko = c.id
			INNER JOIN t_pengiriman d ON a.no_transaksi = d.no_resi
			INNER JOIN t_pengiriman_status e ON a.no_transaksi = e.no_resi
			WHERE e.`status` = 2 AND a.jenis_transaksi = 'FOOD' AND tanggal <= CONCAT('$akhir', ' 12:00:00')
			AND a.no_transaksi NOT IN (SELECT no_transaksi FROM t_penarikan_validasi) AND 
			c.company_id = '$company_id'
			GROUP BY a.no_transaksi, a.jenis_transaksi, c.nama_usaha";
			$this->db->query($insertVp);
		$this->db->transComplete();
		if ($this->db->transStatus() === False ) {
			return false;
		}else {
			return true;
		}
	 }
	 public function induk($company_id, $akhir)
	 {
			$builder = $this->db->query("SELECT c.company_id, a.jenis_transaksi, c.nama_usaha, c.status,
			b.qty, COUNT(a.no_transaksi) AS jumlah_item, DATE(o.tanggal) AS tanggal,
			SUM((b.harga_jual - (b.harga_jual * b.diskon / 100)) * b.qty - a.potongan_toko) AS total_transfer 
			FROM t_penjualan a
			INNER JOIN t_penjualan_detail b ON a.no_transaksi = b.no_transaksi
			INNER JOIN m_user_company c ON a.user_id_toko = c.id
			INNER JOIN t_pengiriman d ON a.no_transaksi = d.no_resi 
			INNER JOIN t_pengiriman_status e ON a.no_transaksi = e.no_resi 
			INNER JOIN t_penarikan o ON a.no_transaksi = o.no_transaksi
			WHERE e.status = 2 AND a.jenis_transaksi = 'FOOD' AND o.tanggal < CONCAT('$akhir', ' 12:00:00') 
			AND c.company_id = '$company_id'
			GROUP BY a.jenis_transaksi, c.nama_usaha, date(o.tanggal)");
	   		return $builder->getRow();
			
	 }
}
