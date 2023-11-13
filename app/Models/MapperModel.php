<?php

namespace App\Models;

use CodeIgniter\Model;

class MapperModel extends Model
{
    public function getDataMapper($jenis)
    {
        // jenis: 1. belum bayar, 2. sudah bayar, belum verif, 3. sudah verif, 4.expired
        if ($jenis==1) {
            $where="ISNULL(bukti_bayar)";
        }elseif($jenis==2){
            $where="tanggal_bayar>tanggal_verifikasi OR (tanggal_bayar IS NOT NULL AND ISNULL(tanggal_verifikasi))";
        }elseif($jenis==3){
            $where="tanggal_verifikasi>=tanggal_bayar";
        }else{
            $where="NOW() > DATE_ADD(awal, INTERVAL periode MONTH)";
        }
        // $db= \Config\Database::connect();
        // $builder=$db->table('misterkong_mapper.m_tarif_mapper')->where('id=2');
        // $builder->where($where);
        // echo $builder->getCompiledSelect();
        $sql="SELECT * FROM misterkong_mapper.v_adm_pembayaranMapper WHERE ".$where;
        $builder=$this->db->query($sql);
        return $builder;
    }
    public function verifikasiMapper($data_save,$condition)
    {
        $this->db->transStart();
        // $this->db->where($key_update);
        // $this->db->update($table, $data);
        // $builder->where('id', $id);
        $this->db->table('misterkong_mapper.t_pembayaran_mapper')->update($data_save, $condition);
        $this->db->transComplete();

        if ($this->db->transStatus() === false) {
            return false;
        } else {
            return true;
        }    
    }
    
}
