-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 30 Bulan Mei 2026 pada 17.03
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
-- Database: `pramuka`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_hasil`
--

CREATE TABLE `absensi_hasil` (
  `id_hasil` int(11) NOT NULL,
  `id_kegiatan` int(11) NOT NULL,
  `nta` varchar(50) NOT NULL,
  `nama_anggota` varchar(255) NOT NULL,
  `waktu_absen` datetime NOT NULL,
  `lokasi_anggota` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `absensi_kegiatan`
--

CREATE TABLE `absensi_kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `nama_kegiatan` varchar(255) NOT NULL,
  `jam_mulai` time DEFAULT NULL,
  `lokasi_admin` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id_galeri` int(11) NOT NULL,
  `judul_galeri` varchar(255) NOT NULL,
  `kategori` varchar(100) NOT NULL,
  `foto_cover` varchar(255) NOT NULL,
  `tanggal` varchar(100) DEFAULT NULL,
  `lokasi` varchar(150) DEFAULT NULL,
  `peserta` varchar(50) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `tanggal_dibuat` timestamp NOT NULL DEFAULT current_timestamp(),
  `id_kegiatan` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `iuran_anggota`
--

CREATE TABLE `iuran_anggota` (
  `id` int(11) NOT NULL,
  `judul_tanggal` varchar(100) NOT NULL,
  `nama_anggota` varchar(100) NOT NULL,
  `nta` varchar(50) NOT NULL,
  `tanggal_bayar` date NOT NULL,
  `nominal` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kas`
--

CREATE TABLE `kas` (
  `id` int(11) NOT NULL,
  `tanggal` date NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `jumlah_item` varchar(100) DEFAULT NULL,
  `jenis` enum('masuk','keluar') NOT NULL,
  `jumlah` int(11) NOT NULL,
  `id_bendahara` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `kegiatan`
--

CREATE TABLE `kegiatan` (
  `id_kegiatan` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `tanggal` varchar(100) NOT NULL,
  `lokasi` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) NOT NULL,
  `status` varchar(50) DEFAULT 'Akan Datang'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `materi`
--

CREATE TABLE `materi` (
  `id_materi` int(11) NOT NULL,
  `judul_materi` varchar(255) NOT NULL,
  `tipe_materi` varchar(50) NOT NULL,
  `tanggal_upload` date NOT NULL,
  `file_materi` varchar(255) NOT NULL,
  `id_admin` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `nta` varchar(50) NOT NULL,
  `gugus` varchar(50) DEFAULT NULL,
  `jk` enum('Laki-laki','Perempuan') DEFAULT NULL,
  `kontak` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `role` enum('anggota','admin','bendahara') DEFAULT 'anggota'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `nta`, `gugus`, `jk`, `kontak`, `password`, `role`) VALUES
(17, 'Pak Agung', '123456111111', '12-001', 'Laki-laki', 'agung@gmail.com', '6f5d0ad4bc971cddc51a0c5f74bdf3fd', 'admin'),
(18, 'Arip Dermawan', '112233123456', '13-001-06', 'Laki-laki', 'aripp@gmail.com', 'bb83d246fb39192ad202b6b3168d4b95', 'anggota'),
(19, 'Eva Nur diana', '223344123456', '13-002-07', 'Laki-laki', 'eva@gmail.com', 'c22cbce29ad4475eb7dc401ac4680333', 'bendahara'),
(20, 'Daris', '123456', '13-001-06', 'Laki-laki', 'daris@gmail.com', 'e070298397d522a137b5d263442d7a89', 'anggota');

--
-- Trigger `users`
--
DELIMITER $$
CREATE TRIGGER `before_insert_users` BEFORE INSERT ON `users` FOR EACH ROW BEGIN
    IF NEW.role = 'admin' AND (SELECT COUNT(*) FROM users WHERE role = 'admin') >= 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Admin sudah ada!';
    END IF;
    
    IF NEW.role = 'bendahara' AND (SELECT COUNT(*) FROM users WHERE role = 'bendahara') >= 1 THEN
        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Error: Bendahara sudah ada!';
    END IF;
END
$$
DELIMITER ;

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `absensi_hasil`
--
ALTER TABLE `absensi_hasil`
  ADD PRIMARY KEY (`id_hasil`);

--
-- Indeks untuk tabel `absensi_kegiatan`
--
ALTER TABLE `absensi_kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id_galeri`);

--
-- Indeks untuk tabel `iuran_anggota`
--
ALTER TABLE `iuran_anggota`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kas`
--
ALTER TABLE `kas`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  ADD PRIMARY KEY (`id_kegiatan`);

--
-- Indeks untuk tabel `materi`
--
ALTER TABLE `materi`
  ADD PRIMARY KEY (`id_materi`);

--
-- Indeks untuk tabel `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `nta` (`nta`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `absensi_hasil`
--
ALTER TABLE `absensi_hasil`
  MODIFY `id_hasil` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `absensi_kegiatan`
--
ALTER TABLE `absensi_kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id_galeri` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `iuran_anggota`
--
ALTER TABLE `iuran_anggota`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `kas`
--
ALTER TABLE `kas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `kegiatan`
--
ALTER TABLE `kegiatan`
  MODIFY `id_kegiatan` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT untuk tabel `materi`
--
ALTER TABLE `materi`
  MODIFY `id_materi` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
