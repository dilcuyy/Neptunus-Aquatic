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
</style>
<div class="row">
    <div class="col-md-12">
        <div class="main-card mb-3 card">
            <div class="card-header">
                Daftar Inventaris Stok Ikan Hias
                <div class="btn-actions-pane-right">
                    <button class="btn btn-success btn-sm btn-shadow" data-bs-toggle="modal" data-bs-target="#modalTambah">
                        Tambah Data Ikan
                    </button>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-striped table-bordered align-middle mb-0">
                        <thead class="table-light fs-7">
                            <tr>
                                <th class="text-center text-nowrap" style="width: 60px;">ID</th>
                                <th style="min-width: 200px;">Nama Ikan</th>
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
                                <td colspan="8" class="text-center text-muted py-4">Tidak ada data ikan ditemukan.</td>
                            </tr>
                            <?php else: ?>
                            <?php foreach ($fish_list as $fish): ?>
                            <tr id="row-stok-<?= $fish['id_ikan'] ?>">
                                <td class="text-center text-nowrap fw-semibold text-secondary">#<?= $fish['id_ikan'] ?></td>
                                <td>
                                    <div class="fw-bold"><?= esc($fish['nama_ikan']) ?></div>
                                    <small class="text-muted"><?= esc($fish['deskripsi'] ?? '-') ?></small>
                                </td>
                                <td class="text-center text-nowrap"><span class="badge bg-info"><?= esc($fish['nama_kategori'] ?? 'Umum') ?></span></td>
                                <td class="text-end text-nowrap">Rp <?= number_format($fish['harga_beli'], 0, ',', '.') ?></td>
                                <td class="text-end text-nowrap fw-bold text-success">Rp <?= number_format($fish['harga_jual'], 0, ',', '.') ?></td>
                                <td class="text-end text-nowrap fw-bold text-primary"><?= number_format($fish['stok']) ?> Ekor</td>
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
                <span>Total Jenis Ikan: <strong><?= count($fish_list) ?></strong> jenis</span>
                <small class="text-muted">Neptunus Aquatic System</small>
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
                    "Konfirmasi Hapus Data Ikan",
                    `Apakah Anda yakin ingin menghapus data ikan <strong>${nama}</strong>?`,
                    function () {
                        window.location.href = "<?= base_url('stok-ikan/hapus') ?>/" + id;
                    }
                );
            } else {
                const judulEl = document.getElementById("konfirmasiJudul");
                const textEl = document.getElementById("konfirmasiText");
                if (judulEl) judulEl.textContent = "Konfirmasi Hapus Data Ikan";
                if (textEl) textEl.innerHTML = `Apakah Anda yakin ingin menghapus data ikan <strong>${nama}</strong>?`;
                
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
    <div class="modal-dialog modal-sm">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header">
                <h5 class="modal-title font-weight-bold" id="modalTambahKategoriLabel">Tambah Kategori Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('stok-ikan/simpan-kategori') ?>" method="post">
                <div class="modal-body">
                    <div class="mb-2">
                        <label class="form-label fw-bold fs-7">Nama Kategori <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-sm fs-7" name="nama_kategori" placeholder="Contoh: Guppy / Cichlid" required autocomplete="off">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary btn-sm">Simpan Kategori</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Tambah Ikan -->
<div class="modal fade" id="modalTambah" tabindex="-1" aria-labelledby="modalTambahLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title text-white" id="modalTambahLabel">Tambah Data Ikan Hias Baru</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('stok-ikan/simpan') ?>" method="post">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Ikan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_ikan" placeholder="Contoh: Ikan Discus Red Turquoise" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kategori Ikan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-select" name="id_kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($kategori_list as $kat): ?>
                                    <option value="<?= $kat['id_kategori'] ?>"><?= esc($kat['nama_kategori']) ?></option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-kategori-plus" data-bs-toggle="modal" data-bs-target="#modalTambahKategori" title="Tambah Kategori Baru">
                                    +
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Harga Beli (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="harga_beli" placeholder="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="harga_jual" placeholder="0" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Jumlah Stok Initial <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="stok" placeholder="0" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Deskripsi Ikan</label>
                            <textarea class="form-control" name="deskripsi" rows="3" placeholder="Keterangan singkat mengenai sifat, ukuran, atau perawatan ikan..."></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success">Simpan Ikan Baru</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modals Edit Ikan -->
<?php if (!empty($fish_list)): ?>
<?php foreach ($fish_list as $fish): ?>
<div class="modal fade" id="modalEdit<?= $fish['id_ikan'] ?>" tabindex="-1" aria-labelledby="modalEditLabel<?= $fish['id_ikan'] ?>" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="modalEditLabel<?= $fish['id_ikan'] ?>">Edit Data Ikan: <?= esc($fish['nama_ikan']) ?></h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="<?= base_url('stok-ikan/update/' . $fish['id_ikan']) ?>" method="post">
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Nama Ikan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" name="nama_ikan" value="<?= esc($fish['nama_ikan']) ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label fw-bold">Kategori Ikan <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <select class="form-select" name="id_kategori" required>
                                    <?php foreach ($kategori_list as $kat): ?>
                                    <option value="<?= $kat['id_kategori'] ?>" <?= ($kat['id_kategori'] == $fish['id_kategori']) ? 'selected' : '' ?>>
                                        <?= esc($kat['nama_kategori']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                                <button type="button" class="btn btn-kategori-plus" data-bs-toggle="modal" data-bs-target="#modalTambahKategori" title="Tambah Kategori Baru">
                                    +
                                </button>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Harga Beli (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="harga_beli" value="<?= (int) $fish['harga_beli'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Harga Jual (Rp) <span class="text-danger">*</span></label>
                            <input type="number" class="form-control" name="harga_jual" value="<?= (int) $fish['harga_jual'] ?>" required>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label fw-bold">Jumlah Stok <span class="text-danger">*</span></label>
                            <input type="number" class="form-control bg-light text-muted" name="stok" value="<?= (int) $fish['stok'] ?>" readonly title="Jumlah stok disesuaikan melalui Kasir / Restock (IN/OUT)">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label fw-bold">Deskripsi Ikan</label>
                            <textarea class="form-control" name="deskripsi" rows="3"><?= esc($fish['deskripsi'] ?? '') ?></textarea>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>
<?= $this->endSection() ?>
