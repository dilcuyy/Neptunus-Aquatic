<?php

namespace App\Controllers;

use App\Models\IkanModel;
use App\Models\RiwayatStokModel;

class Kasir extends BaseController
{
    public function getIkan()
    {
        $ikanModel = new IkanModel();
        $fishList = $ikanModel->getIkanWithKategori();

        $data = array_map(function ($fish) {
            return [
                'id_ikan'       => $fish['id_ikan'],
                'nama_ikan'     => $fish['nama_ikan'],
                'nama_kategori' => $fish['nama_kategori'] ?? 'Umum',
                'harga_beli'    => (float) $fish['harga_beli'],
                'harga_jual'    => (float) $fish['harga_jual'],
                'stok'          => (int) $fish['stok'],
                'harga_jual_fmt' => 'Rp ' . number_format($fish['harga_jual'], 0, ',', '.'),
                'harga_beli_fmt' => 'Rp ' . number_format($fish['harga_beli'], 0, ',', '.'),
                'foto'           => !empty($fish['foto']) ? base_url('uploads/ikan/' . $fish['foto']) : (!empty($fish['gambar']) ? base_url('uploads/ikan/' . $fish['gambar']) : null)
            ];
        }, $fishList);

        return $this->response->setJSON([
            'status' => 'success',
            'data'   => $data
        ]);
    }

    public function proses()
    {
        $ikanModel    = new IkanModel();
        $riwayatModel = new RiwayatStokModel();

        $itemsJson = $this->request->getPost('items');
        $items = [];
        if (!empty($itemsJson)) {
            $items = json_decode($itemsJson, true);
        } else {
            $idIkan = (int) $this->request->getPost('id_ikan');
            if ($idIkan > 0) {
                $items[] = [
                    'id_ikan'      => $idIkan,
                    'jenis'        => trim($this->request->getPost('jenis')),
                    'jumlah'       => (int) $this->request->getPost('jumlah'),
                    'harga_satuan' => (float) $this->request->getPost('harga_satuan'),
                    'keterangan'   => trim($this->request->getPost('keterangan'))
                ];
            }
        }

        if (empty($items) || !is_array($items)) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Keranjang transaksi masih kosong! Tambahkan minimal 1 item ikan.'
            ]);
        }

        // 1. Validation & Stock Check
        foreach ($items as $idx => $item) {
            $idIkan = (int) ($item['id_ikan'] ?? 0);
            $jumlah = (int) ($item['jumlah'] ?? 0);
            $jenis  = trim($item['jenis'] ?? 'Keluar');

            if ($idIkan <= 0 || $jumlah <= 0) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Item ke-' . ($idx + 1) . ' tidak valid.'
                ]);
            }

            $fish = $ikanModel->find($idIkan);
            if (!$fish) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Data ikan untuk item ke-' . ($idx + 1) . ' tidak ditemukan.'
                ]);
            }

            if ($jenis === 'Keluar' && $jumlah > (int)$fish['stok']) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Stok "' . $fish['nama_ikan'] . '" tidak mencukupi! Permintaan: ' . $jumlah . ' Ekor, Sisa stok: ' . $fish['stok'] . ' Ekor.'
                ]);
            }
        }

        // 2. Process All Database Mutations
        $db = \Config\Database::connect();
        $db->transStart();

        $processedCount = 0;
        foreach ($items as $item) {
            $idIkan      = (int) $item['id_ikan'];
            $jenis        = trim($item['jenis']);
            $jumlah       = (int) $item['jumlah'];
            $hargaSatuan  = (float) $item['harga_satuan'];
            $keterangan   = trim($item['keterangan'] ?? '');

            $fish = $ikanModel->find($idIkan);
            $stokSekarang = (int) $fish['stok'];
            $stokBaru = ($jenis === 'Masuk') ? ($stokSekarang + $jumlah) : ($stokSekarang - $jumlah);

            // Update stock in ikan table
            $ikanModel->update($idIkan, ['stok' => $stokBaru]);

            // Log mutation in riwayat_stok table
            $riwayatModel->insert([
                'id_ikan'      => $idIkan,
                'id_akun'      => 1,
                'jenis'        => $jenis,
                'jumlah'       => $jumlah,
                'harga_satuan' => $hargaSatuan,
                'keterangan'   => $keterangan ?: ($jenis === 'Masuk' ? 'Restock Kasir' : 'Penjualan Kasir'),
                'tanggal'      => date('Y-m-d H:i:s')
            ]);

            $processedCount++;
        }

        $db->transComplete();

        if ($db->transStatus() === false) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Gagal memproses transaksi kasir. Terjadi kesalahan pada database.'
            ]);
        }

        return $this->response->setJSON([
            'status'  => 'success',
            'message' => 'Berhasil memproses ' . $processedCount . ' item transaksi kasir!'
        ]);
    }
}
