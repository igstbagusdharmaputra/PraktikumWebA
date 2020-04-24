-- phpMyAdmin SQL Dump
-- version 4.8.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 24 Apr 2020 pada 15.34
-- Versi server: 10.1.33-MariaDB
-- Versi PHP: 7.2.6

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `pagination`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `pagination_table`
--

CREATE TABLE `pagination_table` (
  `id` int(10) NOT NULL,
  `name` varchar(250) NOT NULL,
  `age` int(10) NOT NULL,
  `dept` varchar(250) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pagination_table`
--

INSERT INTO `pagination_table` (`id`, `name`, `age`, `dept`) VALUES
(1, 'Ahsan', 22, 'Information Technology'),
(2, 'Ali', 25, 'Human Resource'),
(3, 'Kashif', 30, 'Information Technology'),
(4, 'Iqbal', 31, 'Information Technology'),
(5, 'Farooq', 34, 'Finance'),
(6, 'Adnan', 29, 'Finance'),
(7, 'Javed', 25, 'Information Technology'),
(8, 'Irfan', 35, 'Production'),
(9, 'Kamran', 34, 'Production'),
(10, 'Danish', 27, 'Finance');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `pagination_table`
--
ALTER TABLE `pagination_table`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `pagination_table`
--
ALTER TABLE `pagination_table`
  MODIFY `id` int(10) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=11;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
