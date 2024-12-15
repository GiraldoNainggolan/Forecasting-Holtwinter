-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 14 Des 2024 pada 13.09
-- Versi server: 10.4.32-MariaDB-log
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `hw-ade`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_kunjungan`
--

CREATE TABLE `tabel_kunjungan` (
  `id_kunjungan` int(11) NOT NULL,
  `id_wisata` int(11) NOT NULL,
  `periode` int(11) NOT NULL,
  `bulan` int(11) NOT NULL,
  `tahun` int(11) NOT NULL,
  `jumlah_pengunjung` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_kunjungan`
--

INSERT INTO `tabel_kunjungan` (`id_kunjungan`, `id_wisata`, `periode`, `bulan`, `tahun`, `jumlah_pengunjung`) VALUES
(1, 1, 1, 1, 2019, 471),
(2, 1, 2, 2, 2019, 331),
(3, 1, 3, 3, 2019, 221),
(4, 1, 4, 4, 2019, 361),
(5, 1, 5, 5, 2019, 601),
(6, 1, 6, 6, 2019, 491),
(7, 1, 7, 7, 2019, 762),
(8, 1, 8, 8, 2019, 120),
(9, 1, 9, 9, 2019, 848),
(10, 1, 10, 10, 2019, 644),
(11, 1, 11, 11, 2019, 170),
(12, 1, 12, 12, 2019, 563),
(13, 1, 13, 1, 2020, 192),
(14, 1, 14, 2, 2020, 322),
(15, 1, 15, 3, 2020, 689),
(16, 1, 16, 4, 2020, 203),
(17, 1, 17, 5, 2020, 781),
(18, 1, 18, 6, 2020, 167),
(19, 1, 19, 7, 2020, 125),
(20, 1, 20, 8, 2020, 327),
(21, 1, 21, 9, 2020, 523),
(22, 1, 22, 10, 2020, 399),
(23, 1, 23, 11, 2020, 125),
(24, 1, 24, 12, 2020, 163),
(25, 1, 25, 1, 2021, 204),
(26, 1, 26, 2, 2021, 601),
(27, 1, 27, 3, 2021, 106),
(28, 1, 28, 4, 2021, 544),
(29, 1, 29, 5, 2021, 85),
(30, 1, 30, 6, 2021, 420),
(31, 1, 31, 7, 2021, 521),
(32, 1, 32, 8, 2021, 390),
(33, 1, 33, 9, 2021, 391),
(34, 1, 34, 10, 2021, 340),
(35, 1, 35, 11, 2021, 170),
(36, 1, 36, 12, 2021, 165),
(37, 1, 37, 1, 2022, 180),
(38, 1, 38, 2, 2022, 183),
(39, 1, 39, 3, 2022, 421),
(40, 1, 40, 4, 2022, 140),
(41, 1, 41, 5, 2022, 124),
(42, 1, 42, 6, 2022, 150),
(43, 1, 43, 7, 2022, 212),
(44, 1, 44, 8, 2022, 198),
(45, 1, 45, 9, 2022, 182),
(46, 1, 46, 10, 2022, 450),
(47, 1, 47, 11, 2022, 230),
(48, 1, 48, 12, 2022, 242),
(49, 1, 49, 1, 2023, 267),
(50, 1, 50, 2, 2023, 219),
(51, 1, 51, 3, 2023, 150),
(52, 1, 52, 4, 2023, 541),
(53, 1, 53, 5, 2023, 694),
(54, 1, 54, 6, 2023, 801),
(55, 1, 55, 7, 2023, 602),
(56, 1, 56, 8, 2023, 782),
(57, 1, 57, 9, 2023, 641),
(58, 1, 58, 10, 2023, 216),
(59, 1, 59, 11, 2023, 825),
(60, 1, 60, 12, 2023, 302);

-- --------------------------------------------------------

--
-- Struktur dari tabel `tabel_wisata`
--

CREATE TABLE `tabel_wisata` (
  `id_wisata` int(11) NOT NULL,
  `nama_wisata` varchar(30) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `tabel_wisata`
--

INSERT INTO `tabel_wisata` (`id_wisata`, `nama_wisata`) VALUES
(1, 'a');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `tabel_kunjungan`
--
ALTER TABLE `tabel_kunjungan`
  ADD PRIMARY KEY (`id_kunjungan`),
  ADD KEY `ad` (`id_wisata`);

--
-- Indeks untuk tabel `tabel_wisata`
--
ALTER TABLE `tabel_wisata`
  ADD PRIMARY KEY (`id_wisata`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `tabel_kunjungan`
--
ALTER TABLE `tabel_kunjungan`
  MODIFY `id_kunjungan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=61;

--
-- AUTO_INCREMENT untuk tabel `tabel_wisata`
--
ALTER TABLE `tabel_wisata`
  MODIFY `id_wisata` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `tabel_kunjungan`
--
ALTER TABLE `tabel_kunjungan`
  ADD CONSTRAINT `ad` FOREIGN KEY (`id_wisata`) REFERENCES `tabel_wisata` (`id_wisata`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
