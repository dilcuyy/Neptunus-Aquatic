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
                'satuan'        => $fish['satuan'] ?? 'Ekor',
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
                    'jumlah'       => min(max((int) $this->request->getPost('jumlah'), 1), 999999),
                    'harga_satuan' => min(max((float) preg_replace('/\D/', '', (string) $this->request->getPost('harga_satuan')), 0), 999999999),
                    'keterangan'   => substr(trim($this->request->getPost('keterangan')), 0, 20)
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
            $jumlah = min(max((int) ($item['jumlah'] ?? 0), 0), 999999);
            $jenis  = trim($item['jenis'] ?? 'Keluar');
            $items[$idx]['jumlah'] = $jumlah;

            if ($idIkan <= 0 || $jumlah <= 0) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Item ke-' . ($idx + 1) . ' tidak valid.'
                ]);
            }

            $fish = $ikanModel->getIkanWithKategori($idIkan);
            if (!$fish) {
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Data ikan untuk item ke-' . ($idx + 1) . ' tidak ditemukan.'
                ]);
            }

            if ($jenis === 'Keluar' && $jumlah > (int)$fish['stok']) {
                $satuanErr = $fish['satuan'] ?? 'Ekor';
                return $this->response->setJSON([
                    'status'  => 'error',
                    'message' => 'Stok "' . $fish['nama_ikan'] . '" tidak mencukupi! Permintaan: ' . $jumlah . ' ' . $satuanErr . ', Sisa stok: ' . $fish['stok'] . ' ' . $satuanErr . '.'
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
            $jumlah       = min(max((int) $item['jumlah'], 1), 999999);
            $hargaSatuan  = min(max((float) preg_replace('/\D/', '', (string) ($item['harga_satuan'] ?? 0)), 0), 999999999);
            $keterangan   = substr(trim($item['keterangan'] ?? ''), 0, 20);

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
