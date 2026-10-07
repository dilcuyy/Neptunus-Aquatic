<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Filter Section -->
<div class="main-card mb-3 card">
    <div class="card-body">
        <h5 class="card-title">Filter Laporan Mutasi Stok</h5>
        <form class="row g-3" id="formFilterLaporan" method="get" action="<?= base_url('laporan-in-out') ?>">
            <div class="col-md-3">
                <label class="form-label font-weight-bold">Tanggal Awal</label>
                <input type="date" class="form-control" name="tgl_awal" value="<?= esc($tgl_awal ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label font-weight-bold">Tanggal Akhir</label>
                <input type="date" class="form-control" name="tgl_akhir" value="<?= esc($tgl_akhir ?? '') ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label font-weight-bold">Tipe Mutasi</label>
                <select class="form-select" name="jenis">
                    <option value="">Semua (Masuk & Keluar)</option>
                    <option value="Masuk" <?= ($jenis == 'Masuk') ? 'selected' : '' ?>>IN (Masuk)</option>
                    <option value="Keluar" <?= ($jenis == 'Keluar') ? 'selected' : '' ?>>OUT (Keluar)</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" class="btn btn-primary me-2"><i class="fa fa-search me-1"></i> Tampilkan</button>
                <a href="<?= base_url('laporan-in-out') ?>" id="btnResetFilter" class="btn btn-outline-secondary"><i class="fa fa-sync me-1"></i> Reset</a>
            </div>
        </form>
    </div>
</div>

<!-- Report Table Card (AJAX Dynamic Target) -->
<div class="main-card mb-3 card" id="laporanTableCard" style="transition: opacity 0.2s ease-in-out;">
    <div class="card-header">
        Data Rekapitulasi Mutasi Stok (Masuk / Keluar)
        <div class="btn-actions-pane-right">
            <a href="<?= base_url('cetak-laporan') ?>" class="btn btn-outline-primary btn-sm"><i class="fa fa-print me-1"></i> Ke Halaman Cetak</a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover table-striped table-bordered align-middle mb-0">
                <thead class="table-light fs-7">
                    <tr>
                        <th class="text-center text-nowrap" style="width: 60px;">ID</th>
                        <th class="text-center text-nowrap" style="width: 140px;">Tanggal</th>
                        <th style="min-width: 180px;">Nama Ikan</th>
                        <th class="text-center text-nowrap" style="width: 130px;">Tipe Mutasi</th>
                        <th class="text-end text-nowrap" style="width: 110px;">Jumlah</th>
                        <th class="text-end text-nowrap" style="width: 125px;">Harga Satuan</th>
                        <th style="min-width: 160px;">Keterangan</th>
                        <th class="text-center text-nowrap" style="width: 130px;">Petugas</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($reports)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted py-4">Data mutasi stok tidak ditemukan.</td>
                    </tr>
                    <?php else: ?>
                    <?php foreach ($reports as $item): ?>
                    <tr id="row-laporan-<?= $item['id_riwayat'] ?>">
                        <td class="text-center text-nowrap fw-semibold text-secondary">#<?= $item['id_riwayat'] ?></td>
                        <td class="text-center text-nowrap"><?= date('d-m-Y H:i', strtotime($item['tanggal'])) ?></td>
                        <td>
                            <div class="fw-bold text-dark"><?= esc($item['nama_ikan'] ?? 'Ikan #' . $item['id_ikan']) ?></div>
                        </td>
                        <td class="text-center text-nowrap">
                            <?php if ($item['jenis'] == 'Masuk'): ?>
                                <span class="text-success fw-bold"><i class="fa fa-arrow-down me-1"></i> IN (Masuk)</span>
                            <?php else: ?>
                                <span class="text-danger fw-bold"><i class="fa fa-arrow-up me-1"></i> OUT (Keluar)</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end text-nowrap fw-bold text-primary"><?= number_format($item['jumlah']) ?> Ekor</td>
                        <td class="text-end text-nowrap">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                        <td><?= esc($item['keterangan'] ?? '-') ?></td>
                        <td class="text-center text-nowrap text-secondary fw-semibold"><?= esc($item['nama_petugas'] ?? 'System') ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer d-flex flex-wrap justify-content-between align-items-center py-2.5">
        <div class="text-muted fs-7 mb-2 mb-md-0">
            Menampilkan <strong><?= count($reports) ?></strong> data dari total <strong><?= $pager->getTotal() ?></strong> entri mutasi
        </div>
        <div>
            <?= $pager->links('default', 'bs_full') ?>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const cardContainer = document.getElementById("laporanTableCard");
    const filterForm = document.getElementById("formFilterLaporan");
    const btnReset = document.getElementById("btnResetFilter");

    function loadLaporanData(targetUrl, updateHistory = true) {
        if (!cardContainer) return;

        cardContainer.style.opacity = "0.4";
        cardContainer.style.pointerEvents = "none";

        fetch(targetUrl, {
            headers: {
                "X-Requested-With": "XMLHttpRequest"
            }
        })
        .then(res => res.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, "text/html");
            const newCard = doc.getElementById("laporanTableCard");

            if (newCard) {
                cardContainer.innerHTML = newCard.innerHTML;
            }

            if (updateHistory) {
                window.history.pushState({ url: targetUrl }, "", targetUrl);
            }

            cardContainer.style.opacity = "1";
            cardContainer.style.pointerEvents = "auto";
        })
        .catch(err => {
            console.error("Gagal memuat data laporan via AJAX:", err);
            cardContainer.style.opacity = "1";
            cardContainer.style.pointerEvents = "auto";
        });
    }

    // Intercept Pagination Clicks (AJAX Pagination without page refresh)
    document.addEventListener("click", function (e) {
        const pageLink = e.target.closest("#laporanTableCard .page-link");
        if (pageLink && pageLink.hasAttribute("href")) {
            e.preventDefault();
            const href = pageLink.getAttribute("href");
            if (href && href !== "javascript:void(0);" && href !== "#") {
                loadLaporanData(href, true);
            }
        }
    });

    // Intercept Filter Form Submission (AJAX Filter without page refresh)
    if (filterForm) {
        filterForm.addEventListener("submit", function (e) {
            e.preventDefault();
            const formData = new FormData(filterForm);
            const params = new URLSearchParams(formData);
            const baseUrl = filterForm.getAttribute("action") || window.location.pathname;
            const targetUrl = baseUrl + "?" + params.toString();
            loadLaporanData(targetUrl, true);
        });
    }

    // Intercept Reset Filter Button Click
    if (btnReset) {
        btnReset.addEventListener("click", function (e) {
            e.preventDefault();
            const resetUrl = this.getAttribute("href");
            if (filterForm) filterForm.reset();
            loadLaporanData(resetUrl, true);
        });
    }

    // Handle Browser Back/Forward navigation
    window.addEventListener("popstate", function () {
        loadLaporanData(window.location.href, false);
    });

    // Highlight row check on initial load
    const urlParams = new URLSearchParams(window.location.search);
    const highlightId = urlParams.get('highlight');
    const hash = window.location.hash;
    
    let targetEl = null;
    if (highlightId) {
        targetEl = document.getElementById('row-laporan-' + highlightId);
    } else if (hash && hash.startsWith('#row-laporan-')) {
        targetEl = document.querySelector(hash);
    }
    
    if (targetEl) {
        setTimeout(function () {
            targetEl.scrollIntoView({ behavior: 'smooth', block: 'center' });
            targetEl.classList.add('table-row-highlight');
            setTimeout(function () {
                targetEl.classList.remove('table-row-highlight');
            }, 3500);
        }, 300);
    }
});
</script>
<?= $this->endSection() ?>
