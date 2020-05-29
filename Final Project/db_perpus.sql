-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Bulan Mei 2020 pada 00.46
-- Versi server: 10.4.11-MariaDB
-- Versi PHP: 7.4.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `db_perpus`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_buku`
--

CREATE TABLE `tb_buku` (
  `id_buku` varchar(50) NOT NULL,
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `id_pengarang` int(10) UNSIGNED NOT NULL,
  `id_penerbit` int(10) UNSIGNED NOT NULL,
  `id_rak` int(10) UNSIGNED NOT NULL,
  `judul_buku` varchar(50) NOT NULL,
  `gambar_buku` varchar(50) NOT NULL,
  `tahun_buku` int(10) UNSIGNED NOT NULL,
  `stok_buku` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_buku`
--

INSERT INTO `tb_buku` (`id_buku`, `id_kategori`, `id_pengarang`, `id_penerbit`, `id_rak`, `judul_buku`, `gambar_buku`, `tahun_buku`, `stok_buku`, `created_at`, `updated_at`) VALUES
('BK/2020/00001', 1, 50, 70, 3, 'Jaringan Komputer', '5ece2a1a7bea3.jpg', 2020, 24, '2020-05-27 01:23:02', '2020-05-29 17:30:38'),
('BK/2020/00002', 1, 1, 9, 3, 'Rekayasa Perangkat Lunak', '5ed18b6f33369.png', 2014, 24, '2020-05-28 19:58:56', '2020-05-30 06:23:43'),
('BK/2020/00003', 79, 2, 11, 3, 'Segala-galanya Ambyar', '5ed18b976933c.jpg', 2020, 20, '2020-05-30 06:24:23', '2020-05-30 06:24:23'),
('BK/2020/00004', 1, 4, 13, 2, 'Mengupas Rahasia Tersembunyi Ms Office', '5ed18c0ca50b2.png', 2020, 20, '2020-05-30 06:26:20', '2020-05-30 06:26:20');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_kategori`
--

CREATE TABLE `tb_kategori` (
  `id_kategori` int(10) UNSIGNED NOT NULL,
  `nama_kategori` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_kategori`
--

INSERT INTO `tb_kategori` (`id_kategori`, `nama_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Teknologi Informasi', '2020-05-25 15:08:05', '2020-05-25 16:09:38'),
(2, 'Kesehatan', '2020-05-25 15:08:05', '2020-05-25 15:08:05'),
(4, 'Lingkungan', '2020-05-25 16:31:42', '2020-05-25 16:31:42'),
(6, 'Hukum', '2020-05-25 16:34:25', '2020-05-25 16:34:25'),
(7, 'Teknik', '2020-05-25 16:36:13', '2020-05-25 16:36:13'),
(8, 'Musik', '2020-05-25 16:36:39', '2020-05-25 16:36:39'),
(14, 'Agama', '2020-05-25 16:44:46', '2020-05-25 16:44:46'),
(53, 'Sejarah', '2020-05-25 20:34:29', '2020-05-25 20:34:29'),
(79, 'Petualangan', '2020-05-25 21:02:32', '2020-05-25 21:02:32'),
(132, '', '2020-05-26 08:56:14', '2020-05-28 09:28:21');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_peminjaman`
--

CREATE TABLE `tb_peminjaman` (
  `id_peminjaman` varchar(50) NOT NULL,
  `id_user` int(10) UNSIGNED NOT NULL,
  `status` enum('0','1','2') NOT NULL DEFAULT '0',
  `due_date` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_peminjaman`
--

INSERT INTO `tb_peminjaman` (`id_peminjaman`, `id_user`, `status`, `due_date`, `created_at`, `updated_at`) VALUES
('TRK/2020/00001', 14, '1', '2020-05-29 09:29:00', '2020-05-29 09:29:56', '2020-05-29 17:30:00'),
('TRK/2020/00002', 14, '1', '2020-05-30 09:30:00', '2020-05-29 09:30:16', '2020-05-29 17:30:26');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_peminjaman_detail`
--

CREATE TABLE `tb_peminjaman_detail` (
  `id_peminjaman_detail` int(11) NOT NULL,
  `id_peminjaman` varchar(50) NOT NULL,
  `id_buku` varchar(50) NOT NULL,
  `amount` int(10) UNSIGNED NOT NULL,
  `created_at` datetime NOT NULL DEFAULT current_timestamp(),
  `updated_at` datetime NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_peminjaman_detail`
--

INSERT INTO `tb_peminjaman_detail` (`id_peminjaman_detail`, `id_peminjaman`, `id_buku`, `amount`, `created_at`, `updated_at`) VALUES
(56, 'TRK/2020/00001', 'BK/2020/00002', 1, '2020-05-29 17:29:56', '2020-05-29 17:29:56'),
(57, 'TRK/2020/00001', 'BK/2020/00001', 1, '2020-05-29 17:29:56', '2020-05-29 17:29:56'),
(58, 'TRK/2020/00002', 'BK/2020/00002', 24, '2020-05-29 17:30:16', '2020-05-29 17:30:16'),
(59, 'TRK/2020/00002', 'BK/2020/00001', 24, '2020-05-29 17:30:16', '2020-05-29 17:30:16');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_penerbit`
--

CREATE TABLE `tb_penerbit` (
  `id_penerbit` int(10) UNSIGNED NOT NULL,
  `nama_penerbit` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_penerbit`
--

INSERT INTO `tb_penerbit` (`id_penerbit`, `nama_penerbit`, `created_at`, `updated_at`) VALUES
(9, 'Penerbit Andi Publisher', '2020-05-25 17:41:26', '2020-05-25 17:41:26'),
(10, 'Penerbit Elexmedia Komputindo', '2020-05-25 17:41:33', '2020-05-25 17:41:33'),
(11, 'Penerbit Gagas Media', '2020-05-25 17:41:43', '2020-05-25 17:41:43'),
(12, 'Penerbit Gramedia Widiasarana Indonesia ', '2020-05-25 17:41:58', '2020-05-25 17:48:22'),
(13, 'Penerbit Gramedia Pustaka Utama (GPU)', '2020-05-25 17:48:48', '2020-05-25 17:48:48'),
(15, 'Penerbit Agro Media', '2020-05-25 17:49:43', '2020-05-25 17:49:43'),
(70, 'Penerbit Baru', '2020-05-25 20:34:58', '2020-05-25 20:34:58');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengarang`
--

CREATE TABLE `tb_pengarang` (
  `id_pengarang` int(10) UNSIGNED NOT NULL,
  `nama_pengarang` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_pengarang`
--

INSERT INTO `tb_pengarang` (`id_pengarang`, `nama_pengarang`, `created_at`, `updated_at`) VALUES
(1, 'Andi Publishers', '2020-05-25 18:36:31', '2020-05-25 18:07:10'),
(2, 'Ketut Pengarang', '2020-05-25 17:46:30', '2020-05-25 17:46:30'),
(3, 'Dharma Putra', '2020-05-25 18:07:33', '2020-05-25 18:07:33'),
(4, 'Bagus Pengarang', '2020-05-25 18:09:32', '2020-05-25 18:09:32'),
(50, 'Kadek Pengarang', '2020-05-25 20:27:27', '2020-05-25 20:27:27');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_pengembalian`
--

CREATE TABLE `tb_pengembalian` (
  `id_pengembalian` int(50) UNSIGNED NOT NULL,
  `id_peminjaman` varchar(50) CHARACTER SET utf8 NOT NULL,
  `tanggal_kembali` date NOT NULL,
  `ketepatan` enum('0','1') COLLATE utf8_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- Dumping data untuk tabel `tb_pengembalian`
--

INSERT INTO `tb_pengembalian` (`id_pengembalian`, `id_peminjaman`, `tanggal_kembali`, `ketepatan`, `created_at`, `updated_at`) VALUES
(60, 'TRK/2020/00001', '2020-05-29', '0', '2020-05-29 09:30:04', '2020-05-29 09:30:04'),
(61, 'TRK/2020/00002', '2020-05-29', '1', '2020-05-29 09:30:38', '2020-05-29 09:30:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_permissions`
--

CREATE TABLE `tb_permissions` (
  `id_permission` int(10) UNSIGNED NOT NULL,
  `name_permission` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_permissions`
--

INSERT INTO `tb_permissions` (`id_permission`, `name_permission`) VALUES
(1, 'create_user'),
(2, 'read_user'),
(3, 'update_user'),
(4, 'delete_user'),
(5, 'menu_data'),
(6, 'submenu_data_user'),
(7, 'create_kategori'),
(8, 'read_kategori'),
(9, 'update_kategori'),
(10, 'delete_kategori'),
(11, 'create_penerbit'),
(12, 'read_penerbit'),
(13, 'update_penerbit'),
(14, 'delete_penerbit'),
(15, 'create_pengarang'),
(16, 'read_pengarang'),
(17, 'update_pengarang'),
(18, 'delete_pengarang'),
(19, 'submenu_data_kategori'),
(20, 'submenu_data_penerbit'),
(21, 'submenu_data_pengarang'),
(22, 'create_buku'),
(23, 'read_buku'),
(24, 'update_buku'),
(25, 'delete_buku'),
(26, 'submenu_data_buku'),
(27, 'create_rak'),
(28, 'read_rak'),
(29, 'update_rak'),
(30, 'delete_rak'),
(31, 'submenu_data_rak'),
(32, 'update_profile'),
(33, 'menu_transaksi'),
(34, 'submenu_transaksi_peminjaman'),
(35, 'create_peminjaman'),
(36, 'read_peminjaman'),
(37, 'update_peminjaman'),
(38, 'delete_peminjaman'),
(39, 'cek_status'),
(40, 'submenu_transaksi_pengembalian'),
(41, 'create_pengembalian'),
(42, 'read_pengembalian'),
(43, 'update_pengembalian'),
(44, 'delete_pengembalian');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rak`
--

CREATE TABLE `tb_rak` (
  `id_rak` int(10) UNSIGNED NOT NULL,
  `nama_rak` varchar(100) NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_rak`
--

INSERT INTO `tb_rak` (`id_rak`, `nama_rak`, `created_at`, `updated_at`) VALUES
(2, 'Rak A', '2020-05-26 12:50:14', '2020-05-26 12:50:14'),
(3, 'Rak B', '2020-05-26 13:18:09', '2020-05-26 13:18:09'),
(4, 'Rak C', '2020-05-26 13:18:14', '2020-05-26 13:18:14'),
(5, 'Rak D', '2020-05-26 13:18:18', '2020-05-26 13:18:18'),
(6, 'Rak E', '2020-05-26 13:18:23', '2020-05-26 13:18:23'),
(7, 'Rak F', '2020-05-26 13:18:28', '2020-05-26 13:18:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rules`
--

CREATE TABLE `tb_rules` (
  `id_rule` int(10) UNSIGNED NOT NULL,
  `name_rule` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_rules`
--

INSERT INTO `tb_rules` (`id_rule`, `name_rule`) VALUES
(1, 'superadmin'),
(2, 'admin'),
(3, 'user');

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_rule_permission`
--

CREATE TABLE `tb_rule_permission` (
  `id_rule` int(10) UNSIGNED NOT NULL,
  `id_permission` int(10) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data untuk tabel `tb_rule_permission`
--

INSERT INTO `tb_rule_permission` (`id_rule`, `id_permission`) VALUES
(1, 1),
(1, 2),
(1, 3),
(1, 4),
(1, 5),
(1, 6),
(2, 7),
(2, 8),
(2, 9),
(2, 10),
(2, 11),
(2, 12),
(2, 13),
(2, 14),
(2, 15),
(2, 16),
(2, 17),
(2, 18),
(2, 5),
(2, 19),
(2, 20),
(2, 21),
(2, 22),
(2, 23),
(2, 24),
(2, 25),
(2, 26),
(2, 27),
(2, 28),
(2, 29),
(2, 30),
(2, 31),
(3, 32),
(2, 33),
(2, 34),
(2, 35),
(2, 36),
(2, 37),
(2, 38),
(3, 33),
(3, 34),
(3, 35),
(3, 36),
(3, 37),
(3, 39),
(3, 23),
(3, 26),
(3, 5),
(2, 40),
(2, 41),
(2, 42),
(2, 43),
(2, 44),
(1, 26);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tb_users`
--

CREATE TABLE `tb_users` (
  `id_user` int(10) UNSIGNED NOT NULL,
  `id_rule` int(10) UNSIGNED NOT NULL,
  `name` varchar(35) COLLATE utf8_bin NOT NULL,
  `username` varchar(20) COLLATE utf8_bin NOT NULL,
  `password` text COLLATE utf8_bin NOT NULL,
  `status` enum('0','1') COLLATE utf8_bin NOT NULL DEFAULT '0',
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_bin;

--
-- Dumping data untuk tabel `tb_users`
--

INSERT INTO `tb_users` (`id_user`, `id_rule`, `name`, `username`, `password`, `status`, `created_at`, `updated_at`) VALUES
(4, 1, 'Putu Bagus', 'superadmin', 'ac497cfaba23c4184cb03b97e8c51e0a', '1', '2020-05-24 10:23:06', '2020-05-24 12:09:03'),
(8, 3, 'Suwandi', 'suwandine', 'f5bb0c8de146c67b44babbf4e6584cc0', '1', '0000-00-00 00:00:00', '2020-05-24 12:09:34'),
(9, 3, 'Dharma Putra', 'dharmatkj', '25d55ad283aa400af464c76d713c07ad', '1', '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(12, 1, 'Penggunaa', 'pengguna', 'f5bb0c8de146c67b44babbf4e6584cc0', '1', '2020-05-24 10:08:55', '2020-05-24 12:10:34'),
(13, 1, 'Dharma Putra', 'dharmaputra', 'f5bb0c8de146c67b44babbf4e6584cc0', '1', '2020-05-24 12:16:44', '2020-05-24 12:16:44'),
(14, 2, 'Admin User', 'admin1234', 'f5bb0c8de146c67b44babbf4e6584cc0', '1', '2020-05-25 11:53:40', '2020-05-25 16:01:19'),
(17, 1, 'made user', 'madeuser', 'c6a4a198cbdeb7f168f6e8773b667e48', '1', '2020-05-26 12:25:24', '2020-05-26 12:25:24'),
(18, 3, 'Dharma Putra', 'bagusdharma', '9f2d05cd35d79641be54b3046e2e759c', '1', '2020-05-27 08:27:50', '2020-05-27 08:27:50'),
(19, 3, 'userbiasa', 'userbiasa', '5ce18dd788da69615cf285d404daa225', '1', '2020-05-27 13:06:36', '2020-05-27 13:06:36'),
(21, 3, 'dharmauser', 'dharmauser', 'b8b15a84106d2478b5ba7b6e28bda25c', '1', '2020-05-29 04:59:42', '2020-05-29 04:59:42');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tb_buku`
--
ALTER TABLE `tb_buku`
  ADD PRIMARY KEY (`id_buku`),
  ADD KEY `id_kategori` (`id_kategori`,`id_pengarang`,`id_penerbit`,`id_rak`),
  ADD KEY `tb_buku_ibfk_2` (`id_penerbit`),
  ADD KEY `tb_buku_ibfk_3` (`id_pengarang`),
  ADD KEY `tb_buku_ibfk_4` (`id_rak`);

--
-- Indeks untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  ADD PRIMARY KEY (`id_kategori`);

--
-- Indeks untuk tabel `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  ADD PRIMARY KEY (`id_peminjaman`),
  ADD KEY `id_user` (`id_user`);

--
-- Indeks untuk tabel `tb_peminjaman_detail`
--
ALTER TABLE `tb_peminjaman_detail`
  ADD PRIMARY KEY (`id_peminjaman_detail`),
  ADD KEY `id_peminjaman` (`id_peminjaman`),
  ADD KEY `id_buku` (`id_buku`);

--
-- Indeks untuk tabel `tb_penerbit`
--
ALTER TABLE `tb_penerbit`
  ADD PRIMARY KEY (`id_penerbit`);

--
-- Indeks untuk tabel `tb_pengarang`
--
ALTER TABLE `tb_pengarang`
  ADD PRIMARY KEY (`id_pengarang`);

--
-- Indeks untuk tabel `tb_pengembalian`
--
ALTER TABLE `tb_pengembalian`
  ADD PRIMARY KEY (`id_pengembalian`),
  ADD KEY `id_peminjaman` (`id_peminjaman`);

--
-- Indeks untuk tabel `tb_permissions`
--
ALTER TABLE `tb_permissions`
  ADD PRIMARY KEY (`id_permission`);

--
-- Indeks untuk tabel `tb_rak`
--
ALTER TABLE `tb_rak`
  ADD PRIMARY KEY (`id_rak`);

--
-- Indeks untuk tabel `tb_rules`
--
ALTER TABLE `tb_rules`
  ADD PRIMARY KEY (`id_rule`);

--
-- Indeks untuk tabel `tb_rule_permission`
--
ALTER TABLE `tb_rule_permission`
  ADD KEY `id_rule` (`id_rule`),
  ADD KEY `id_permission` (`id_permission`) USING BTREE;

--
-- Indeks untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD PRIMARY KEY (`id_user`),
  ADD UNIQUE KEY `username` (`username`),
  ADD KEY `id_rule` (`id_rule`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tb_kategori`
--
ALTER TABLE `tb_kategori`
  MODIFY `id_kategori` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=133;

--
-- AUTO_INCREMENT untuk tabel `tb_peminjaman_detail`
--
ALTER TABLE `tb_peminjaman_detail`
  MODIFY `id_peminjaman_detail` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=60;

--
-- AUTO_INCREMENT untuk tabel `tb_penerbit`
--
ALTER TABLE `tb_penerbit`
  MODIFY `id_penerbit` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=85;

--
-- AUTO_INCREMENT untuk tabel `tb_pengarang`
--
ALTER TABLE `tb_pengarang`
  MODIFY `id_pengarang` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=55;

--
-- AUTO_INCREMENT untuk tabel `tb_pengembalian`
--
ALTER TABLE `tb_pengembalian`
  MODIFY `id_pengembalian` int(50) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=62;

--
-- AUTO_INCREMENT untuk tabel `tb_permissions`
--
ALTER TABLE `tb_permissions`
  MODIFY `id_permission` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=45;

--
-- AUTO_INCREMENT untuk tabel `tb_rak`
--
ALTER TABLE `tb_rak`
  MODIFY `id_rak` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `tb_rules`
--
ALTER TABLE `tb_rules`
  MODIFY `id_rule` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  MODIFY `id_user` int(10) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=22;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tb_buku`
--
ALTER TABLE `tb_buku`
  ADD CONSTRAINT `tb_buku_ibfk_1` FOREIGN KEY (`id_kategori`) REFERENCES `tb_kategori` (`id_kategori`),
  ADD CONSTRAINT `tb_buku_ibfk_2` FOREIGN KEY (`id_penerbit`) REFERENCES `tb_penerbit` (`id_penerbit`),
  ADD CONSTRAINT `tb_buku_ibfk_3` FOREIGN KEY (`id_pengarang`) REFERENCES `tb_pengarang` (`id_pengarang`),
  ADD CONSTRAINT `tb_buku_ibfk_4` FOREIGN KEY (`id_rak`) REFERENCES `tb_rak` (`id_rak`);

--
-- Ketidakleluasaan untuk tabel `tb_peminjaman`
--
ALTER TABLE `tb_peminjaman`
  ADD CONSTRAINT `tb_peminjaman_ibfk_1` FOREIGN KEY (`id_user`) REFERENCES `tb_users` (`id_user`);

--
-- Ketidakleluasaan untuk tabel `tb_peminjaman_detail`
--
ALTER TABLE `tb_peminjaman_detail`
  ADD CONSTRAINT `tb_peminjaman_detail_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `tb_peminjaman` (`id_peminjaman`),
  ADD CONSTRAINT `tb_peminjaman_detail_ibfk_2` FOREIGN KEY (`id_buku`) REFERENCES `tb_buku` (`id_buku`);

--
-- Ketidakleluasaan untuk tabel `tb_pengembalian`
--
ALTER TABLE `tb_pengembalian`
  ADD CONSTRAINT `tb_pengembalian_ibfk_1` FOREIGN KEY (`id_peminjaman`) REFERENCES `tb_peminjaman` (`id_peminjaman`) ON DELETE NO ACTION ON UPDATE NO ACTION;

--
-- Ketidakleluasaan untuk tabel `tb_rule_permission`
--
ALTER TABLE `tb_rule_permission`
  ADD CONSTRAINT `tb_rule_permission_ibfk_1` FOREIGN KEY (`id_permission`) REFERENCES `tb_permissions` (`id_permission`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `tb_rule_permission_ibfk_2` FOREIGN KEY (`id_rule`) REFERENCES `tb_rules` (`id_rule`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `tb_users`
--
ALTER TABLE `tb_users`
  ADD CONSTRAINT `tb_users_ibfk_1` FOREIGN KEY (`id_rule`) REFERENCES `tb_rules` (`id_rule`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
