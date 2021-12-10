<?php

namespace App\Models\Rider;

use CodeIgniter\Model;

class TopUpModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 't_driver_topup_his';
    protected $primaryKey       = 'top_id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [
        'top_id',
        'driver_id',
        'approveby',
        'approveat',
        'approve_state',
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

    public function getData($cari = null, $start = null, $limit = null, $jenis = null, $top_id = null)
    {
        $key = [
            'nama_depan' => $cari,
            'hp1' => $cari,
            'hp2' => $cari,
            'kd_driver' => $cari,
            'filepath' => $cari,
            'nominal' => $cari,
        ];

        $builder = $this->db->table("t_driver_topup_his a");

        if ($cari != null) {
            $builder->like("top_id", $cari);
            $builder->orLike($key);
        }

        $builder->select("b.nama_depan,b.hp1,b.hp2,a.*");
        $builder->join("m_driver b", "b.kd_driver=a.driver_id", "INNER");

        if ($jenis == 'unverif') {
            $builder->where('approve_state', '-1');
            // $builder->orWhere('approve_state', '0');
        }

        if ($top_id != '') {
            $builder->where('a.top_id', $top_id);
        }

        $builder->orderBy('createat', "DESC");

        if ($start != null && $limit != null) {
            $builder->limit($limit, $start);
        }

        return $builder->get();
    }
}
