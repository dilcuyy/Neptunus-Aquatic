<?= $this->extend('layout/main') ?>

<?= $this->section('content') ?>
<!-- Flash Message Notification via Toast -->
<?php if (session()->getFlashdata('success')): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    showToast('success', 'Berhasil', '<?= esc(session()->getFlashdata('success')) ?>');
});
</script>
<?php endif; ?>

<?php if (session()->getFlashdata('error')): ?>
<script>
document.addEventListener("DOMContentLoaded", function() {
    showToast('danger', 'Gagal', '<?= esc(session()->getFlashdata('error')) ?>');
});
</script>
<?php endif; ?>

<!-- Main Table Card -->
<style>
.btn-kategori-plus {
    border: 1px solid #ced4da !important;
    background-color: #f8fafc !important;
    color: #495057 !important;
    font-weight: bold;
    padding-left: 12px;
    padding-right: 12px;
}
.btn-kategori-plus:hover {
    background-color: #e2e8f0 !important;
    color: #1e293b !important;
    border-color: #cbd5e1 !important;
}
.cell-truncate{max-width:220px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.cell-truncate-sm{max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;display:block}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                Daftar Inventaris Stok
                <div class="btn-actions-pane-right">
                    <button class="btn btn-success btn-sm btn-shadow" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        Tambah Data Stok
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered align-middle mb-0">
                        <thead class="table-light fs-7">
                            <tr>
                                <th class="text-center text-nowrap" style="width: 60px;">ID</th>
                                <th style="min-width: 200px;">Nama Item</th>
                                <th class="text-center text-nowrap" style="width: 180px;">Kategori</th>
                                <th class="text-end text-nowrap" style="width: 125px;">Harga Beli</th>
                                <th class="text-end text-nowrap" style="width: 125px;">Harga Jual</th>
                                <th class="text-end text-nowrap" style="width: 125px;">Jumlah Stok</th>
                                <th class="text-center text-nowrap" style="width: 125px;">Status Stok</th>
                                <th class="text-center text-nowrap" style="width: 95px;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($fish_list)): ?>
                            <tr>
                                <td colspan="8" class="text-center text-muted py-4">Tidak ada data stok ditemukan.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($fish_list as $fish): ?>
                            <tr id="row-stok-<?= $fish['id_ikan'] ?>">
                                <td class="text-center text-nowrap fw-semibold text-secondary">#<?= $fish['id_ikan'] ?></td>
                                <td>
                                    <?php $fotoFile = !empty($fish['foto']) ? $fish['foto'] : (!empty($fish['gambar']) ? $fish['gambar'] : 'default.jpg'); ?>
                                    <div class="d-flex align-items-center gap-2">
                                        <img src="<?= base_url('uploads/ikan/' . $fotoFile) ?>" alt="" class="rounded border flex-shrink-0" style="width:38px;height:38px;object-fit:cover;background:#f8fafc;" loading="lazy" onerror="this.src='<?= base_url('uploads/ikan/default.jpg') ?>'">
                                        <div class="min-w-0">
                                            <div class="fw-bold cell-truncate" title="<?= esc($fish['nama_ikan']) ?>"><?= esc($fish['nama_ikan']) ?></div>
                                            <small class="text-muted cell-truncate-sm" title="<?= esc($fish['deskripsi'] ?? '-') ?>"><?= esc($fish['deskripsi'] ?? '-') ?></small>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center text-nowrap"><span class="badge bg-info"><?= esc($fish['nama_kategori'] ?? 'Umum') ?></span></td>
                                <td class="text-end text-nowrap">Rp <?= number_format($fish['harga_beli'], 0, ',', '.') ?></td>
                                <td class="text-end text-nowrap fw-bold text-success">Rp <?= number_format($fish['harga_jual'], 0, ',', '.') ?></td>
                                <td class="text-end text-nowrap fw-bold text-primary"><?= number_format($fish['stok']) ?> <?= esc($fish['satuan'] ?? 'Ekor') ?></td>
                                <td class="text-center text-nowrap">
                                    <span class="badge <?= $fish['badge'] ?>"><?= $fish['status_stok'] ?></span>
                                </td>
                                <td class="text-center text-nowrap">
                                    <button class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#modalEdit<?= $fish['id_ikan'] ?>" title="Edit Data">
                                        <i class="fa fa-edit"></i>
                                    </button>
                                    <button type="button" class="btn btn-danger btn-sm btn-hapus-ikan" 
                                            data-bs-toggle="modal" data-bs-target="#modalKonfirmasiHapus"
                                            data-toggle="modal" data-target="#modalKonfirmasiHapus"
                                            data-id="<?= $fish['id_ikan'] ?>" 
                                            data-nama="<?= esc($fish['nama_ikan']) ?>" 
                                            title="Hapus Data">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card-footer d-flex justify-content-between align-items-center">
                <span>Total Jenis Stok: <strong><?= count($fish_list) ?></strong> jenis</span>
                <small class="text-muted">Kritis ≤ <?= (int) ($batas_kritis ?? 5) ?> • Habis = 0 • Neptunus Aquatic System</small>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const urlParams = new URLSearchParams(window.location.search);
    const highlightId = urlParams.get('highlight');
    const hash = window.location.hash;
    
    let targetEl = null;
    if (highlightId) {
        targetEl = document.getElementById('row-stok-' + highlightId);
    } else if (hash && hash.startsWith('#row-stok-')) {
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

    // Modal Hapus Confirmation Listener
    document.addEventListener("click", function (e) {
        const btnHapus = e.target.closest(".btn-hapus-ikan");
        if (btnHapus) {
            const id = btnHapus.getAttribute("data-id");
            const nama = btnHapus.getAttribute("data-nama");

            if (typeof showConfirmModal === 'function') {
                showConfirmModal(
                    "Konfirmasi Hapus Data Stok",
                    `Apakah Anda yakin ingin menghapus data stok <strong>${nama}</strong>?`,
                    function () {
                        window.location.href = "<?= base_url('stok-ikan/hapus') ?>/" + id;
                    }
                );
            } else {
                const judulEl = document.getElementById("konfirmasiJudul");
                const textEl = document.getElementById("konfirmasiText");
                if (judulEl) judulEl.textContent = "Konfirmasi Hapus Data Stok";
                if (textEl) textEl.innerHTML = `Apakah Anda yakin ingin menghapus data stok <strong>${nama}</strong>?`;
                
                window.confirmActionCallback = function () {
                    window.location.href = "<?= base_url('stok-ikan/hapus') ?>/" + id;
                };
                if (typeof showModalSafely === 'function') {
                    showModalSafely("modalKonfirmasiHapus");
                }
            }
        }
    });
});
</script>
<?= $this->endSection() ?>

<!-- Root Level Modals Section (outside app-container to prevent stacking context dark overlay) -->
<?= $this->section('modals') ?>
<!-- Modal Tambah Kategori Baru -->
<div class="modal fade" id="modalTambahKategori" tabindex="-1" aria-labelledby="modalTambahKategoriLabel" aria-hidden="true" style="z-index: 1085;">
    <div class="modal-dialog modal-dialog-centered modal-sm modal-dialog-modern">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="modal-header-icon"><i class="pe-7s-plus"></i></div>
                    <div>
                        <h5 class="modal-title-text" id="modalTambahKategoriLabel">Tambah Kategori</h5>
                        <div class="modal-subtitle-text">Ekor untuk ikan, Pcs untuk barang</div>
                    </div>
                </div>
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="pe-7s-close"></i></button>
            </div>
            <form action="<?= base_url('stok-ikan/simpan-kategori') ?>" method="post">
                <div class="modal-body-modern">
                    <div class="mb-2">
                        <label class="modal-label">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control modal-input" name="nama_kategori" placeholder="Contoh: Pakan / Aksesori" required autocomplete="off" maxlength="50">
                    </div>
                    <div>
                        <label class="modal-label">Satuan <span class="text-danger">*</span></label>
                        <select class="form-select modal-input" name="satuan" required>
                            <option value="Ekor">Ekor (ikan hidup)</option>
                            <option value="Pcs">Pcs (barang / pakan)</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="modal-btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="modal-btn-primary"><i class="pe-7s-check"></i><span>Simpan</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Stok -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-modern modal-dialog-modern-lg">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="modal-header-icon"><i class="pe-7s-plus"></i></div>
                    <div>
                        <h5 class="modal-title-text" id="modalTambahLabel">Tambah Data Stok</h5>
                        <div class="modal-subtitle-text">Ikan, pakan, atau barang toko</div>
                    </div>
                </div>
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="pe-7s-close"></i></button>
            </div>
            <form action="<?= base_url('stok-ikan/simpan') ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body-modern">
                    <div class="foto-picker-clean">
                        <div class="position-relative d-inline-block flex-shrink-0">
                            <img id="fotoPreviewTambah" src="<?= base_url('uploads/ikan/default.jpg') ?>" class="modal-avatar-preview-sm" alt="Foto item">
                            <label for="fotoInputTambah" class="modal-avatar-btn" title="Pilih foto"><i class="pe-7s-camera"></i></label>
                            <input type="file" id="fotoInputTambah" name="foto" class="d-none" accept="image/*">
                        </div>
                        <p class="foto-picker-hint">Foto opsional. JPG/PNG/WebP maks 2MB.</p>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="modal-label">Nama Item <span class="text-danger">*</span></label>
                            <input type="text" class="form-control modal-input" name="nama_ikan" placeholder="Contoh: Pakan Pelet 1kg" required maxlength="100" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Kategori <span class="text-danger">*</span></label>
                            <div class="modal-input-group">
                                <select class="form-select modal-input" name="id_kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($kategori_list as $kat): ?>
                                    <option value="<?= $kat['id_kategori'] ?>"><?= esc($kat['nama_kategori']) ?> (<?= esc($kat['satuan'] ?? 'Ekor') ?>)</option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="input-group-addon border-0" data-bs-toggle="modal" data-bs-target="#modalTambahKategori" title="Tambah Kategori Baru" style="cursor:pointer;">+</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Harga Beli (Rp) <span class="text-danger">*</span></label>
                            <input type="text" inputmode="numeric" class="form-control modal-input rupiah-input" name="harga_beli" placeholder="0" required maxlength="11" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <input type="text" inputmode="numeric" class="form-control modal-input rupiah-input" name="harga_jual" placeholder="0" required maxlength="11" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Stok Awal <span class="text-danger">*</span></label>
                            <input type="number" class="form-control modal-input" name="stok" placeholder="0" required min="0" max="999999">
                        </div>
                        <div class="col-md-12">
                            <label class="modal-label">Deskripsi Item</label>
                            <textarea class="form-control modal-input" name="deskripsi" rows="2" maxlength="255" placeholder="Spesifikasi singkat, ukuran, atau penggunaan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="modal-btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="modal-btn-primary"><i class="pe-7s-check"></i><span>Simpan</span></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modals Edit Stok -->
<?php if (!empty($fish_list)): ?>
<?php foreach ($fish_list as $fish): ?>
<div class="modal fade" id="modalEdit<?= $fish['id_ikan'] ?>" tabindex="-1" aria-labelledby="modalEditLabel<?= $fish['id_ikan'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-modern modal-dialog-modern-lg">
        <div class="modal-content modal-content-modern">
            <div class="modal-header-modern">
                <div class="d-flex align-items-center gap-2.5">
                    <div class="modal-header-icon"><i class="pe-7s-pen"></i></div>
                    <div>
                        <h5 class="modal-title-text" id="modalEditLabel<?= $fish['id_ikan'] ?>">Edit: <?= esc($fish['nama_ikan']) ?></h5>
                        <div class="modal-subtitle-text">Stok diubah via Kasir / Restock</div>
                    </div>
                </div>
                <button type="button" class="modal-btn-close" data-bs-dismiss="modal" aria-label="Close"><i class="pe-7s-close"></i></button>
            </div>
            <?php $fotoEdit = !empty($fish['foto']) ? $fish['foto'] : (!empty($fish['gambar']) ? $fish['gambar'] : 'default.jpg'); ?>
            <form action="<?= base_url('stok-ikan/update/' . $fish['id_ikan']) ?>" method="post" enctype="multipart/form-data">
                <div class="modal-body-modern">
                    <div class="foto-picker-clean">
                        <div class="position-relative d-inline-block flex-shrink-0">
                            <img id="fotoPreviewEdit<?= $fish['id_ikan'] ?>" src="<?= base_url('uploads/ikan/' . $fotoEdit) ?>" class="modal-avatar-preview-sm" alt="Foto item" onerror="this.src='<?= base_url('uploads/ikan/default.jpg') ?>'">
                            <label for="fotoInputEdit<?= $fish['id_ikan'] ?>" class="modal-avatar-btn" title="Ganti foto"><i class="pe-7s-camera"></i></label>
                            <input type="file" id="fotoInputEdit<?= $fish['id_ikan'] ?>" name="foto" class="d-none foto-input-edit" data-preview="fotoPreviewEdit<?= $fish['id_ikan'] ?>" accept="image/*">
                        </div>
                        <p class="foto-picker-hint">Kosongkan jika tidak ganti foto. JPG/PNG/WebP maks 2MB.</p>
                    </div>
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="modal-label">Nama Item <span class="text-danger">*</span></label>
                            <input type="text" class="form-control modal-input" name="nama_ikan" value="<?= esc($fish['nama_ikan']) ?>" required maxlength="100" autocomplete="off">
                        </div>
                        <div class="col-md-6">
                            <label class="modal-label">Kategori <span class="text-danger">*</span></label>
                            <div class="modal-input-group">
                                <select class="form-select modal-input" name="id_kategori" required>
                                    <?php foreach ($kategori_list as $kat): ?>
                                    <option value="<?= $kat['id_kategori'] ?>" <?= ($kat['id_kategori'] == $fish['id_kategori']) ? 'selected' : '' ?>>
                                        <?= esc($kat['nama_kategori']) ?> (<?= esc($kat['satuan'] ?? 'Ekor') ?>)
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="input-group-addon border-0" data-bs-toggle="modal" data-bs-target="#modalTambahKategori" title="Tambah Kategori Baru" style="cursor:pointer;">+</button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Harga Beli (Rp) <span class="text-danger">*</span></label>
                            <input type="text" inputmode="numeric" class="form-control modal-input rupiah-input" name="harga_beli" value="<?= number_format((int) $fish['harga_beli'], 0, '.', '.') ?>" required maxlength="11" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <input type="text" inputmode="numeric" class="form-control modal-input rupiah-input" name="harga_jual" value="<?= number_format((int) $fish['harga_jual'], 0, '.', '.') ?>" required maxlength="11" autocomplete="off">
                        </div>
                        <div class="col-md-4">
                            <label class="modal-label">Jumlah Stok</label>
                            <input type="number" class="form-control modal-input bg-light text-muted" name="stok" value="<?= (int) $fish['stok'] ?>" readonly title="Jumlah stok disesuaikan melalui Kasir / Restock (IN/OUT)">
                        </div>
                        <div class="col-md-12">
                            <label class="modal-label">Deskripsi Item</label>
                            <textarea class="form-control modal-input" name="deskripsi" rows="2" maxlength="255"><?= esc($fish['deskripsi'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer-modern">
                    <button type="button" class="modal-btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="modal-btn-primary"><i class="pe-7s-check"></i><span>Simpan</span></button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>
<script>
document.addEventListener("change", function (e) {
    const inp = e.target.closest('input[type="file"][name="foto"]');
    if (!inp || !inp.files || !inp.files[0]) return;
    const file = inp.files[0];
    if (!file.type.startsWith('image/') || file.size > 2 * 1024 * 1024) {
        if (typeof showToast === 'function') showToast('danger', 'Gagal', 'Foto harus gambar maks 2MB.');
        inp.value = '';
        return;
    }
    const previewId = inp.id === 'fotoInputTambah' ? 'fotoPreviewTambah' : inp.getAttribute('data-preview');
    const img = previewId ? document.getElementById(previewId) : null;
    if (img) img.src = URL.createObjectURL(file);
});
</script>
<?= $this->endSection() ?>
