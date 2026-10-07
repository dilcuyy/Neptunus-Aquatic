<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatStokModel extends Model
{
    protected $table            = 'riwayat_stok';
    protected $primaryKey       = 'id_riwayat';
    protected $allowedFields    = ['id_ikan', 'id_akun', 'jenis', 'jumlah', 'harga_satuan', 'keterangan', 'tanggal'];
    protected $returnType       = 'array';

    public function getRiwayatWithDetails($id = null, $tglAwal = null, $tglAkhir = null, $jenis = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select('riwayat_stok.*, ikan.nama_ikan, akun.nama_lengkap as nama_petugas, akun.username');
        $builder->join('ikan', 'ikan.id_ikan = riwayat_stok.id_ikan', 'left');
        $builder->join('akun', 'akun.id_akun = riwayat_stok.id_akun', 'left');

        if ($id !== null) {
            $builder->where('riwayat_stok.id_riwayat', $id);
            return $builder->get()->getRowArray();
        }

        if (!empty($tglAwal)) {
            $builder->where('DATE(riwayat_stok.tanggal) >=', $tglAwal);
        }
        if (!empty($tglAkhir)) {
            $builder->where('DATE(riwayat_stok.tanggal) <=', $tglAkhir);
        }
        if (!empty($jenis)) {
            $builder->where('riwayat_stok.jenis', $jenis);
        }

        $builder->orderBy('riwayat_stok.tanggal', 'DESC');
        return $builder->get()->getResultArray();
    }

    public function getRiwayatPaginated($perPage = 10, $tglAwal = null, $tglAkhir = null, $jenis = null)
    {
        $this->select('riwayat_stok.*, ikan.nama_ikan, akun.nama_lengkap as nama_petugas, akun.username');
        $this->join('ikan', 'ikan.id_ikan = riwayat_stok.id_ikan', 'left');
        $this->join('akun', 'akun.id_akun = riwayat_stok.id_akun', 'left');

        if (!empty($tglAwal)) {
            $this->where('DATE(riwayat_stok.tanggal) >=', $tglAwal);
        }
        if (!empty($tglAkhir)) {
            $this->where('DATE(riwayat_stok.tanggal) <=', $tglAkhir);
        }
        if (!empty($jenis)) {
            $this->where('riwayat_stok.jenis', $jenis);
        }

        $this->orderBy('riwayat_stok.tanggal', 'DESC');
        return $this->paginate($perPage);
    }
}
