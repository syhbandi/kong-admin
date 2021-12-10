<?php

namespace App\Models\Rider;

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

		if ($jenis != '') {
			switch ($jenis) {
				case '2':
					$builder->select('t_penarikan_validasi.*, m_driver.nama_depan, m_bank.nama_bank');
					$builder->join('m_driver', "t_penarikan_validasi.id = m_driver.kd_driver");
					$builder->join('m_bank', "t_penarikan_validasi.kd_bank = m_bank.kd_bank");
					break;

				default:
					break;
			}
		}

		if ($cari != '') {
			$builder->like('no_transaksi', $cari)->orLike($key);
		}

		if ($no_transaksi != '') {
			$builder->where('no_transaksi', $no_transaksi);
		}

		if ($status == 'unverif') {
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
}
