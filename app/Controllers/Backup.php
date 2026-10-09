<?php

namespace App\Controllers;

use App\Models\IkanModel;
use App\Models\RiwayatStokModel;

class Backup extends BaseController
{
    public function export()
    {
        $target   = substr(trim($this->request->getGet('target') ?? 'semua'), 0, 10);
        $tglAwal  = substr(trim($this->request->getGet('tgl_awal') ?? ''), 0, 10);
        $tglAkhir = substr(trim($this->request->getGet('tgl_akhir') ?? ''), 0, 10);
        $jenis    = substr(trim($this->request->getGet('jenis') ?? ''), 0, 10);
        $format   = substr(strtolower($this->request->getGet('format') ?? 'json'), 0, 10);

        $ikanModel    = new IkanModel();
        $riwayatModel = new RiwayatStokModel();

        $stokData    = [];
        $laporanData = [];

        if ($target === 'stok' || $target === 'semua') {
            $stokData = $ikanModel->getIkanWithKategori();
        }

        if ($target === 'laporan' || $target === 'semua') {
            $laporanData = $riwayatModel->getRiwayatWithDetails(null, $tglAwal, $tglAkhir, $jenis);
        }

        $timestamp = date('Ymd_His');
        $filename  = "Backup_NeptunusAquatic_{$target}_{$timestamp}";

        if ($format === 'json') {
            $payload = [
                'metadata' => [
                    'title'         => 'Backup Data Neptunus Aquatic',
                    'generated_at'  => date('Y-m-d H:i:s'),
                    'target'        => $target,
                    'filter'        => [
                        'tgl_awal'  => $tglAwal ?? 'Semua',
                        'tgl_akhir' => $tglAkhir ?? 'Semua',
                        'jenis'     => $jenis ?? 'Semua',
                    ],
                    'total_stok'    => count($stokData),
                    'total_laporan' => count($laporanData),
                ],
                'data' => [
                    'stok_ikan'      => $stokData,
                    'laporan_mutasi' => $laporanData,
                ]
            ];

            return $this->response->setHeader('Content-Type', 'application/json')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '.json"')
                ->setBody(json_encode($payload, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
        }

        if ($format === 'csv') {
            $csvContent = "\xEF\xBB\xBF";

            if (!empty($stokData)) {
                $csvContent .= "--- DATA STOK IKAN HIAS ---\n";
                $csvContent .= "ID Ikan,Nama Ikan,Kategori,Harga Beli,Harga Jual,Jumlah Stok,Deskripsi\n";
                foreach ($stokData as $row) {
                    $csvContent .= sprintf(
                        '"%s","%s","%s","%s","%s","%s","%s"' . "\n",
                        $row['id_ikan'],
                        str_replace('"', '""', $row['nama_ikan']),
                        str_replace('"', '""', $row['nama_kategori'] ?? ''),
                        $row['harga_beli'],
                        $row['harga_jual'],
                        $row['stok'],
                        str_replace('"', '""', $row['deskripsi'] ?? '')
                    );
                }
                $csvContent .= "\n";
            }

            if (!empty($laporanData)) {
                $csvContent .= "--- DATA LAPORAN MUTASI STOK ---\n";
                $csvContent .= "ID Riwayat,Tanggal,Nama Ikan,Tipe Mutasi,Jumlah,Harga Satuan,Keterangan,Petugas\n";
                foreach ($laporanData as $row) {
                    $csvContent .= sprintf(
                        '"%s","%s","%s","%s","%s","%s","%s","%s"' . "\n",
                        $row['id_riwayat'],
                        $row['tanggal'],
                        str_replace('"', '""', $row['nama_ikan'] ?? ''),
                        $row['jenis'],
                        $row['jumlah'],
                        $row['harga_satuan'],
                        str_replace('"', '""', $row['keterangan'] ?? ''),
                        str_replace('"', '""', $row['nama_petugas'] ?? '')
                    );
                }
            }

            return $this->response->setHeader('Content-Type', 'text/csv; charset=UTF-8')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '.csv"')
                ->setBody($csvContent);
        }

        if ($format === 'sql') {
            $sqlContent = "-- Backup Database Neptunus Aquatic\n";
            $sqlContent .= "-- Generated: " . date('Y-m-d H:i:s') . "\n\n";

            if (!empty($stokData)) {
                $sqlContent .= "-- Table: ikan\n";
                foreach ($stokData as $row) {
                    $sqlContent .= sprintf(
                        "INSERT INTO `ikan` (`id_ikan`, `id_kategori`, `nama_ikan`, `harga_beli`, `harga_jual`, `stok`, `deskripsi`) VALUES (%d, %d, '%s', %d, %d, %d, '%s') ON DUPLICATE KEY UPDATE `nama_ikan`='%s', `harga_beli`=%d, `harga_jual`=%d, `stok`=%d;\n",
                        $row['id_ikan'],
                        $row['id_kategori'] ?? 1,
                        addslashes($row['nama_ikan']),
                        $row['harga_beli'],
                        $row['harga_jual'],
                        $row['stok'],
                        addslashes($row['deskripsi'] ?? ''),
                        addslashes($row['nama_ikan']),
                        $row['harga_beli'],
                        $row['harga_jual'],
                        $row['stok']
                    );
                }
                $sqlContent .= "\n";
            }

            if (!empty($laporanData)) {
                $sqlContent .= "-- Table: riwayat_stok\n";
                foreach ($laporanData as $row) {
                    $sqlContent .= sprintf(
                        "INSERT INTO `riwayat_stok` (`id_riwayat`, `id_ikan`, `id_akun`, `jenis`, `jumlah`, `harga_satuan`, `keterangan`, `tanggal`) VALUES (%d, %d, %d, '%s', %d, %d, '%s', '%s');\n",
                        $row['id_riwayat'],
                        $row['id_ikan'],
                        $row['id_akun'] ?? 1,
                        addslashes($row['jenis']),
                        $row['jumlah'],
                        $row['harga_satuan'],
                        addslashes($row['keterangan'] ?? ''),
                        $row['tanggal']
                    );
                }
            }

            return $this->response->setHeader('Content-Type', 'application/sql; charset=UTF-8')
                ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '.sql"')
                ->setBody($sqlContent);
        }

        return redirect()->back();
    }
}
