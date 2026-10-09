<?php
$modPengaturanModel = new \App\Models\PengaturanModel();
$modNamaToko = $modPengaturanModel->getSetting('nama_toko', 'Neptunus Aquatic');
$modSubTitle = $modPengaturanModel->getSetting('sub_title', 'Manager Operasional');
$modStokKritis = $modPengaturanModel->getSetting('stok_kritis', '5');
?>
<!-- Modal Pengaturan Aplikasi -->
<div class="modal fade" id="modalPengaturan" tabindex="-1" aria-labelledby="modalPengaturanLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-modern">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="modal-header-icon">
                        <i class="pe-7s-config"></i>
                    </div>
                    <div>
                        <h5 class="modal-title-text" id="modalPengaturanLabel">Pengaturan Aplikasi</h5>
                        <div class="modal-subtitle-text">Konfigurasi parameter umum dan batas peringatan stok</div>
                    </div>
                </div>
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
                    <i class="pe-7s-close"></i>
                </button>
            </div>
            <form id="formUpdatePengaturan">
                <div class="modal-body-modern">
                    <div class="row g-2.5">
                        <div class="col-12">
                            <label class="modal-label" for="settingNamaToko">Nama Toko / Enterprise</label>
                            <input type="text" class="form-control modal-input" name="nama_toko" id="settingNamaToko" value="<?= esc($modNamaToko) ?>" placeholder="Contoh: Neptunus Aquatic" maxlength="50" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <label class="modal-label" for="settingSubTitle">Sub-judul / Jabatan Header</label>
                            <input type="text" class="form-control modal-input" name="sub_title" id="settingSubTitle" value="<?= esc($modSubTitle) ?>" placeholder="Contoh: Manager Operasional" maxlength="50" autocomplete="off">
                        </div>
                        <div class="col-12">
                            <label class="modal-label" for="settingStokKritis">Batas Stok Kritis (Unit)</label>
                            <div class="modal-input-group">
                                <input type="number" class="form-control modal-input" name="stok_kritis" id="settingStokKritis" value="<?= esc($modStokKritis) ?>" min="1" max="999" placeholder="5">
                                                            <span class="input-group-addon">Unit</span>
                            </div>
                            <div class="small text-muted mt-1.5" style="font-size: 0.75rem;">Item dengan sisa stok di bawah angka ini akan otomatis masuk ke daftar notifikasi restok.</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="modal-btn-secondary" data-bs-dismiss="modal" data-dismiss="modal">Batal</button>
                    <button type="submit" class="modal-btn-primary">
                        <i class="pe-7s-check"></i>
                        <span>Simpan Pengaturan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
