<?php

namespace App\Controllers;

use App\Models\IkanModel;
use App\Models\RiwayatStokModel;

class Search extends BaseController
{
    public function suggest()
    {
        $q = substr(trim($this->request->getGet('q') ?? ''), 0, 50);
        
        if (mb_strlen($q) < 3) {
            return $this->response->setJSON([
                'query'   => $q,
                'stok'    => [],
                'laporan' => []
            ]);
        }

        $ikanModel    = new IkanModel();
        $riwayatModel = new RiwayatStokModel();

        // 1. Top 3 Rekomendasi Data Stok Ikan
        $stokBuilder = $ikanModel->db->table('ikan');
        $stokBuilder->select('ikan.id_ikan, ikan.nama_ikan, ikan.stok, ikan.harga_jual, kategori.nama_kategori, kategori.satuan');
        $stokBuilder->join('kategori', 'kategori.id_kategori = ikan.id_kategori', 'left');
        $stokBuilder->groupStart()
            ->like('ikan.nama_ikan', $q)
            ->orLike('ikan.deskripsi', $q)
            ->orLike('kategori.nama_kategori', $q)
        ->groupEnd();
        $stokBuilder->orderBy('ikan.nama_ikan', 'ASC');
        $stokBuilder->limit(3);
        $stokRaw = $stokBuilder->get()->getResultArray();

        $stokData = array_map(function ($item) {
            return [
                'id_ikan'       => $item['id_ikan'],
                'nama_ikan'     => $item['nama_ikan'],
                'nama_kategori' => $item['nama_kategori'] ?? 'Umum',
                'satuan'        => $item['satuan'] ?? 'Ekor',
                'stok'          => (int) $item['stok'],
                'harga_formatted' => 'Rp ' . number_format($item['harga_jual'], 0, ',', '.'),
                'url'           => base_url('stok-ikan?highlight=' . $item['id_ikan'] . '#row-stok-' . $item['id_ikan'])
            ];
        }, $stokRaw);

        // 2. Top 3 Rekomendasi Data Laporan (Mutasi Stok)
        $laporanBuilder = $riwayatModel->db->table('riwayat_stok');
        $laporanBuilder->select("riwayat_stok.id_riwayat, riwayat_stok.jenis, riwayat_stok.jumlah, riwayat_stok.tanggal, riwayat_stok.keterangan, COALESCE(ikan.nama_ikan, barang.nama_barang) AS nama_item, ikan.nama_ikan, barang.nama_barang, COALESCE(kat_ikan.satuan, kat_barang.satuan, barang.satuan) AS satuan");
        $laporanBuilder->join('ikan', 'ikan.id_ikan = riwayat_stok.id_ikan', 'left');
        $laporanBuilder->join('barang', 'barang.id_barang = riwayat_stok.id_barang', 'left');
        $laporanBuilder->join('kategori kat_ikan', 'kat_ikan.id_kategori = ikan.id_kategori', 'left');
        $laporanBuilder->join('kategori kat_barang', 'kat_barang.id_kategori = barang.id_kategori', 'left');
        $laporanBuilder->groupStart()
            ->like('ikan.nama_ikan', $q)
            ->orLike('barang.nama_barang', $q)
            ->orLike('riwayat_stok.keterangan', $q)
            ->orLike('riwayat_stok.jenis', $q)
        ->groupEnd();
        $laporanBuilder->orderBy('riwayat_stok.id_riwayat', 'DESC');
        $laporanBuilder->limit(3);
        $laporanRaw = $laporanBuilder->get()->getResultArray();

        $laporanData = array_map(function ($item) {
            $namaItem = $item['nama_item'] ?? $item['nama_ikan'] ?? $item['nama_barang'] ?? 'Item #' . $item['id_riwayat'];
            return [
                'id_riwayat'    => $item['id_riwayat'],
                'nama_ikan'     => $namaItem,
                'nama_item'     => $namaItem,
                'jenis'         => $item['jenis'],
                'jumlah'        => (int) $item['jumlah'],
                'satuan'        => $item['satuan'] ?? 'Ekor',
                'tanggal'       => date('d/m/Y H:i', strtotime($item['tanggal'])),
                'keterangan'    => $item['keterangan'] ?? '-',
                'url'           => base_url('laporan-in-out?highlight=' . $item['id_riwayat'] . '#row-laporan-' . $item['id_riwayat'])
            ];
        }, $laporanRaw);

        return $this->response->setJSON([
            'query'   => $q,
            'stok'    => $stokData,
            'laporan' => $laporanData
        ]);
    }
}
