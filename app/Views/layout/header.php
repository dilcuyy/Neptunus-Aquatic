<?php
$akunModel = new \App\Models\AkunModel();
$userProfile = $akunModel->find(1);

$pengaturanModel = new \App\Models\PengaturanModel();
$namaToko = $pengaturanModel->getSetting('nama_toko', 'Neptunus Aquatic');
$subTitle = $pengaturanModel->getSetting('sub_title', 'Manager Operasional');

$userNama = $userProfile['nama_lengkap'] ?? 'Admin Toko Ikan';
$userFoto = $userProfile['foto'] ?? '1.jpg';

$userFotoUrl = base_url('assets/images/avatars/' . $userFoto);
if (!empty($userFoto) && file_exists(FCPATH . 'uploads/profile/' . $userFoto)) {
    $userFotoUrl = base_url('uploads/profile/' . $userFoto);
}
?>
<div class="app-header header-shadow">
    <div class="app-header__logo">
        <a href="<?= base_url('/') ?>" class="header-brand-wrap">
            <span class="header-brand-icon">
                <i class="pe-7s-drop"></i>
            </span>
            <span class="header-brand-text"><?= esc($namaToko) ?></span>
        </a>
    </div>
    <div class="app-header__mobile-menu">
        <div>
            <button type="button" class="hamburger hamburger--elastic mobile-toggle-nav">
                <span class="hamburger-box">
                    <span class="hamburger-inner"></span>
                </span>
            </button>
        </div>
    </div>
    <div class="app-header__menu">
        <span>
            <button type="button" class="btn-icon btn-icon-only btn btn-outline-secondary btn-sm mobile-toggle-header-nav">
                <span class="btn-icon-wrapper">
                    <i class="fa fa-ellipsis-v"></i>
                </span>
            </button>
        </span>
    </div>    
    <div class="app-header__content">
        <div class="app-header-left">
            <div class="search-wrapper header-search-box position-relative">
                <i class="fa fa-search search-prefix-icon"></i>
                <input type="text" id="headerSearchInput" class="form-control" placeholder="Cari ikan/laporan..." autocomplete="off">
                <button class="btn-close d-none"></button>
                
                <!-- Live Search Dropdown Box -->
                <div id="headerSearchResultDropdown" class="search-results-dropdown shadow-sm rounded border bg-white d-none position-absolute" style="top: 100%; left: 0; min-width: 320px; max-width: 440px; z-index: 1080; margin-top: 6px;">
                </div>
            </div>
            <ul class="header-quick-nav">
                <li class="nav-item">
                    <a href="<?= base_url('/') ?>" class="nav-link">
                        <i class="pe-7s-rocket"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="<?= base_url('stok-ikan') ?>" class="nav-link">
                        <i class="pe-7s-box2"></i>
                        <span>Stok Ikan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link" id="btnTriggerKasir" data-bs-toggle="modal" data-bs-target="#modalKasir" data-toggle="modal" data-target="#modalKasir">
                        <i class="pe-7s-shopbag"></i>
                        <span>Kasir</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="app-header-right">
            <div class="header-btn-lg pe-0">
                <div class="widget-content p-0">
                    <div class="widget-content-wrapper align-items-center">
                        <div class="d-flex align-items-center gap-2 me-3">
                            <!-- Calendar Agenda Button -->
                            <button type="button" class="header-action-btn" id="btnTriggerKalender" data-bs-toggle="modal" data-bs-target="#modalKalenderNote" data-toggle="modal" data-target="#modalKalenderNote" title="Agenda & Catatan">
                                <i class="pe-7s-date" style="font-size: 1.15rem;"></i>
                            </button>

                            <!-- Low Stock Notification Dropdown -->
                            <div class="dropdown d-inline-block position-relative">
                                <button type="button" class="header-action-btn position-relative" id="btnTriggerNotifikasiStok" data-bs-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" title="Notifikasi Stok">
                                    <i class="pe-7s-bell" style="font-size: 1.15rem;"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger border border-light p-1 d-none" id="headerNotifBadgeCount" style="font-size: 9px; min-width: 16px; line-height: 1;">0</span>
                                </button>
                                
                                <div class="dropdown-menu dropdown-menu-end dropdown-menu-right notif-dropdown-menu" aria-labelledby="btnTriggerNotifikasiStok">
                                    <!-- Header -->
                                    <div class="notif-dropdown-header d-flex align-items-center justify-content-between">
                                        <div class="d-flex align-items-center gap-2">
                                            <span class="notif-icon-bubble">
                                                <i class="pe-7s-bell"></i>
                                            </span>
                                            <div>
                                                <div class="fw-semibold text-dark" style="font-size: 0.8125rem; line-height: 1.2;">Stok Menipis & Kritis</div>
                                                <div class="text-muted" style="font-size: 0.6875rem;">Perlu penambahan stok</div>
                                            </div>
                                        </div>
                                        <span class="notif-badge-pill d-none" id="notifDropdownHeaderBadge">0 Item</span>
                                    </div>

                                    <!-- Content Body -->
                                    <div id="notifDropdownList" class="p-2 overflow-auto" style="max-height: 280px;">
                                        <div class="text-center py-4 text-muted" style="font-size: 0.75rem;">
                                            <div class="spinner-border spinner-border-sm text-secondary me-1" role="status"></div> Memeriksa persediaan...
                                        </div>
                                    </div>

                                    <!-- Footer -->
                                    <div class="notif-dropdown-footer d-flex align-items-center justify-content-between">
                                        <span class="text-muted" style="font-size: 0.6875rem;" id="notifDropdownFooterCount">0 item stok kritis</span>
                                        <a href="<?= base_url('stok-ikan') ?>" class="text-primary text-decoration-none fw-semibold" style="font-size: 0.6875rem;">Lihat Stok &rarr;</a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="widget-content-left">
                            <div class="dropdown">
                                <a data-bs-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="header-user-btn" role="button">
                                    <img class="header-user-avatar" src="<?= $userFotoUrl ?>" alt="Admin Avatar">
                                    <div class="d-none d-md-block text-start">
                                        <div class="header-user-name"><?= esc($userNama) ?></div>
                                        <div class="header-user-role"><?= esc($subTitle) ?></div>
                                    </div>
                                    <i class="fa fa-angle-down text-muted ms-1" style="font-size: 0.75rem;"></i>
                                </a>
                                <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu dropdown-menu-right header-user-menu">
                                    <div class="header-user-menu-header d-flex align-items-center gap-2 px-3 py-2 border-bottom">
                                        <div class="user-menu-avatar-wrap">
                                            <img class="user-menu-avatar" src="<?= $userFotoUrl ?>" alt="Avatar">
                                        </div>
                                        <div class="user-menu-meta text-truncate">
                                            <div class="fw-bold text-dark text-truncate" style="font-size: 0.8125rem;"><?= esc($userNama) ?></div>
                                            <div class="text-muted text-truncate" style="font-size: 0.6875rem;"><?= esc($subTitle) ?></div>
                                        </div>
                                    </div>
                                    <div class="p-1">
                                        <button type="button" tabindex="0" class="dropdown-item user-menu-item" id="btnTriggerProfil" data-bs-toggle="modal" data-bs-target="#modalProfil" data-toggle="modal" data-target="#modalProfil">
                                            <span class="user-menu-item-icon"><i class="pe-7s-user"></i></span>
                                            <span>Akun Administrator</span>
                                        </button>
                                        <button type="button" tabindex="0" class="dropdown-item user-menu-item" id="btnTriggerPengaturan" data-bs-toggle="modal" data-bs-target="#modalPengaturan" data-toggle="modal" data-target="#modalPengaturan">
                                            <span class="user-menu-item-icon"><i class="pe-7s-config"></i></span>
                                            <span>Pengaturan</span>
                                        </button>
                                        <button type="button" tabindex="0" class="dropdown-item user-menu-item" id="btnTriggerBackup" data-bs-toggle="modal" data-bs-target="#modalBackup" data-toggle="modal" data-target="#modalBackup">
                                            <span class="user-menu-item-icon"><i class="pe-7s-cloud-download"></i></span>
                                            <span>Backup Data</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.notif-dropdown-menu {
    width: 360px;
    max-width: 92vw;
    margin-top: 10px !important;
    border-radius: 12px !important;
    border: 1px solid rgba(0, 0, 0, 0.08) !important;
    box-shadow: 0 0.5rem 1.5rem rgba(0, 0, 0, 0.15) !important;
    padding: 0;
    overflow: visible !important;
}
.notif-dropdown-menu::before {
    content: '';
    position: absolute;
    top: -7px;
    right: 11px;
    width: 0;
    height: 0;
    border-left: 7px solid transparent;
    border-right: 7px solid transparent;
    border-bottom: 7px solid #ffffff;
    filter: drop-shadow(0 -1px 1px rgba(0,0,0,0.08));
    z-index: 10;
}
.header-user-toggle,
.header-user-toggle:focus,
.header-user-toggle:focus-visible,
.header-user-toggle:active,
.header-user-toggle.show,
.header-user-toggle[aria-expanded="true"] {
    outline: none !important;
    border: none !important;
    box-shadow: none !important;
    text-decoration: none !important;
}
.search-results-dropdown {
    max-height: 480px;
    overflow-y: auto;
}
.search-result-item {
    transition: background-color 0.15s ease-in-out;
}
.search-result-item:hover {
    background-color: #f0f3ff !important;
    text-decoration: none;
}
.table-row-highlight {
    animation: rowHighlightPulse 3s ease-in-out;
}
@keyframes rowHighlightPulse {
    0% { background-color: #fff3cd !important; box-shadow: inset 0 0 0 2px #ffc107; }
    50% { background-color: #ffe69c !important; box-shadow: inset 0 0 0 2px #ffc107; }
    100% { background-color: transparent; box-shadow: none; }
}
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("headerSearchInput");
    const dropdown = document.getElementById("headerSearchResultDropdown");
    const closeBtn = document.querySelector(".search-wrapper .btn-close");
    let searchDebounceTimer = null;

    if (!searchInput || !dropdown) return;

    if (closeBtn) {
        closeBtn.addEventListener("click", function () {
            searchInput.value = "";
            dropdown.classList.add("d-none");
            dropdown.innerHTML = "";
        });
    }

    searchInput.addEventListener("input", function () {
        const query = this.value.trim();
        clearTimeout(searchDebounceTimer);

        if (query.length < 3) {
            dropdown.classList.add("d-none");
            dropdown.innerHTML = "";
            return;
        }

        dropdown.innerHTML = `
            <div class="p-3 text-center text-muted fs-7">
                <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                Mencari "${query}"...
            </div>
        `;
        dropdown.classList.remove("d-none");

        searchDebounceTimer = setTimeout(function () {
            fetch("<?= base_url('api/search') ?>?q=" + encodeURIComponent(query))
                .then(response => response.json())
                .then(data => {
                    renderSearchResults(data);
                })
                .catch(err => {
                    console.error("Search error:", err);
                    dropdown.innerHTML = `
                        <div class="p-3 text-center text-danger fs-7">
                            <i class="fa fa-exclamation-triangle me-1"></i> Gagal memuat rekomendasi pencarian.
                        </div>
                    `;
                });
        }, 300);
    });

    function renderSearchResults(data) {
        const stokItems = data.stok || [];
        const laporanItems = data.laporan || [];

        if (stokItems.length === 0 && laporanItems.length === 0) {
            dropdown.innerHTML = `
                <div class="p-3 text-center text-muted fs-7">
                    Tidak ada rekomendasi ditemukan untuk "${data.query}".
                </div>
            `;
            return;
        }

        let html = '';

        // Section 1: Data Stok Ikan (Top 3)
        html += `
            <div class="bg-light px-3 py-2 fw-bold text-uppercase fs-7 text-primary border-bottom d-flex justify-content-between align-items-center">
                <span>Rekomendasi Stok Ikan (${stokItems.length} Item)</span>
            </div>
        `;

        if (stokItems.length > 0) {
            stokItems.forEach(item => {
                html += `
                    <a href="${item.url}" class="search-result-item d-block px-3 py-2 text-dark text-decoration-none border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fw-bold text-truncate me-2" style="max-width: 240px;">
                                ${item.nama_ikan}
                            </div>
                            <span class="text-secondary fs-8 fw-bold text-uppercase">${item.nama_kategori}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1 fs-8 text-muted">
                            <span>Harga: <strong class="text-success">${item.harga_formatted}</strong></span>
                            <span>Stok: <strong class="text-primary">${item.stok} Ekor</strong></span>
                        </div>
                    </a>
                `;
            });
        } else {
            html += `
                <div class="px-3 py-2 text-muted fs-8 fst-italic border-bottom">
                    Tidak ada data stok ikan yang cocok.
                </div>
            `;
        }

        // Section 2: Data Laporan (Top 3)
        html += `
            <div class="bg-light px-3 py-2 fw-bold text-uppercase fs-7 text-success border-bottom border-top d-flex justify-content-between align-items-center">
                <span>Rekomendasi Laporan Mutasi (${laporanItems.length} Item)</span>
            </div>
        `;

        if (laporanItems.length > 0) {
            laporanItems.forEach(item => {
                const textClass = item.jenis === 'Masuk' ? 'text-success' : 'text-danger';
                html += `
                    <a href="${item.url}" class="search-result-item d-block px-3 py-2 text-dark text-decoration-none border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="fw-bold text-truncate me-2" style="max-width: 240px;">
                                ${item.nama_ikan}
                            </div>
                            <span class="${textClass} fs-8 fw-bold text-uppercase">${item.jenis}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mt-1 fs-8 text-muted">
                            <span>Tgl: ${item.tanggal}</span>
                            <span>Jumlah: <strong class="text-dark">${item.jumlah} Ekor</strong></span>
                        </div>
                    </a>
                `;
            });
        } else {
            html += `
                <div class="px-3 py-2 text-muted fs-8 fst-italic">
                    Tidak ada data laporan yang cocok.
                </div>
            `;
        }

        dropdown.innerHTML = html;
    }

    document.addEventListener("click", function (e) {
        if (!searchInput.contains(e.target) && !dropdown.contains(e.target)) {
            dropdown.classList.add("d-none");
        }
    });

    searchInput.addEventListener("keydown", function (e) {
        if (e.key === "Escape") {
            dropdown.classList.add("d-none");
        }
    });
});
</script>
