<?php
/**
 * Global Modals Aggregate View
 * Neptunus Aquatic
 */
$modAkunModel = new \App\Models\AkunModel();
$modUser = $modAkunModel->find(1);
$modFoto = $modUser['foto'] ?? '1.jpg';
$modFotoUrl = base_url('assets/images/avatars/' . $modFoto);
if (!empty($modFoto) && file_exists(FCPATH . 'uploads/profile/' . $modFoto)) {
    $modFotoUrl = base_url('uploads/profile/' . $modFoto);
}

$modPengaturanModel = new \App\Models\PengaturanModel();
$modNamaToko = $modPengaturanModel->getSetting('nama_toko', 'Neptunus Aquatic');
$modSubTitle = $modPengaturanModel->getSetting('sub_title', 'Manager Operasional');
$modStokKritis = $modPengaturanModel->getSetting('stok_kritis', '5');
?>

<!-- Global Toast Notification Container -->
<?php include __DIR__ . '/modals/toast_container.php'; ?>

<!-- Modal Edit Profil Administrator -->
<?php include __DIR__ . '/modals/modal_profil.php'; ?>

<!-- Modal Pengaturan Aplikasi -->
<?php include __DIR__ . '/modals/modal_pengaturan.php'; ?>

<!-- Modal Backup & Ekspor Data -->
<?php include __DIR__ . '/modals/modal_backup.php'; ?>

<!-- Modal Agenda & Catatan Kalender -->
<?php include __DIR__ . '/modals/modal_kalender.php'; ?>

<!-- Modal Peringatan Stok Kritis -->
<?php include __DIR__ . '/modals/modal_notifikasi_stok.php'; ?>

<!-- Modal Kasir Cepat (POS Modern) -->
<?php include __DIR__ . '/modals/modal_kasir.php'; ?>

<!-- Modal Konfirmasi Hapus Global -->
<?php include __DIR__ . '/modals/modal_konfirmasi_hapus.php'; ?>
