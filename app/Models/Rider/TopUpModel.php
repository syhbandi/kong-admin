<?php

namespace App\Models\Rider;

use CodeIgniter\Model;

class TopUpModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 't_topup_validasi';
    protected $primaryKey       = 'no_transaksi';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'approveat', 'kd_admin', 'status', 'no_transaksi'
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

    public function getData($cari = null, $start = null, $limit = null, $jenis = null, $status = null, $no_transaksi = null)
    {
        $key = [
            'nama_depan' => $cari,
            'no_rek_pengirim' => $cari,
            'id' => $cari,
            'nominal' => $cari,
        ];

        $builder = $this->db->table($this->table);

        if ($jenis != '') {
            switch ($jenis) {
                case '2':
                    $builder
                        ->join('(SELECT kd_driver, nama_depan from m_driver) driver', 't_topup_validasi.id = driver.kd_driver')
                        ->join('m_bank', 't_topup_validasi.kd_bank = m_bank.kd_bank', 'left');
                    break;

                default:
                    break;
            }
        }

        if ($cari != null) {
            $builder->like("no_transaksi", $cari);
            $builder->orLike($key);
        }

        if ($no_transaksi != '') {
            $builder->where('no_transaksi', $no_transaksi);
        }

        if ($status != '') {
            $builder->where('status', $status);
        }

        $builder->orderBy('tanggal', "DESC");

        if ($start != null && $limit != null) {
            $builder->limit($limit, $start);
        }

        return $builder->get();
    }

    public function insertTopUp($data)
    {
        $builder = $this->db->table('t_topup');
        return $builder->insert($data);
    }
}
