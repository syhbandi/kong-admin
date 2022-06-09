<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class Pendapatan extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'pendapatans';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

    
}
