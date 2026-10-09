<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Filter Section : compact modern toolbar -->
<style>
.laporan-filter-card{border:0;border-radius:14px;box-shadow:0 1px 3px rgba(16,24,40,.08);overflow:hidden}
.laporan-filter{display:flex;align-items:center;gap:.6rem;flex-wrap:wrap;background:#fff;border:1px solid #e6eaf0;border-radius:14px;padding:.6rem .8rem}
.lf-brand{display:flex;align-items:center;gap:.6rem;padding-right:.8rem;border-right:1px solid #eef1f6;margin-right:.2rem;min-width:170px}
.lf-ico{width:34px;height:34px;border-radius:10px;display:grid;place-items:center;background:#eef4ff;color:#2f6fed;font-size:15px;flex-shrink:0}
.lf-brand strong{display:block;font-size:.82rem;line-height:1.1;color:#1e293b}
.lf-brand small{display:block;font-size:.7rem;color:#8a94a6;line-height:1.2}
.lf-field{position:relative;display:flex;align-items:center}
.lf-field i{position:absolute;left:.65rem;color:#9aa4b2;font-size:.8rem;pointer-events:none}
.lf-field input,.lf-field select{height:36px;border-radius:9px;font-size:.82rem;border:1px solid #e2e8f0;background:#f8fafc;padding-left:2rem}
.lf-field input{width:165px}
.lf-field select{padding-left:.7rem;background-color:#f8fafc;min-width:170px;cursor:pointer}
.lf-field input:focus,.lf-field select:focus{border-color:#2f6fed !important;background:#fff}
.lf-tilde{color:#aab4c4;font-weight:700}
.lf-presets{display:flex;gap:.3rem;background:#f1f5f9;border-radius:999px;padding:3px}
.lf-presets button{border:0;background:transparent;font-size:.74rem;font-weight:600;color:#64748b;padding:.3rem .65rem;border-radius:999px;white-space:nowrap}
.lf-presets button.on,.lf-presets button:hover{background:#fff;color:#1e293b;box-shadow:0 1px 2px rgba(0,0,0,.08)}
.lf-actions{display:flex;gap:.45rem;margin-left:auto;align-items:center}
.cell-truncate{max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.lf-btn{height:36px;border-radius:9px;font-size:.82rem;font-weight:700;padding:0 .95rem;display:inline-flex;align-items:center;gap:.4rem}
.lf-btn-primary{background:#2f6fed;border:0;color:#fff;box-shadow:0 4px 10px rgba(47,111,237,.3)}
.lf-btn-reset{border:1px solid #e2e8f0;background:#fff;color:#64748b;width:36px;padding:0;justify-content:center}
@media(max-width:900px){.lf-brand{border:0}.lf-actions{margin-left:0;width:100%}.lf-btn-primary{flex:1;justify-content:center}}
</style>
<div class="main-card mb-3 card laporan-filter-card">
    <form id="formFilterLaporan" class="laporan-filter" method="get" action="<?= base_url('laporan-in-out') ?>">
        <div class="lf-brand">
            <span class="lf-ico"><i class="fa fa-sliders-h"></i></span>
            <div><strong>Filter Laporan</strong><small>Mutasi Stok</small></div>
        </div>
        <div class="lf-field"><i class="fa fa-calendar"></i><input type="date" id="tglAwal" name="tgl_awal" value="<?= esc($tgl_awal ?? '') ?>" aria-label="Tanggal awal"></div>
        <span class="lf-tilde">–</span>
        <div class="lf-field"><i class="fa fa-calendar"></i><input type="date" id="tglAkhir" name="tgl_akhir" value="<?= esc($tgl_akhir ?? '') ?>" aria-label="Tanggal akhir"></div>
        <div class="lf-field"><select name="jenis" aria-label="Tipe mutasi">
                <option value="">Semua (Masuk &amp; Keluar)</option>
                <option value="Masuk" <?= ($jenis == 'Masuk') ? 'selected' : '' ?>>↓ IN (Masuk)</option>
                <option value="Keluar" <?= ($jenis == 'Keluar') ? 'selected' : '' ?>>↑ OUT (Keluar)</option>
            </select></div>
        <div class="lf-presets" id="lfPresets">
            <button type="button" data-p="today">Hari ini</button>
            <button type="button" data-p="7">7 hari</button>
            <button type="button" data-p="30">30 hari</button>
        </div>
        <div class="lf-actions">
            <button type="submit" class="lf-btn lf-btn-primary"><i class="fa fa-search"></i> Tampilkan</button>
            <a href="<?= base_url('laporan-in-out') ?>" id="btnResetFilter" class="lf-btn lf-btn-reset" title="Reset"><i class="fa fa-sync"></i></a>
        </div>
    </form>
</div>
<script>
document.getElementById('lfPresets')?.addEventListener('click', e => {
    const b = e.target.closest('button'); if (!b) return;
    const d = new Date(), f = x => x.toISOString().slice(0, 10);
    const end = f(d); let start = end;
    if (b.dataset.p === '7') start = f(new Date(Date.now() - 6 * 864e5));
    if (b.dataset.p === '30') start = f(new Date(Date.now() - 29 * 864e5));
    document.getElementById('tglAwal').value = start;
    document.getElementById('tglAkhir').value = end;
    document.querySelectorAll('#lfPresets button').forEach(x => x.classList.remove('on'));
    b.classList.add('on');
});
</script>

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
                        <th style="min-width: 180px;">Nama Item</th>
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
                            <div class="fw-bold text-dark cell-truncate" title="<?= esc($item['nama_item'] ?? $item['nama_ikan'] ?? 'Item #' . $item['id_riwayat']) ?>"><?= esc($item['nama_item'] ?? $item['nama_ikan'] ?? 'Item #' . $item['id_riwayat']) ?></div>
                        </td>
                        <td class="text-center text-nowrap">
                            <?php if ($item['jenis'] == 'Masuk'): ?>
                                <span class="text-success fw-bold"><i class="fa fa-arrow-down me-1"></i> IN (Masuk)</span>
                            <?php else: ?>
                                <span class="text-danger fw-bold"><i class="fa fa-arrow-up me-1"></i> OUT (Keluar)</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end text-nowrap fw-bold text-primary"><?= number_format($item['jumlah']) ?> <?= esc($item['satuan'] ?? 'Ekor') ?></td>
                        <td class="text-end text-nowrap">Rp <?= number_format($item['harga_satuan'], 0, ',', '.') ?></td>
                        <td class="cell-truncate" title="<?= esc($item['keterangan'] ?? '-') ?>"><?= esc($item['keterangan'] ?? '-') ?></td>
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
