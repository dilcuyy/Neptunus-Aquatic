<?php

namespace App\Models;

use CodeIgniter\Model;

class BarangModel extends Model
{
    protected $table            = 'barang';
    protected $primaryKey       = 'id_barang';
    protected $allowedFields    = ['id_kategori', 'nama_barang', 'satuan', 'deskripsi', 'foto'];
    protected $returnType       = 'array';

    public function getBarangWithKategori($id = null)
    {
        $builder = $this->db->table($this->table);
        $builder->select("barang.*, kategori.nama_kategori, COALESCE(kategori.satuan, barang.satuan) AS satuan");
        $builder->select("COALESCE(SUM(CASE WHEN riwayat_stok.jenis = 'Masuk' THEN riwayat_stok.jumlah WHEN riwayat_stok.jenis = 'Keluar' THEN -riwayat_stok.jumlah ELSE 0 END), 0) AS stok", false);
        $builder->select("(SELECT r2.harga_satuan FROM riwayat_stok r2 WHERE r2.id_barang = barang.id_barang ORDER BY r2.tanggal DESC LIMIT 1) AS harga_terakhir", false);
        $builder->select("(SELECT r2.harga_satuan FROM riwayat_stok r2 WHERE r2.id_barang = barang.id_barang AND r2.jenis = 'Masuk' ORDER BY r2.tanggal DESC LIMIT 1) AS harga_beli_last", false);
        $builder->select("(SELECT r2.harga_satuan FROM riwayat_stok r2 WHERE r2.id_barang = barang.id_barang AND r2.jenis = 'Keluar' ORDER BY r2.tanggal DESC LIMIT 1) AS harga_jual_last", false);
        $builder->join('kategori', 'kategori.id_kategori = barang.id_kategori', 'left');
        $builder->join('riwayat_stok', 'riwayat_stok.id_barang = barang.id_barang', 'left');
        $builder->groupBy('barang.id_barang');

        if ($id !== null) {
            $builder->where('barang.id_barang', $id);
            $row = $builder->get()->getRowArray();
            return $row ? $this->normalizeRow($row) : null;
        }

        $rows = $builder->get()->getResultArray();
        return array_map([$this, 'normalizeRow'], $rows);
    }

    private function normalizeRow(array $row): array
    {
        $beli = $row['harga_beli_last'] ?? $row['harga_terakhir'] ?? 0;
        $jual = $row['harga_jual_last'] ?? $row['harga_terakhir'] ?? $beli ?? 0;
        $row['harga_beli'] = (float) ($beli ?? 0);
        $row['harga_jual'] = (float) ($jual ?? 0);
        $row['stok'] = (int) ($row['stok'] ?? 0);
        return $row;
    }
}
