<?php

namespace App\Models;

use CodeIgniter\Model;

class HomeModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_userx';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    public function misterkong()
    {
        $builder = $this->db->table("m_userx");
        $builder->select("COUNT(kd_user) AS mp");
        $builder->where("kd_group = '2'  AND `status` = 1");
        return $builder->get();
    }

    public function kongpos()
    {
        $builder = $this->db->table("m_user_company");
        $builder->select("COUNT(company_id) AS pos");
        $builder->where(" status = 1");
        return $builder->get();
    }

    public function kongrider()
    {
        $builder = $this->db->table("m_driver");
        $builder->select("COUNT(kd_driver) AS driver");
        $builder->where("status = 3");
        return $builder->get();
    }

    public function barang()
    {
        $builder = $this->db->table("m_barang");
        $builder->select("COUNT(id) AS barang");
        $builder->where("status = 1");

        return $builder->get();
    }

}
