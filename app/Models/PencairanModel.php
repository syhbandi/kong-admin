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
			'atas_nama' => $cari,
			'status' => $cari,
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
			$builder->select("c.company_id, a.jenis_transaksi,
			c.nama_usaha, $select_status,
			SUM((b.harga_jual - (b.harga_jual * b.diskon / 100)) * b.qty - a.potongan_toko) AS total_transfer");
			$builder->join("t_penjualan_detail b", "a.no_transaksi = b.no_transaksi", "INNER");
			$builder->join("m_user_company c", "a.user_id_toko = c.id", "INNER");
			$builder->join("t_pengiriman d", "a.no_transaksi = d.no_resi", "INNER");
			$builder->join("t_pengiriman_status e", "a.no_transaksi = e.no_resi", "INNER");
			$builder->where("e.`status` = 2 AND a.jenis_transaksi = 'FOOD' AND 
			tanggal <= CONCAT('$akhir', ' 12:00:00')
			AND a.no_transaksi $test (SELECT no_transaksi FROM t_penarikan)");
			$builder->groupBy('c.company_id, a.jenis_transaksi, c.nama_usaha');
		if ($start != null && $limit != null) {
			$builder->limit($limit, $start);
		}
		return $builder->get();
	}

	public function getdetail($company_id = null, $akhir = null)
	{
		$builder = $this->db->table("t_penjualan a");

		$builder->select("c.company_id, a.jenis_transaksi,
		c.nama_usaha, a.no_transaksi, b.qty, COUNT(a.no_transaksi) AS jumlah_item,
		SUM((b.harga_jual - (b.harga_jual * b.diskon / 100)) * b.qty - a.potongan_toko) AS total_transfer");
		$builder->join("t_penjualan_detail b", "a.no_transaksi = b.no_transaksi", "INNER");
		$builder->join("m_user_company c", "a.user_id_toko = c.id", "INNER");
        $builder->join("t_pengiriman d", "a.no_transaksi = d.no_resi", "INNER");
		$builder->join("t_pengiriman_status e", "a.no_transaksi = e.no_resi", "INNER");
        $builder->where("e.`status` = 2 AND a.jenis_transaksi = 'FOOD' AND tanggal <= CONCAT('$akhir', ' 12:00:00')
		AND a.no_transaksi NOT IN (SELECT no_transaksi FROM t_penarikan) AND 
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
			WHERE e.`status` = 2 AND a.jenis_transaksi = 'FOOD' AND 
			tanggal > CONCAT('$awal', ' 12:00:00') AND tanggal <= CONCAT('$akhir', ' 12:00:00')
			AND a.no_transaksi NOT IN (SELECT no_transaksi FROM t_penarikan) AND 
			c.company_id = '$company_id'
			GROUP BY a.no_transaksi, a.jenis_transaksi, c.nama_usaha";
			$this->db->query($insertp);
			$insertVp = "INSERT INTO t_penarikan_validasi(no_transaksi,tanggal,id,jenis_user,nominal,kd_bank,no_rek_tujuan,atas_nama,status)
			SELECT a.no_transaksi,NOW(),user_id_toko,2,
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
}
