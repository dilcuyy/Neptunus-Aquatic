<?php $activeMenu = $activeMenu ?? 'dashboard'; ?>
<div class="app-sidebar">
    <button type="button" class="btn-sidebar-edge-toggle" title="Toggle Sidebar" aria-label="Toggle Sidebar">
        <i class="fa fa-chevron-left toggle-icon"></i>
    </button>
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
    <div class="scrollbar-sidebar">
        <div class="app-sidebar__inner">
            <ul class="vertical-nav-menu">
                <li class="app-sidebar__heading">Menu Utama</li>
                <li>
                    <a href="<?= base_url('/') ?>" class="<?= ($activeMenu == 'dashboard') ? 'mm-active' : '' ?>">
                        <i class="metismenu-icon pe-7s-rocket"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('stok-ikan') ?>" class="<?= ($activeMenu == 'stok_ikan') ? 'mm-active' : '' ?>">
                        <i class="metismenu-icon pe-7s-box2"></i>
                        <span>Data Stok</span>
                    </a>
                </li>
                <li class="app-sidebar__heading mt-2">Laporan & Rekap</li>
                <li>
                    <a href="<?= base_url('laporan-in-out') ?>" class="<?= ($activeMenu == 'laporan_in_out') ? 'mm-active' : '' ?>">
                        <i class="metismenu-icon pe-7s-repeat"></i>
                        <span>Laporan In/Out</span>
                    </a>
                </li>
                <li>
                    <a href="<?= base_url('cetak-laporan') ?>" class="<?= ($activeMenu == 'cetak_laporan') ? 'mm-active' : '' ?>">
                        <i class="metismenu-icon pe-7s-print"></i>
                        <span>Cetak Laporan</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
