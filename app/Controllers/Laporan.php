<?php

namespace App\Controllers;

use App\Models\RiwayatStokModel;

class Laporan extends BaseController
{
    public function inOut()
    {
        $riwayatModel = new RiwayatStokModel();

        $tglAwal  = $this->request->getGet('tgl_awal');
        $tglAkhir = $this->request->getGet('tgl_akhir');
        $jenis    = $this->request->getGet('jenis');

        $reports = $riwayatModel->getRiwayatPaginated(10, $tglAwal, $tglAkhir, $jenis);

        $data = [
            'title'        => 'Laporan In/Out',
            'description'  => 'Rekapitulasi data mutasi ikan masuk (IN) & keluar (OUT).',
            'heading_icon' => 'pe-7s-repeat',
            'activeMenu'   => 'laporan_in_out',
            'tgl_awal'     => $tglAwal,
            'tgl_akhir'    => $tglAkhir,
            'jenis'        => $jenis,
            'reports'      => $reports,
            'pager'        => $riwayatModel->pager,
        ];

        return view('laporan/in_out', $data);
    }

    public function cetak()
    {
        $riwayatModel = new RiwayatStokModel();

        $tglAwal  = $this->request->getGet('tgl_awal');
        $tglAkhir = $this->request->getGet('tgl_akhir');

        $reports = $riwayatModel->getRiwayatWithDetails(null, $tglAwal, $tglAkhir);

        $totalIn  = 0;
        $totalOut = 0;

        foreach ($reports as $r) {
            if ($r['jenis'] == 'Masuk') {
                $totalIn += (int) $r['jumlah'];
            } else {
                $totalOut += (int) $r['jumlah'];
            }
        }

        $data = [
            'title'        => 'Cetak Laporan',
            'description'  => 'Cetak dan ekspor laporan mutasi stok ikan Neptunus Aquatic.',
            'heading_icon' => 'pe-7s-print',
            'activeMenu'   => 'cetak_laporan',
            'tgl_awal'     => $tglAwal ?? date('Y-m-01'),
            'tgl_akhir'    => $tglAkhir ?? date('Y-m-d'),
            'summary'      => [
                'total_in'  => $totalIn,
                'total_out' => $totalOut,
                'netto'     => $totalIn - $totalOut,
            ],
            'reports'      => $reports
        ];

        return view('laporan/cetak', $data);
    }
}
