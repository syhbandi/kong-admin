<?php

namespace App\Models\Transaksi;

use CodeIgniter\Model;

class Transaksi extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'transaksis';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = true;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = [];

}
