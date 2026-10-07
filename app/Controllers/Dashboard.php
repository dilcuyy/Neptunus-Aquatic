<?php

namespace App\Controllers;

use App\Models\IkanModel;
use App\Models\RiwayatStokModel;

class Dashboard extends BaseController
{
    public function index()
    {
        $ikanModel = new IkanModel();
        $db = \Config\Database::connect();

        // 1. Stat cards
        $totalStok = $ikanModel->selectSum('stok')->first()['stok'] ?? 0;
        $totalJenis = $ikanModel->countAllResults();

        $builderIn = $db->table('riwayat_stok')->selectSum('jumlah')->where('jenis', 'Masuk')->get()->getRow();
        $ikanMasuk = $builderIn->jumlah ?? 0;

        $builderOut = $db->table('riwayat_stok')->selectSum('jumlah')->where('jenis', 'Keluar')->get()->getRow();
        $ikanKeluar = $builderOut->jumlah ?? 0;

        // 2. Chart Data: Stok per Kategori Ikan
        $kategoriQuery = $db->query("
            SELECT COALESCE(k.nama_kategori, 'Lainnya') as kategori, SUM(i.stok) as total_stok
            FROM ikan i
            LEFT JOIN kategori_ikan k ON k.id_kategori = i.id_kategori
            GROUP BY i.id_kategori
            ORDER BY total_stok DESC
        ")->getResultArray();

        $chartKategoriLabels = [];
        $chartKategoriData   = [];
        foreach ($kategoriQuery as $row) {
            $chartKategoriLabels[] = $row['kategori'];
            $chartKategoriData[]   = (int) $row['total_stok'];
        }

        // 3. Chart Data: Top 5 Stok Ikan Terbanyak
        $topFishQuery = $db->query("
            SELECT nama_ikan, stok
            FROM ikan
            ORDER BY stok DESC
            LIMIT 5
        ")->getResultArray();

        $chartTopFishLabels = [];
        $chartTopFishData   = [];
        foreach ($topFishQuery as $row) {
            $chartTopFishLabels[] = $row['nama_ikan'];
            $chartTopFishData[]   = (int) $row['stok'];
        }

        // 4. Chart Data: Tren Mutasi Stok Masuk vs Keluar per Tanggal
        $mutasiQuery = $db->query("
            SELECT DATE_FORMAT(tanggal, '%d/%m/%Y') as tgl_fmt,
                   DATE(tanggal) as tgl_raw,
                   SUM(CASE WHEN jenis = 'Masuk' THEN jumlah ELSE 0 END) as total_in,
                   SUM(CASE WHEN jenis = 'Keluar' THEN jumlah ELSE 0 END) as total_out
            FROM riwayat_stok
            GROUP BY DATE(tanggal)
            ORDER BY tgl_raw ASC
            LIMIT 10
        ")->getResultArray();

        $chartMutasiLabels = [];
        $chartMutasiIn     = [];
        $chartMutasiOut    = [];
        foreach ($mutasiQuery as $row) {
            $chartMutasiLabels[] = $row['tgl_fmt'];
            $chartMutasiIn[]     = (int) $row['total_in'];
            $chartMutasiOut[]    = (int) $row['total_out'];
        }

        // 5. Chart Data: Jam Tren Akivitas Mutasi Stok (24 Jam)
        $hourlyQuery = $db->query("
            SELECT HOUR(tanggal) as jam,
                   COUNT(*) as total_trx,
                   SUM(jumlah) as total_volume
            FROM riwayat_stok
            GROUP BY HOUR(tanggal)
            ORDER BY jam ASC
        ")->getResultArray();

        $hourlyMap = array_fill(0, 24, 0);
        $hourlyVolumeMap = array_fill(0, 24, 0);

        foreach ($hourlyQuery as $row) {
            $h = (int) $row['jam'];
            $hourlyMap[$h]       = (int) $row['total_trx'];
            $hourlyVolumeMap[$h] = (int) $row['total_volume'];
        }

        $chartHourlyLabels = [];
        $chartHourlyTrx    = [];
        $chartHourlyVolume = [];

        for ($h = 0; $h < 24; $h++) {
            $chartHourlyLabels[] = sprintf('%02d:00', $h);
            $chartHourlyTrx[]    = $hourlyMap[$h];
            $chartHourlyVolume[] = $hourlyVolumeMap[$h];
        }

        $maxTrxValue = max($hourlyMap);
        $peakHourIndex = array_search($maxTrxValue, $hourlyMap);
        $peakHourText = ($maxTrxValue > 0)
            ? sprintf('%02d:00 - %02d:00 WIB', $peakHourIndex, ($peakHourIndex + 1) % 24)
            : 'Belum Ada Transaksi';

        $data = [
            'title'        => 'Dashboard Analisis Utama',
            'description'  => 'Visualisasi grafik, jam tren puncak, & analisis data stok ikan hias.',
            'heading_icon' => 'pe-7s-graph2',
            'activeMenu'   => 'dashboard',
            'stats'        => [
                'total_stok'    => (int) $totalStok,
                'ikan_masuk'    => (int) $ikanMasuk,
                'ikan_keluar'   => (int) $ikanKeluar,
                'total_jenis'   => (int) $totalJenis,
            ],
            'peakHourText'        => $peakHourText,
            'chartKategoriLabels' => json_encode($chartKategoriLabels),
            'chartKategoriData'   => json_encode($chartKategoriData),
            'chartTopFishLabels'  => json_encode($chartTopFishLabels),
            'chartTopFishData'    => json_encode($chartTopFishData),
            'chartMutasiLabels'   => json_encode($chartMutasiLabels),
            'chartMutasiIn'       => json_encode($chartMutasiIn),
            'chartMutasiOut'      => json_encode($chartMutasiOut),
            'chartHourlyLabels'   => json_encode($chartHourlyLabels),
            'chartHourlyTrx'      => json_encode($chartHourlyTrx),
            'chartHourlyVolume'   => json_encode($chartHourlyVolume),
        ];

        return view('dashboard/index', $data);
    }
}
