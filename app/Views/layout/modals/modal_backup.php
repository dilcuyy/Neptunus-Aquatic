<!-- Modal Backup & Ekspor Data -->
<div class="modal fade" id="modalBackup" tabindex="-1" aria-labelledby="modalBackupLabel" aria-hidden="true" style="z-index: 1080;">
    <div class="modal-dialog modal-dialog-centered modal-dialog-modern">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="modal-header-icon">
                        <i class="pe-7s-cloud-download"></i>
                    </div>
                    <div>
                        <h5 class="modal-title-text" id="modalBackupLabel">Backup & Ekspor Data</h5>
                        <div class="modal-subtitle-text">Unduh dan cadangkan arsip inventaris database</div>
                    </div>
                </div>
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                    <i class="pe-7s-close"></i>
                </button>
            </div>
            <form action="<?= base_url('backup/export') ?>" method="get" target="_blank" id="formBackupData">
                <div class="modal-body-modern">
                    <div class="modal-alert-info">
                        <i class="pe-7s-info modal-alert-icon"></i>
                        <div class="modal-alert-text">
                            Pilih kategori data, filter rentang tanggal, dan format arsip.
                        </div>
                    </div>

                    <div class="row g-2">
                        <!-- Target Backup Option -->
                        <div class="col-12">
                            <label class="modal-label mb-1" for="backupTargetSelect">Kategori Data Backup <span class="text-danger">*</span></label>
                            <select class="form-select modal-input py-1.5" name="target" id="backupTargetSelect" required>
                                <option value="semua">Semua Data (Data Stok + Laporan Mutasi)</option>
                                                                <option value="stok">Data Stok (Master Inventaris)</option>
                                <option value="laporan">Data Laporan Mutasi Stok (IN / OUT)</option>
                            </select>
                            <div class="text-muted mt-1" id="stokNoteText" style="display: none; font-size: 0.7188rem; line-height: 1.3;">
                                <i class="pe-7s-info me-1 text-primary"></i> Data Stok merupakan master inventaris saat ini.
                            </div>
                        </div>

                        <!-- Filter Options Box (Strictly for Laporan Mutasi) -->
                        <div class="col-12" id="backupFilterSection">
                            <div class="p-2 rounded-2 border" style="background: #f8fafc; border-color: #e2e8f0 !important;">
                                <div class="d-flex align-items-center mb-1.5 text-dark fw-semibold" style="font-size: 0.75rem; gap: 6px;">
                                    <i class="pe-7s-filter text-primary fs-6"></i>
                                    <span>Filter Tambahan Mutasi (Opsional)</span>
                                </div>
                                <div class="row g-1.5">
                                    <div class="col-6">
                                        <label class="modal-label text-muted mb-0.5" style="font-size: 0.6875rem;" for="backupTglAwal">Tanggal Awal</label>
                                        <input type="date" class="form-control modal-input py-1 px-2" style="font-size: 0.75rem;" name="tgl_awal" id="backupTglAwal">
                                    </div>
                                    <div class="col-6">
                                        <label class="modal-label text-muted mb-0.5" style="font-size: 0.6875rem;" for="backupTglAkhir">Tanggal Akhir</label>
                                        <input type="date" class="form-control modal-input py-1 px-2" style="font-size: 0.75rem;" name="tgl_akhir" id="backupTglAkhir">
                                    </div>
                                    <div class="col-12 mt-1.5">
                                        <label class="modal-label text-muted mb-0.5" style="font-size: 0.6875rem;" for="backupJenisSelect">Tipe Mutasi</label>
                                        <select class="form-select modal-input py-1 px-2" style="font-size: 0.75rem;" name="jenis" id="backupJenisSelect">
                                            <option value="">Semua (Masuk & Keluar)</option>
                                            <option value="Masuk">IN (Stok Masuk)</option>
                                            <option value="Keluar">OUT (Stok Keluar)</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Format Download -->
                        <div class="col-12">
                            <label class="modal-label mb-1.5">Format File Cadangan <span class="text-danger">*</span></label>
                            <div class="format-pill-group" role="group">
                                <div>
                                    <input type="radio" class="btn-check" name="format" id="fmtJson" value="json" checked autocomplete="off">
                                    <label class="format-pill-label" for="fmtJson">
                                        <span>JSON</span>
                                        <span class="format-pill-ext">.json</span>
                                    </label>
                                </div>

                                <div>
                                    <input type="radio" class="btn-check" name="format" id="fmtCsv" value="csv" autocomplete="off">
                                    <label class="format-pill-label" for="fmtCsv">
                                        <span>CSV</span>
                                        <span class="format-pill-ext">.csv</span>
                                    </label>
                                </div>

                                <div>
                                    <input type="radio" class="btn-check" name="format" id="fmtSql" value="sql" autocomplete="off">
                                    <label class="format-pill-label" for="fmtSql">
                                        <span>SQL</span>
                                        <span class="format-pill-ext">.sql</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="modal-btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Batal</button>
                    <button type="submit" class="modal-btn-primary">
                        <i class="pe-7s-cloud-download"></i>
                        <span>Download Backup</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
