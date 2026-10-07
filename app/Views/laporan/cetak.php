<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Printable Sheet Styling -->
<style>
.print-only-table {
    display: none !important;
}

@media print {
    @page {
        size: A4 portrait;
        margin: 12mm 15mm;
    }
    html, body, .app-container, .app-main, .app-main__outer, .app-main__inner {
        background: #ffffff !important;
        margin: 0 !important;
        padding: 0 !important;
        box-shadow: none !important;
        width: 100% !important;
    }
    .app-header, .app-sidebar, .app-page-title, .app-wrapper-footer, .no-print {
        display: none !important;
    }
    .print-only-table {
        display: table !important;
    }
    .print-card {
        border: none !important;
        box-shadow: none !important;
        padding: 0 !important;
        margin: 0 !important;
        background: transparent !important;
    }
    .print-table {
        width: 100% !important;
        border-collapse: collapse !important;
    }
    .print-table th, .print-table td {
        padding: 6px 8px !important;
        font-size: 11px !important;
        border: 1px solid #cbd5e1 !important;
        vertical-align: middle !important;
    }
    .print-table thead {
        display: table-header-group;
        background-color: #f1f5f9 !important;
        color: #0f172a !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .print-table thead th {
        font-weight: 700 !important;
        border-bottom: 2px solid #94a3b8 !important;
    }
    .print-table tr {
        page-break-inside: avoid;
    }
    .print-badge-in {
        color: #15803d !important;
        font-weight: 700 !important;
        background-color: #f0fdf4 !important;
        border: 1px solid #bbf7d0 !important;
        padding: 2px 6px !important;
        border-radius: 4px;
        font-size: 10px !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .print-badge-out {
        color: #b91c1c !important;
        font-weight: 700 !important;
        background-color: #fef2f2 !important;
        border: 1px solid #fecaca !important;
        padding: 2px 6px !important;
        border-radius: 4px;
        font-size: 10px !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .summary-widget-box {
        border: 1px solid #cbd5e1 !important;
        background-color: #f8fafc !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .signature-block {
        page-break-inside: avoid;
    }
}
</style>

<!-- Filter and Action Bar (Screen Only) -->
<div class="main-card mb-3 card no-print border shadow-sm">
    <div class="card-body py-2.5 px-3">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
            <form class="d-flex align-items-center flex-wrap gap-2 mb-0" method="get">
                <span class="fw-bold text-dark fs-7 me-1">Periode Tanggal:</span>
                <input type="date" class="form-control form-control-sm border" style="width: 145px;" name="tgl_awal" value="<?= esc($tgl_awal) ?>">
                <span class="text-muted fs-7 mx-1">s/d</span>
                <input type="date" class="form-control form-control-sm border" style="width: 145px;" name="tgl_akhir" value="<?= esc($tgl_akhir) ?>">
                <button type="submit" class="btn btn-primary btn-sm px-3 fw-bold d-inline-flex align-items-center justify-content-center" style="height: 31px;">
                    <i class="fa fa-filter me-1 fs-8"></i> Filter
                </button>
            </form>
            <button onclick="window.print()" class="btn btn-success btn-sm px-3 fw-bold shadow-sm d-inline-flex align-items-center justify-content-center" style="height: 31px;">
                <i class="fa fa-print me-1 fs-7"></i> Cetak Laporan Sekarang
            </button>
        </div>
    </div>
</div>

<!-- Printable Document Container -->
<div class="main-card mb-3 card p-4 print-card">
    <!-- Header / Kop Laporan -->
    <div class="text-center mb-4 border-bottom pb-3">
        <h3 class="fw-bold text-uppercase mb-1 text-dark d-flex align-items-center justify-content-center">
            <i class="pe-7s-drop text-primary me-2 no-print"></i> Neptunus Aquatic
        </h3>
        <h5 class="fw-semibold text-secondary mb-1">Laporan Rekapitulasi Mutasi Stok Ikan Hias</h5>
        <small class="text-muted fs-7">
            Periode Filter: <strong><?= date('d/m/Y', strtotime($tgl_awal)) ?></strong> s/d <strong><?= date('d/m/Y', strtotime($tgl_akhir)) ?></strong>
        </small>
    </div>

    <!-- Summary Widgets Header -->
    <div class="row g-3 mb-4">
        <div class="col-4">
            <div class="border rounded p-2.5 text-center bg-light summary-widget-box">
                <small class="text-muted text-uppercase fw-bold d-block fs-8 mb-1">Total Ikan Masuk (IN)</small>
                <span class="fs-5 fw-bold text-success">+<?= number_format($summary['total_in']) ?> Ekor</span>
            </div>
        </div>
        <div class="col-4">
            <div class="border rounded p-2.5 text-center bg-light summary-widget-box">
                <small class="text-muted text-uppercase fw-bold d-block fs-8 mb-1">Total Ikan Keluar (OUT)</small>
                <span class="fs-5 fw-bold text-danger">-<?= number_format($summary['total_out']) ?> Ekor</span>
            </div>
        </div>
        <div class="col-4">
            <div class="border rounded p-2.5 text-center bg-light summary-widget-box">
                <small class="text-muted text-uppercase fw-bold d-block fs-8 mb-1">Selisih Netto</small>
                <span class="fs-5 fw-bold text-primary"><?= number_format($summary['netto']) ?> Ekor</span>
            </div>
        </div>
    </div>

    <?php $reportsPreview = array_slice($reports, 0, 10); ?>

    <!-- Subtle Preview Info (Screen Only) -->
    <div class="text-muted fs-8 mb-2 no-print fst-italic">
        * Menampilkan preview <?= min(10, count($reports)) ?> dari total <?= count($reports) ?> data mutasi (seluruh data akan dicetak lengkap saat tombol dicetak).
    </div>

    <!-- Detailed Mutation Table (Screen Preview: Max 10 items) -->
    <table class="table table-bordered align-middle print-table no-print">
        <thead class="table-dark">
            <tr>
                <th class="text-center" style="width: 45px;">ID</th>
                <th class="text-center" style="width: 120px;">Tanggal</th>
                <th>Nama Jenis Ikan</th>
                <th class="text-center" style="width: 100px;">Tipe Mutasi</th>
                <th class="text-end" style="width: 90px;">Jumlah</th>
                <th class="text-end" style="width: 110px;">Harga Satuan</th>
                <th>Keterangan</th>
                <th class="text-center" style="width: 100px;">Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reportsPreview)): ?>
            <tr>
                <td colspan="8" class="text-center text-muted py-4 fs-7">Tidak ada data mutasi pada periode tanggal ini.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($reportsPreview as $r): ?>
            <tr>
                <td class="text-center text-muted">#<?= $r['id_riwayat'] ?></td>
                <td class="text-center"><?= date('d-m-Y H:i', strtotime($r['tanggal'])) ?></td>
                <td class="fw-bold text-dark"><?= esc($r['nama_ikan'] ?? 'Ikan #' . $r['id_ikan']) ?></td>
                <td class="text-center">
                    <?php if ($r['jenis'] == 'Masuk'): ?>
                        <span class="print-badge-in">IN (MASUK)</span>
                    <?php else: ?>
                        <span class="print-badge-out">OUT (KELUAR)</span>
                    <?php endif; ?>
                </td>
                <td class="text-end fw-bold"><?= number_format($r['jumlah']) ?> Ekor</td>
                <td class="text-end">Rp <?= number_format($r['harga_satuan'], 0, ',', '.') ?></td>
                <td><?= esc($r['keterangan'] ?? '-') ?></td>
                <td class="text-center text-muted"><?= esc($r['nama_petugas'] ?? 'System') ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Detailed Mutation Table (Print Only: All items) -->
    <table class="table table-bordered align-middle print-table print-only-table">
        <thead class="table-dark">
            <tr>
                <th class="text-center" style="width: 45px;">ID</th>
                <th class="text-center" style="width: 120px;">Tanggal</th>
                <th>Nama Jenis Ikan</th>
                <th class="text-center" style="width: 100px;">Tipe Mutasi</th>
                <th class="text-end" style="width: 90px;">Jumlah</th>
                <th class="text-end" style="width: 110px;">Harga Satuan</th>
                <th>Keterangan</th>
                <th class="text-center" style="width: 100px;">Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($reports)): ?>
            <tr>
                <td colspan="8" class="text-center text-muted py-4 fs-7">Tidak ada data mutasi pada periode tanggal ini.</td>
            </tr>
            <?php else: ?>
            <?php foreach ($reports as $r): ?>
            <tr>
                <td class="text-center text-muted">#<?= $r['id_riwayat'] ?></td>
                <td class="text-center"><?= date('d-m-Y H:i', strtotime($r['tanggal'])) ?></td>
                <td class="fw-bold text-dark"><?= esc($r['nama_ikan'] ?? 'Ikan #' . $r['id_ikan']) ?></td>
                <td class="text-center">
                    <?php if ($r['jenis'] == 'Masuk'): ?>
                        <span class="print-badge-in">IN (MASUK)</span>
                    <?php else: ?>
                        <span class="print-badge-out">OUT (KELUAR)</span>
                    <?php endif; ?>
                </td>
                <td class="text-end fw-bold"><?= number_format($r['jumlah']) ?> Ekor</td>
                <td class="text-end">Rp <?= number_format($r['harga_satuan'], 0, ',', '.') ?></td>
                <td><?= esc($r['keterangan'] ?? '-') ?></td>
                <td class="text-center text-muted"><?= esc($r['nama_petugas'] ?? 'System') ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Footer Sign-off Block -->
    <div class="d-flex justify-content-between align-items-end mt-4 pt-3 signature-block">
        <div class="text-muted fs-8">
            Dicetak pada: <?= date('d-m-Y H:i') ?> WIB<br>
            Oleh System Neptunus Aquatic
        </div>
        <div class="text-center" style="width: 210px;">
            <p class="mb-4 text-dark fs-7">Penanggung Jawab Ops,</p>
            <p class="fw-bold text-dark border-bottom pb-1 mb-0 fs-7">( Manager Neptunus )</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
