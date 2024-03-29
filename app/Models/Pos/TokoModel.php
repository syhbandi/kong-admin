<?php

namespace App\Models\Pos;

use CodeIgniter\Model;

class TokoModel extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'm_user_company';
    protected $primaryKey       = 'id';
    protected $useAutoIncrement = false;
    protected $insertID         = 0;
    protected $returnType       = 'array';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['company_id', 'status'];

    public function getToko($cari = null, $start = null, $limit = null, $company_id = null, $jenis = null, $id = null)
    {
        $key = [
            "a.nama_usaha" => $cari,
            "a.kategori_usaha" => $cari,
            "a.alamat" => $cari,
            "a.email_usaha" => $cari,
            "a.no_telepon" => $cari,
            "a.date_add" => $cari,
            "a.no_rek" => $cari,
            "b.province" => $cari,
            "c.nama" => $cari,
        ];

        $builder = $this->db->table("m_user_company a");

        if ($cari != null) {
            $builder->like("a.company_id", $cari);
            $builder->orLike($key);
        }

        $builder->select("a.company_id, a.nama_usaha, d.nama as usaha, 
            a.alamat, a.email_usaha, a.no_telepon, a.date_add, a.no_rek,
            a.status, b.province, c.nama,  IFNULL(`f`.`nama_bank`, 0)AS bank, a.no_rek, a.nama_pemilik_rekening,
            a.koordinat_lng, a.koordinat_lat, ifnull(g.jml_barang, 0) AS jml_barang");

        $builder->join("m_province b", "a.kd_provinsi = b.id", "INNER");
        $builder->join("m_userx AS c", "a.kd_user = c.id", "INNER");
        $builder->join("m_kategori_usaha AS d", "a.kategori_usaha = d.kd_kategori_usaha", "INNER");
        $builder->join("m_bank AS f", "a.kd_bank = f.kd_bank", "LEFT");
        $builder->join(
            "(SELECT brg.company_id, COUNT(*) AS jml_barang FROM 
        m_barang brg
                INNER JOIN m_barang_satuan mbs ON brg.id=mbs.barang_id
             INNER JOIN m_barang_gambar f ON brg.id=f.barang_id
    INNER JOIN m_barang_verifikasi i ON brg.id = i.barang_id
    INNER JOIN m_barang_gambar_verifikasi j ON f.id = j.barang_gambar_id
    INNER JOIN m_user_company r ON brg.company_id = r.id
    WHERE r.company_id = '$company_id'
    group BY company_id) g",
            "ON a.id = g.company_id",
            "LEFT"
        );


        if ($company_id != null) {
            $builder->where('a.company_id', $company_id);
        }

        switch ($jenis) {
            case 'nonaktif':
                $builder->where("a.`status`", -1);
                break;
            case 'aktif':
                $builder->where("a.`status`", 1);
                break;
            case 'tutup':
                $builder->where("a.`status`", 0);
                break;
            case 'banned':
                $builder->where("a.`status`", -2);
                break;
            default:
                break;
        }
        $builder->where("a.company_id != ", '');

        if ($start != null && $limit != null) {
            $builder->limit($limit, $start);
        }
        // echo $sql = $builder->getCompiledSelect();
        return $builder->get();
    }
    public function version()
    {
        $builder = $this->db->table("g_app_version");
        $builder->select("*");
        return $builder->get();
    }

    public function updatev($id, $app_version)
    {
        $update = $this->db->query("UPDATE g_app_version SET app_store_version = '$app_version' WHERE id = '$id' ");
        return $update;
    }

    public function verivikasi($status, $company_id)
    {
        if ($status == 'aktif') {
            $verivikasi = $this->db->query("UPDATE m_user_company SET status = '1' WHERE company_id = '$company_id'");
        } elseif ($status == 'Banned') {
            $verivikasi = $this->db->query("UPDATE m_user_company SET status = '-2' WHERE company_id = '$company_id'");
        } else {
            $verivikasi = $this->db->query("UPDATE m_user_company SET status = '0' WHERE company_id = '$company_id'");
        }
        return $verivikasi;
    }
    public function editkategori($kategori, $company_id)
    {
        $edit = $this->db->query("UPDATE m_user_company SET kategori_usaha = '$kategori' WHERE company_id = '$company_id'");
        return $edit;
    }
    public function verivikasiBarang($status, $kd_barang)
    {

        if ($status == 'aktif') {
            $verbarang = $this->db->query("UPDATE m_barang_verifikasi SET status_barang = '1' WHERE barang_id IN (".implode(',', $kd_barang).")");
        } elseif ($status == 'nondisplay') {
            $verbarang = $this->db->query("UPDATE m_barang_verifikasi  SET status_barang = '-1' WHERE barang_id = '$kd_barang'");
        } else {
            $verbarang = $this->db->query("UPDATE m_barang_verifikasi  SET status_barang = '0' WHERE barang_id = '$kd_barang'");
        }
        
        return $verbarang;
    }

    public function getbarang($cari = null, $start = null, $limit = null, $kd_barang = null, $jenis = null, $id = null)
    {
        $key = [
            "a.nama" => $cari,
            "a.kd_barang" => $cari,
            "a.id" => $cari,
            "e.nama_usaha" => $cari,
        ];

        $builder = $this->db->table("m_user_company e");

        if ($cari != null) {
            $builder->like("a.id", $cari);
            $builder->orLike($key);
        }
        $builder->select(
            "a.nama,
            a.status,
            b.nama AS kategori,
            c.nama AS model,
            d.nama AS merk,
            e.nama_usaha,
            a.date_add,
            a.date_modif,
            a.kd_barang,
            a.gambar,
            a.keterangan,
            g.nama AS bahan,
            h.nama AS warna,
            a.ukuran,
            e.company_id,
            a.status_barang,
            a.status_gambar,
            a.id AS code,
            a.kd_satuan,
            a.satuan"
        );

        // $builder->select(" a.nama, a.`status`, b.nama AS kategori, c.nama AS model,
        // d.nama AS merk, e.nama_usaha, a.date_add, a.date_modif, 
        // a.kd_barang, f.gambar, a.keterangan, g.nama AS bahan, h.nama AS warna,
        // a.ukuran, e.company_id, i.status_barang, j.status_gambar, a.id AS code ");


        $builder->join(
            "(
            SELECT brg.*,GROUP_CONCAT(f.gambar) AS gambar,
            GROUP_CONCAT(s.kd_satuan) AS kd_satuan,
            GROUP_CONCAT(s.nama) AS satuan,status_barang,status_gambar
            FROM m_barang brg
            INNER JOIN m_barang_satuan mbs ON brg.id=mbs.barang_id
            INNER JOIN m_barang_gambar f ON brg.id=f.barang_id
            INNER JOIN m_satuan s ON s.id=mbs.satuan_id
            INNER JOIN m_barang_verifikasi i ON brg.id = i.barang_id
            INNER JOIN m_barang_gambar_verifikasi j ON f.id = j.barang_gambar_id
            GROUP BY brg.kd_barang, brg.company_id
        ) a",
            "a.company_id = e.id",
            "INNER"
        );
        $builder->join("m_kategori b", "a.kategori_id = b.id", "INNER");
        $builder->join("m_model c", "a.model_id = c.id", "INNER");
        $builder->join("m_merk d", "a.merk_id = d.id", "INNER");
        //       $builder->join("m_user_company e", " a.company_id = e.id", "INNER");
        //       $builder->join("m_barang_gambar f", "a.id = f.barang_id", "INNER");
        $builder->join("m_jenis_bahan g", "a.jenis_bahan_id = g.id", "INNER");
        $builder->join("m_warna h", "a.warna_id = h.id", "INNER");
        //       $builder->join("m_barang_verifikasi i", "a.id= i.barang_id", "INNER");
        //       $builder->join("m_barang_gambar_verifikasi j", "f.id = j.barang_gambar_id", "INNER");


        if ($kd_barang != null) {
            $builder->where('a.id', $kd_barang);
        }

        switch ($jenis) {
            case 'nonaktif':
                $builder->where("a.status_barang", 0);
                break;

            case 'aktif':
                $builder->where("a.status_barang", 1);
                break;
            case 'nonverification':
                $builder->where("a.status_barang", -1);
                break;

            default:
                break;
        }
        $builder->where("a.id != ", '');

        if ($start != null && $limit != null) {
            $builder->limit($limit, $start);
        }
        // echo $sql = $builder->getCompiledSelect();
        return $builder->get();
    }
    public function getjmlbrng($cari = null, $start = null, $limit = null, $company_id = null, $kd_barang = null, $jenis = null, $id = null)
    {
        $key = [
            "a.nama" => $cari,
            "a.kd_barang" => $cari,
            "a.id" => $cari,
            "e.nama_usaha" => $cari,
        ];

        $key = [
            "a.nama" => $cari,
            "a.kd_barang" => $cari,
            "a.id" => $cari,
            "e.nama_usaha" => $cari,
        ];

        $builder = $this->db->table("m_user_company e");

        if ($cari != null) {
            $builder->like("a.id", $cari);
            $builder->orLike($key);
        }
        $builder->select(
            "a.nama,
            a.status,
            b.nama AS kategori,
            c.nama AS model,
            d.nama AS merk,
            e.nama_usaha,
            a.date_add,
            a.date_modif,
            a.kd_barang,
            a.gambar,
            a.keterangan,
            g.nama AS bahan,
            h.nama AS warna,
            a.ukuran,
            e.company_id,
            a.status_barang,
            a.status_gambar,
            a.id AS code,
            a.kd_satuan,
            a.satuan"
        );

        // $builder->select(" a.nama, a.`status`, b.nama AS kategori, c.nama AS model,
        // d.nama AS merk, e.nama_usaha, a.date_add, a.date_modif, 
        // a.kd_barang, f.gambar, a.keterangan, g.nama AS bahan, h.nama AS warna,
        // a.ukuran, e.company_id, i.status_barang, j.status_gambar, a.id AS code ");


        $builder->join(
            "(
            SELECT brg.*,GROUP_CONCAT(f.gambar) AS gambar,
            GROUP_CONCAT(s.kd_satuan) AS kd_satuan,
            GROUP_CONCAT(s.nama) AS satuan,status_barang,status_gambar
            FROM m_barang brg
            INNER JOIN m_barang_satuan mbs ON brg.id=mbs.barang_id
            INNER JOIN m_barang_gambar f ON brg.id=f.barang_id
            INNER JOIN m_satuan s ON s.id=mbs.satuan_id
            INNER JOIN m_barang_verifikasi i ON brg.id = i.barang_id
            INNER JOIN m_barang_gambar_verifikasi j ON f.id = j.barang_gambar_id
            INNER JOIN m_user_company r ON brg.company_id = r.id
            WHERE r.company_id = '$company_id'
            GROUP BY brg.kd_barang, brg.company_id
        ) a",
            "a.company_id = e.id",
            "INNER"
        );
        $builder->join("m_kategori b", "a.kategori_id = b.id", "INNER");
        $builder->join("m_model c", "a.model_id = c.id", "INNER");
        $builder->join("m_merk d", "a.merk_id = d.id", "INNER");
        //       $builder->join("m_user_company e", " a.company_id = e.id", "INNER");
        //       $builder->join("m_barang_gambar f", "a.id = f.barang_id", "INNER");
        $builder->join("m_jenis_bahan g", "a.jenis_bahan_id = g.id", "INNER");
        $builder->join("m_warna h", "a.warna_id = h.id", "INNER");
        //       $builder->join("m_barang_verifikasi i", "a.id= i.barang_id", "INNER");
        //       $builder->join("m_barang_gambar_verifikasi j", "f.id = j.barang_gambar_id", "INNER");


        if ($kd_barang != null) {
            $builder->where('a.id', $kd_barang);
        }

        switch ($jenis) {
            case 'nonaktif':
                $builder->where("a.status_barang", 0);
                break;

            case 'aktif':
                $builder->where("a.status_barang", 1);
                break;

            case 'nonverification':
                $builder->where("a.status_barang", -1);
                break;
        }
        $builder->where("a.id != ", '');

        if ($start != null && $limit != null) {
            $builder->limit($limit, $start);
        }

        // echo $sql = $builder->getCompiledSelect();
        return $builder->get();
    }
}
