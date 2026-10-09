<?php

namespace App\Models;

use CodeIgniter\Model;

class RiwayatStokModel extends Model
{
    protected $table            = 'riwayat_stok';
    protected $primaryKey       = 'id_riwayat';
    protected $allowedFields    = ['id_ikan', 'id_barang', 'id_akun', 'jenis', 'jumlah', 'harga_satuan', 'keterangan', 'tanggal'];
    protected $returnType       = 'array';

    public function getRiwayatWithDetails($id = null, $tglAwal = null, $tglAkhir = null, $jenis = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select("riwayat_stok.*, COALESCE(ikan.nama_ikan, barang.nama_barang) AS nama_item, ikan.nama_ikan, barang.nama_barang, COALESCE(kat_ikan.satuan, kat_barang.satuan, barang.satuan) AS satuan, akun.nama_lengkap as nama_petugas, akun.username");
        $builder->join('ikan', 'ikan.id_ikan = riwayat_stok.id_ikan', 'left');
        $builder->join('barang', 'barang.id_barang = riwayat_stok.id_barang', 'left');
        $builder->join('kategori kat_ikan', 'kat_ikan.id_kategori = ikan.id_kategori', 'left');
        $builder->join('kategori kat_barang', 'kat_barang.id_kategori = barang.id_kategori', 'left');
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

        $builder->orderBy('riwayat_stok.id_riwayat', 'DESC');
        return $builder->get()->getResultArray();
    }

    public function getRiwayatPaginated($perPage = 10, $tglAwal = null, $tglAkhir = null, $jenis = null)
    {
        $this->select("riwayat_stok.*, COALESCE(ikan.nama_ikan, barang.nama_barang) AS nama_item, ikan.nama_ikan, barang.nama_barang, COALESCE(kat_ikan.satuan, kat_barang.satuan, barang.satuan) AS satuan, akun.nama_lengkap as nama_petugas, akun.username");
        $this->join('ikan', 'ikan.id_ikan = riwayat_stok.id_ikan', 'left');
        $this->join('barang', 'barang.id_barang = riwayat_stok.id_barang', 'left');
        $this->join('kategori kat_ikan', 'kat_ikan.id_kategori = ikan.id_kategori', 'left');
        $this->join('kategori kat_barang', 'kat_barang.id_kategori = barang.id_kategori', 'left');
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

        $this->orderBy('riwayat_stok.id_riwayat', 'DESC');
        return $this->paginate($perPage);
    }
}
