-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 08 Okt 2026 pada 05.59
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_ikan_hias`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `akun`
--

CREATE TABLE `akun` (
  `id_akun` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `nama_lengkap` varchar(100) NOT NULL,
  `role` enum('admin','kasir','operator') NOT NULL DEFAULT 'admin',
  `nomor_hp` varchar(20) DEFAULT NULL,
  `foto` varchar(255) DEFAULT '1.jpg'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `akun`
--

INSERT INTO `akun` (`id_akun`, `username`, `password`, `nama_lengkap`, `role`, `nomor_hp`, `foto`) VALUES
(1, 'admin', '21232f297a57a5a743894a0e4a801fc3', 'Admin Toko Ikan', 'admin', '08123', '1790148162_9db8788e8464c5a98cf2.jpg'),
(2, 'kasir', 'c77397a06a377a1971072c6eeeeab010', 'Kasir Neptunus', 'kasir', '089876543210', '1.jpg');

-- --------------------------------------------------------

--
-- Struktur dari tabel `barang`
--

CREATE TABLE `barang` (
  `id_barang` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_barang` varchar(100) NOT NULL,
  `satuan` varchar(20) NOT NULL DEFAULT 'Pcs',
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `barang`
--

INSERT INTO `barang` (`id_barang`, `id_kategori`, `nama_barang`, `satuan`, `deskripsi`, `foto`) VALUES
(1, 5, 'Pakan Pelet 1kg', 'Pcs', 'Pakan harian', NULL),
(2, 5, 'Filter Aquarium', 'Pcs', 'Filter gantung', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `catatan_kalender`
--

CREATE TABLE `catatan_kalender` (
  `id_catatan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `catatan` text NOT NULL,
  `updated_at` datetime DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `catatan_kalender`
--

INSERT INTO `catatan_kalender` (`id_catatan`, `tanggal`, `catatan`, `updated_at`) VALUES
(8, '2026-10-08', 'sdssfdf', '2026-10-07 15:41:15'),
(9, '2026-10-09', 'sdfsdfs', '2026-10-07 15:41:24'),
(10, '2026-10-06', 'zxcxcxc', '2026-10-07 15:41:28'),
(11, '2026-10-07', 'ssdfsdfs', '2026-10-07 15:44:45');

-- --------------------------------------------------------

--
-- Struktur dari tabel `ikan`
--

CREATE TABLE `ikan` (
  `id_ikan` int(11) NOT NULL,
  `id_kategori` int(11) DEFAULT NULL,
  `nama_ikan` varchar(100) NOT NULL,
  `harga_beli` decimal(12,2) NOT NULL DEFAULT 0.00,
  `harga_jual` decimal(12,2) NOT NULL DEFAULT 0.00,
  `stok` int(11) NOT NULL DEFAULT 0,
  `deskripsi` text DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `ikan`
--

INSERT INTO `ikan` (`id_ikan`, `id_kategori`, `nama_ikan`, `harga_beli`, `harga_jual`, `stok`, `deskripsi`, `foto`, `gambar`) VALUES
(1, 1, 'Danio Tetra', 5000.00, 7000.00, 63, 'Ikan kecil perenang cepat yang aktif bergerombol.', 'danio_tetra.jpg', NULL),
(2, 1, 'Sepat Biru', 8000.00, 12000.00, 68, 'Ikan sepat hias berwarna biru berkilau.', 'sepat_biru.jpg', NULL),
(3, 1, 'Sepat Madu', 9000.00, 13000.00, 42, 'Ikan sepat hias berukuran kecil dengan warna kemerahan seperti madu.', 'sepat_madu.jpg', NULL),
(4, 4, 'Barber', 6000.00, 10000.00, 20, 'Ikan pembersih kaca dan dasar akuarium.', 'barber.jpg', NULL),
(5, 3, 'Blue Pollar', 30000.00, 45000.00, 84, 'Ikan Cichlid kerdil bermotif zebra biru mempesona.', 'blue_pollar.jpg', NULL),
(6, 1, 'Rainbow Blue', 3500.00, 5000.00, 92, 'Ikan rainbow mini dengan pantulan warna biru berkilau.', 'rainbow_blue.jpg', NULL),
(7, 5, 'Niasa', 7000.00, 10000.00, 234, 'Ikan niasa kuning dengan garis hitam khas Cichlid danau Malawi.', 'niasa.jpg', NULL),
(8, 2, 'Cupang', 15000.00, 24500.00, 52, 'Ikan cupang hias ekor lebar warna-warni.', 'cupang.jpg', NULL),
(9, 1, 'xxxx', 3000.00, 8.00, 11, '', 'default.jpg', NULL),
(10, 1, 'Ikan Guppy Cobra', 2000.00, 5000.00, 101, 'Guppy hias ekor lebar', 'guppy.jpg', NULL),
(11, 5, 'test', 3000.00, 4000.00, 3, '', 'default.jpg', NULL);

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_ikan`
--

CREATE TABLE `kategori_ikan` (
  `id_kategori` int(11) NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `sifat` varchar(100) DEFAULT NULL,
  `tingkat_perawatan` varchar(50) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `kategori_ikan`
--

INSERT INTO `kategori_ikan` (`id_kategori`, `nama_kategori`, `sifat`, `tingkat_perawatan`) VALUES
(1, 'Tetra & Schooling Fish', 'Damai (Bergerombol)', 'Mudah'),
(2, 'Cupang / Betta', 'Agresif (Soliter)', 'Sangat Mudah'),
(3, 'Cichlid', 'Agresif Teritorial', 'Sedang'),
(4, 'Catfish & Bottom Feeder', 'Damai', 'Mudah'),
(5, 'Ikan Hias Air Tawar Lainnya', 'Variatif', 'Sedang');

-- --------------------------------------------------------

--
-- Struktur dari tabel `pengaturan`
--

CREATE TABLE `pengaturan` (
  `id` int(11) NOT NULL,
  `key_name` varchar(100) NOT NULL,
  `val_value` text DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `pengaturan`
--

INSERT INTO `pengaturan` (`id`, `key_name`, `val_value`) VALUES
(1, 'nama_toko', 'Neptunus Aquatic'),
(2, 'sub_title', 'Manager Operasional'),
(3, 'stok_kritis', '5');

-- --------------------------------------------------------

--
-- Struktur dari tabel `riwayat_stok`
--

CREATE TABLE `riwayat_stok` (
  `id_riwayat` int(11) NOT NULL,
  `id_ikan` int(11) DEFAULT NULL,
  `id_barang` int(11) DEFAULT NULL,
  `id_akun` int(11) DEFAULT NULL,
  `jenis` enum('Masuk','Keluar') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `harga_satuan` decimal(12,2) DEFAULT NULL,
  `keterangan` text DEFAULT NULL,
  `tanggal` datetime NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `riwayat_stok`
--

INSERT INTO `riwayat_stok` (`id_riwayat`, `id_ikan`, `id_barang`, `id_akun`, `jenis`, `jumlah`, `harga_satuan`, `keterangan`, `tanggal`) VALUES
(1, 7, NULL, 1, 'Keluar', 5, 10000.00, 'Penjualan Toko', '2026-09-16 08:40:16'),
(2, 8, NULL, 1, 'Keluar', 3, 24500.00, 'Penjualan Toko', '2026-09-16 09:10:16'),
(3, 1, NULL, 1, 'Keluar', 2, 7000.00, 'Test Kasir POS CLI Checkout', '2026-09-16 04:46:37'),
(4, 9, NULL, 1, 'Masuk', 1, 3000.00, 'Stok Awal Ikan Baru', '2026-09-16 03:35:06'),
(5, 1, NULL, 1, 'Keluar', 2, 7000.00, 'Penjualan Kasir', '2026-09-23 09:15:58'),
(6, 1, NULL, 1, 'Masuk', 2, 5000.00, 'Restock Kasir', '2026-09-23 09:15:58'),
(7, 1, NULL, 1, 'Keluar', 3, 7000.00, 'Penjualan Kasir', '2026-09-23 09:23:28'),
(8, 2, NULL, 1, 'Masuk', 2, 8000.00, 'Restock Kasir', '2026-09-23 09:23:28'),
(9, 5, NULL, 1, 'Masuk', 1, 30000.00, 'Restock Kasir', '2026-09-23 09:23:28'),
(10, 10, NULL, 1, 'Masuk', 1, 2000.00, 'Restock Kasir', '2026-09-23 09:23:28'),
(11, 9, NULL, 1, 'Masuk', 2, 3000.00, 'Restock Kasir', '2026-09-23 09:23:28'),
(12, 2, NULL, 1, 'Keluar', 3, 12000.00, 'Penjualan Kasir', '2026-09-24 01:31:03'),
(13, 7, NULL, 1, 'Keluar', 2, 10000.00, 'Penjualan Kasir', '2026-09-24 01:31:03'),
(14, 7, NULL, 1, 'Masuk', 1, 7000.00, 'Restock Kasir', '2026-09-24 01:31:03'),
(15, 8, NULL, 1, 'Masuk', 1, 15000.00, 'Restock Kasir', '2026-09-24 01:31:03'),
(16, 1, NULL, 1, 'Keluar', 1, 7000.00, 'Penjualan Kasir', '2026-09-24 01:46:48'),
(17, 2, NULL, 1, 'Keluar', 1, 12000.00, 'Penjualan Kasir', '2026-09-24 01:46:48'),
(18, 3, NULL, 1, 'Keluar', 1, 13000.00, 'Penjualan Kasir', '2026-09-24 01:46:48'),
(19, 4, NULL, 1, 'Keluar', 1, 10000.00, 'Penjualan Kasir', '2026-09-24 01:46:48'),
(20, 5, NULL, 1, 'Keluar', 1, 45000.00, 'Penjualan Kasir', '2026-09-24 01:46:48'),
(21, 8, NULL, 1, 'Keluar', 1, 24500.00, 'Penjualan Kasir', '2026-09-24 01:46:48'),
(22, 1, NULL, 1, 'Keluar', 1, 7000.00, 'Penjualan Kasir', '2026-09-24 01:48:15'),
(23, 4, NULL, 1, 'Keluar', 1, 10000.00, 'a', '2026-09-25 04:00:42'),
(24, 8, NULL, 1, 'Keluar', 1, 24500.00, 'Penjualan Kasir', '2026-09-25 04:00:42'),
(25, 4, NULL, 1, 'Keluar', 1, 10002.00, 'a', '2026-09-25 06:41:47'),
(26, 4, NULL, 1, 'Keluar', 1, 10000.00, 'Penjualan Kasir', '2026-09-25 06:42:42'),
(27, 9, NULL, 1, 'Masuk', 2, 3000.00, 'Restock Kasir', '2026-09-25 08:07:00'),
(28, 8, NULL, 1, 'Masuk', 1, 15000.00, 'Restock Kasir', '2026-09-25 08:07:00'),
(29, 9, NULL, 1, 'Masuk', 5, 3000.00, 'Restock Kasir', '2026-09-25 08:12:17'),
(30, 9, NULL, 1, 'Masuk', 1, 3000.00, 'Restock Kasir', '2026-09-25 08:12:33'),
(31, 4, NULL, 1, 'Keluar', 1, 10000.00, 'Penjualan Kasir', '2026-09-28 08:40:36'),
(32, 8, NULL, 1, 'Keluar', 2, 24500.00, 'Penjualan Kasir', '2026-09-28 08:40:36'),
(33, 11, NULL, 1, 'Keluar', 1, 4000.00, 'Penjualan Kasir', '2026-10-08 03:07:14'),
(34, NULL, 1, 1, 'Masuk', 100, 25000.00, 'Stok awal / harga beli', '2026-10-08 10:52:16'),
(35, NULL, 1, 1, 'Keluar', 2, 35000.00, 'Penjualan / harga jual', '2026-10-08 10:52:16');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `akun`
--
ALTER TABLE `akun`
  ADD PRIMARY KEY (`id_akun`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id_barang`),
  ADD KEY `fk_barang_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `catatan_kalender`
--
ALTER TABLE `catatan_kalender`
  ADD PRIMARY KEY (`id_catatan`),
  ADD UNIQUE KEY `tanggal` (`tanggal`);

--
-- Indeks untuk tabel `ikan`
--
ALTER TABLE `ikan`
  ADD PRIMARY KEY (`id_ikan`),
  ADD KEY `fk_ikan_kategori` (`id_kategori`);

--
-- Indeks untuk tabel `kategori_ikan`
--
ALTER TABLE `kategori_ikan`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `key_name` (`key_name`);

--
-- Indeks untuk tabel `riwayat_stok`
--
ALTER TABLE `riwayat_stok`
  ADD PRIMARY KEY (`id_riwayat`),
  ADD KEY `fk_riwayat_ikan` (`id_ikan`),
  ADD KEY `fk_riwayat_akun` (`id_akun`),
  ADD KEY `fk_riwayat_barang` (`id_barang`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `akun`
--
ALTER TABLE `akun`
  MODIFY `id_akun` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `barang`
--
ALTER TABLE `barang`
  MODIFY `id_barang` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `catatan_kalender`
--
ALTER TABLE `catatan_kalender`
  MODIFY `id_catatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `ikan`
--
ALTER TABLE `ikan`
  MODIFY `id_ikan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `kategori_ikan`
--
ALTER TABLE `kategori_ikan`
  MODIFY `id_kategori` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pengaturan`
--
ALTER TABLE `pengaturan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `riwayat_stok`
--
ALTER TABLE `riwayat_stok`
  MODIFY `id_riwayat` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=36;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `barang`
--
ALTER TABLE `barang`
  ADD CONSTRAINT `fk_barang_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_ikan` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `ikan`
--
ALTER TABLE `ikan`
  ADD CONSTRAINT `fk_ikan_kategori` FOREIGN KEY (`id_kategori`) REFERENCES `kategori_ikan` (`id_kategori`) ON DELETE SET NULL ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `riwayat_stok`
--
ALTER TABLE `riwayat_stok`
  ADD CONSTRAINT `fk_riwayat_akun` FOREIGN KEY (`id_akun`) REFERENCES `akun` (`id_akun`) ON DELETE SET NULL ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_riwayat_barang` FOREIGN KEY (`id_barang`) REFERENCES `barang` (`id_barang`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `fk_riwayat_ikan` FOREIGN KEY (`id_ikan`) REFERENCES `ikan` (`id_ikan`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
