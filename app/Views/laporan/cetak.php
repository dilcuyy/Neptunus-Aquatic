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
        margin: 10mm 12mm;
    }
    html, body,
    body.closed-sidebar.fixed-sidebar .app-main .app-main__outer,
    .closed-sidebar.fixed-sidebar .app-main .app-main__outer,
    .fixed-sidebar .app-main .app-main__outer,
    .app-main .app-main__outer,
    .app-main__outer,
    .app-main__inner,
    .app-container,
    .app-main {
        background: #ffffff !important;
        margin: 0 !important;
        padding: 0 !important;
        padding-left: 0 !important;
        padding-right: 0 !important;
        box-shadow: none !important;
        width: 100% !important;
        max-width: 100% !important;
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
        margin: 0 auto !important;
        background: transparent !important;
        width: 100% !important;
    }
    .print-table {
        width: 100% !important;
        table-layout: fixed !important;
        border-collapse: collapse !important;
        font-family: system-ui, -apple-system, "Segoe UI", Roboto, Arial, sans-serif !important;
    }
    .print-table th, .print-table td {
        padding: 4px 6px !important;
        font-size: 9.5px !important;
        line-height: 1.25 !important;
        border: 1px solid #cbd5e1 !important;
        vertical-align: middle !important;
        box-sizing: border-box !important;
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
        font-size: 9.5px !important;
        white-space: nowrap !important;
    }
    .print-table tr {
        page-break-inside: avoid;
        break-inside: avoid;
    }
    .print-table td.nowrap {
        white-space: nowrap !important;
    }
    .print-table td.cell-truncate {
        white-space: nowrap !important;
        overflow: hidden !important;
        text-overflow: ellipsis !important;
    }
    .print-badge-in {
        color: #15803d !important;
        font-weight: 700 !important;
        background-color: #f0fdf4 !important;
        border: 1px solid #bbf7d0 !important;
        padding: 1px 5px !important;
        border-radius: 3px;
        font-size: 8.5px !important;
        white-space: nowrap !important;
        display: inline-block !important;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    }
    .print-badge-out {
        color: #b91c1c !important;
        font-weight: 700 !important;
        background-color: #fef2f2 !important;
        border: 1px solid #fecaca !important;
        padding: 1px 5px !important;
        border-radius: 3px;
        font-size: 8.5px !important;
        white-space: nowrap !important;
        display: inline-block !important;
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
        break-inside: avoid;
    }
}
</style>

<!-- Filter and Action Bar (Screen Only) : compact modern toolbar -->
<style>
.laporan-filter-card{border:0;border-radius:14px;box-shadow:0 1px 3px rgba(16,24,40,.08);overflow:hidden}
.laporan-filter{display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;background:#fff;border:1px solid #e6eaf0;border-radius:14px;padding:.6rem .8rem}
.lf-brand{display:flex;align-items:center;gap:.6rem;padding-right:.8rem;border-right:1px solid #eef1f6;margin-right:.2rem;min-width:170px}
.lf-ico{width:34px;height:34px;border-radius:10px;display:grid;place-items:center;background:#eef4ff;color:#2f6fed;font-size:15px;flex-shrink:0}
.lf-brand strong{display:block;font-size:.82rem;line-height:1.1;color:#1e293b}
.lf-brand small{display:block;font-size:.7rem;color:#8a94a6;line-height:1.2}
.lf-field{position:relative;display:flex;align-items:center}
.lf-field i{position:absolute;left:.65rem;color:#9aa4b2;font-size:.8rem;pointer-events:none}
.lf-field input{height:36px;border-radius:9px;font-size:.82rem;border:1px solid #e2e8f0;background:#f8fafc;padding-left:2rem;width:165px}
.lf-field input:focus{border-color:#2f6fed !important;background:#fff}
.lf-tilde{color:#aab4c4;font-weight:700}
.lf-actions{display:flex;gap:.45rem;margin-left:auto;align-items:center}
.lf-btn{height:36px;border-radius:9px;font-size:.82rem;font-weight:700;padding:0 .95rem;display:inline-flex;align-items:center;gap:.4rem;border:0;cursor:pointer}
.lf-btn-primary{background:#2f6fed;color:#fff;box-shadow:0 4px 10px rgba(47,111,237,.3)}
.lf-btn-print{background:#16a34a;color:#fff;box-shadow:0 4px 10px rgba(22,163,74,.3)}
@media(max-width:900px){.lf-brand{border:0}.lf-actions{margin-left:0;width:100%}.lf-btn{flex:1;justify-content:center}}
.sum-card{display:flex;align-items:center;gap:.7rem;border:1px solid #e6eaf0;border-radius:12px;padding:.7rem .9rem;background:#fff}
.sum-ico{width:36px;height:36px;border-radius:10px;display:grid;place-items:center;font-size:15px;flex-shrink:0}
.sum-card small{display:block;font-size:.68rem;font-weight:700;text-transform:uppercase;letter-spacing:.04em;color:#8a94a6}
.sum-card b{font-size:1.05rem;line-height:1.2}
</style>
<div class="main-card mb-3 card laporan-filter-card no-print">
    <form class="laporan-filter" method="get">
        <div class="lf-brand">
            <span class="lf-ico"><i class="fa fa-calendar-alt"></i></span>
            <div><strong>Periode Cetak</strong><small>Filter tanggal laporan</small></div>
        </div>
        <div class="lf-field"><i class="fa fa-calendar"></i><input type="date" name="tgl_awal" value="<?= esc($tgl_awal) ?>" aria-label="Tanggal awal"></div>
        <span class="lf-tilde">–</span>
        <div class="lf-field"><i class="fa fa-calendar"></i><input type="date" name="tgl_akhir" value="<?= esc($tgl_akhir) ?>" aria-label="Tanggal akhir"></div>
        <div class="lf-actions">
            <button type="submit" class="lf-btn lf-btn-primary"><i class="fa fa-filter"></i> Filter</button>
            <button type="button" onclick="window.print()" class="lf-btn lf-btn-print"><i class="fa fa-print"></i> Cetak Sekarang</button>
        </div>
    </form>
</div>

<!-- Printable Document Container -->
<div class="main-card mb-3 card p-4 print-card">
    <!-- Header / Kop Laporan -->
    <div class="text-center mb-4 border-bottom pb-3">
        <h3 class="fw-bold text-uppercase mb-1 text-dark d-flex align-items-center justify-content-center">
            <i class="pe-7s-drop text-primary me-2 no-print"></i> Neptunus Aquatic
        </h3>
        <h5 class="fw-semibold text-secondary mb-1">Laporan Rekapitulasi Mutasi Stok</h5>
        <small class="text-muted fs-7">
            Periode Filter: <strong><?= date('d/m/Y', strtotime($tgl_awal)) ?></strong> s/d <strong><?= date('d/m/Y', strtotime($tgl_akhir)) ?></strong>
        </small>
    </div>

    <!-- Summary Widgets Header -->
    <div class="row g-2 mb-3">
        <div class="col-4">
            <div class="sum-card">
                <span class="sum-ico" style="background:#e8f7ee;color:#16a34a"><i class="fa fa-arrow-down"></i></span>
                <div><small>Masuk (IN)</small><b class="text-success">+<?= number_format($summary['total_in']) ?></b></div>
            </div>
        </div>
        <div class="col-4">
            <div class="sum-card">
                <span class="sum-ico" style="background:#fdecec;color:#dc2626"><i class="fa fa-arrow-up"></i></span>
                <div><small>Keluar (OUT)</small><b class="text-danger">-<?= number_format($summary['total_out']) ?></b></div>
            </div>
        </div>
        <div class="col-4">
            <div class="sum-card">
                <span class="sum-ico" style="background:#eef4ff;color:#2f6fed"><i class="fa fa-balance-scale"></i></span>
                <div><small>Selisih Netto</small><b class="text-primary"><?= number_format($summary['netto']) ?></b></div>
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
                <th>Nama Item</th>
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
                <td class="fw-bold text-dark cell-truncate" title="<?= esc($r['nama_item'] ?? $r['nama_ikan'] ?? 'Item #' . $r['id_riwayat']) ?>"><?= esc($r['nama_item'] ?? $r['nama_ikan'] ?? 'Item #' . $r['id_riwayat']) ?></td>
                <td class="text-center">
                    <?php if ($r['jenis'] == 'Masuk'): ?>
                        <span class="print-badge-in">IN (MASUK)</span>
                    <?php else: ?>
                        <span class="print-badge-out">OUT (KELUAR)</span>
                    <?php endif; ?>
                </td>
                <td class="text-end fw-bold"><?= number_format($r['jumlah']) ?> <?= esc($r['satuan'] ?? 'Ekor') ?></td>
                <td class="text-end">Rp <?= number_format($r['harga_satuan'], 0, ',', '.') ?></td>
                <td class="cell-truncate" title="<?= esc($r['keterangan'] ?? '-') ?>"><?= esc($r['keterangan'] ?? '-') ?></td>
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
                <th class="text-center" style="width: 38px;">ID</th>
                <th class="text-center" style="width: 105px;">Tanggal</th>
                <th>Nama Item</th>
                <th class="text-center" style="width: 88px;">Tipe Mutasi</th>
                <th class="text-end" style="width: 65px;">Jumlah</th>
                <th class="text-end" style="width: 88px;">Harga Satuan</th>
                <th>Keterangan</th>
                <th class="text-center" style="width: 85px;">Petugas</th>
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
                <td class="text-center text-muted nowrap">#<?= $r['id_riwayat'] ?></td>
                <td class="text-center nowrap"><?= date('d-m-Y H:i', strtotime($r['tanggal'])) ?></td>
                <td class="fw-bold text-dark cell-truncate" title="<?= esc($r['nama_item'] ?? $r['nama_ikan'] ?? 'Item #' . $r['id_riwayat']) ?>"><?= esc($r['nama_item'] ?? $r['nama_ikan'] ?? 'Item #' . $r['id_riwayat']) ?></td>
                <td class="text-center nowrap">
                    <?php if ($r['jenis'] == 'Masuk'): ?>
                        <span class="print-badge-in">IN (MASUK)</span>
                    <?php else: ?>
                        <span class="print-badge-out">OUT (KELUAR)</span>
                    <?php endif; ?>
                </td>
                <td class="text-end fw-bold nowrap"><?= number_format($r['jumlah']) ?> <?= esc($r['satuan'] ?? 'Ekor') ?></td>
                <td class="text-end nowrap">Rp <?= number_format($r['harga_satuan'], 0, ',', '.') ?></td>
                <td class="cell-truncate" title="<?= esc($r['keterangan'] ?? '-') ?>"><?= esc($r['keterangan'] ?? '-') ?></td>
                <td class="text-center text-muted nowrap"><?= esc($r['nama_petugas'] ?? 'System') ?></td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Footer Sign-off Block -->
    <div class="d-flex justify-content-between align-items-start mt-5 pt-4 signature-block">
        <div class="text-muted fs-8">
            Dicetak pada: <?= date('d-m-Y H:i') ?> WIB<br>
            Oleh System Neptunus Aquatic
        </div>
        <div class="text-center" style="width: 240px;">
            <p class="text-dark fs-7 mb-0">Penanggung Jawab Ops,</p>
            <div style="height: 110px;"></div>
            <p class="fw-bold text-dark border-bottom pb-1 mb-0 fs-7">( <?= esc($penanggung_jawab ?? 'Admin Toko Ikan') ?> )</p>
        </div>
    </div>
</div>
<?= $this->endSection() ?>
