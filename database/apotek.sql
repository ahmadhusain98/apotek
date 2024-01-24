-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Jan 24, 2024 at 11:11 AM
-- Server version: 10.4.24-MariaDB
-- PHP Version: 7.4.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `apotek`
--

-- --------------------------------------------------------

--
-- Table structure for table `menu`
--

CREATE TABLE `menu` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `ikon` text NOT NULL,
  `url` text NOT NULL,
  `id_modul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `menu`
--

INSERT INTO `menu` (`id`, `nama`, `ikon`, `url`, `id_modul`) VALUES
(1, 'Beranda', '<i class=\"fas fa-fw fa-tachometer-alt\"></i>', 'Dashboard', 1),
(2, 'Pengguna', '<i class=\"fas fa-fw fa-solid fa-users\"></i>', 'Users', 2),
(3, 'Pembelian', '<i class=\"fas fa-fw fa-solid fa-truck-ramp-box\"></i>', 'Pembelian', 4),
(4, 'Ubah Posisi Modul', '<i class=\"fas fa-fw fa-solid fa-bars\"></i>', 'C_modul', 3),
(5, 'Modul', '<i class=\"fas fa-fw fa-solid fa-bars\"></i>', 'C_modul/l_modul', 3),
(6, 'Umum', '<i class=\"fa-solid fa-record-vinyl\"></i>', 'Umum', 2);

-- --------------------------------------------------------

--
-- Table structure for table `m_kategori`
--

CREATE TABLE `m_kategori` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `m_modul`
--

CREATE TABLE `m_modul` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_modul`
--

INSERT INTO `m_modul` (`id`, `nama`) VALUES
(1, ''),
(2, 'Master'),
(3, 'Pengaturan'),
(4, 'Barang Masuk');

-- --------------------------------------------------------

--
-- Table structure for table `m_role`
--

CREATE TABLE `m_role` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `keterangan` varchar(200) NOT NULL,
  `tambah` int(1) NOT NULL DEFAULT 0,
  `ubah` int(1) NOT NULL DEFAULT 0,
  `hapus` int(1) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_role`
--

INSERT INTO `m_role` (`id`, `kode`, `keterangan`, `tambah`, `ubah`, `hapus`) VALUES
(1, 'R0001', 'Administrator', 1, 1, 1),
(2, 'R0002', 'Owner', 0, 0, 0),
(3, 'R0003', 'Penanggung Jawab', 1, 1, 1),
(4, 'R0004', 'Kasir', 1, 1, 0),
(5, 'R0005', 'Member', 1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `role_aksi`
--

CREATE TABLE `role_aksi` (
  `id` int(11) NOT NULL,
  `setuju` int(1) NOT NULL DEFAULT 1,
  `tambah` int(1) NOT NULL DEFAULT 1,
  `ubah` int(1) NOT NULL DEFAULT 1,
  `hapus` int(1) NOT NULL DEFAULT 1,
  `kode_role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `role_aksi`
--

INSERT INTO `role_aksi` (`id`, `setuju`, `tambah`, `ubah`, `hapus`, `kode_role`) VALUES
(1, 1, 1, 1, 1, 'R0001'),
(2, 1, 0, 0, 0, 'R0002'),
(3, 1, 1, 1, 1, 'R0003'),
(4, 0, 1, 1, 0, 'R0004'),
(5, 0, 1, 1, 1, 'R0005');

-- --------------------------------------------------------

--
-- Table structure for table `sub_menu`
--

CREATE TABLE `sub_menu` (
  `id` int(11) NOT NULL,
  `nama` text NOT NULL,
  `url` text NOT NULL,
  `id_menu` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `sub_menu`
--

INSERT INTO `sub_menu` (`id`, `nama`, `url`, `id_menu`) VALUES
(1, 'Pengelola', 'Users/pengelola', 2),
(2, 'Member', 'Users/member', 2),
(3, 'PO', 'Pembelian/po', 3),
(4, 'Kategori Barang', 'Umum/kategori', 6);

-- --------------------------------------------------------

--
-- Table structure for table `user`
--

CREATE TABLE `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `sandi_ori` text NOT NULL,
  `sandi` text NOT NULL,
  `kode_member` varchar(10) NOT NULL,
  `foto` text NOT NULL DEFAULT 'default.png',
  `gender` char(1) NOT NULL DEFAULT '-',
  `nama` varchar(200) NOT NULL,
  `alamat` text NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `email` text NOT NULL,
  `tgl_gabung` date NOT NULL DEFAULT current_timestamp(),
  `status_akun` int(1) NOT NULL DEFAULT 0,
  `status_aktif` int(1) NOT NULL DEFAULT 0,
  `tgl_lahir` date NOT NULL,
  `tempat_lahir` varchar(200) NOT NULL,
  `kode_role` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user`
--

INSERT INTO `user` (`id`, `username`, `sandi_ori`, `sandi`, `kode_member`, `foto`, `gender`, `nama`, `alamat`, `nohp`, `email`, `tgl_gabung`, `status_akun`, `status_aktif`, `tgl_lahir`, `tempat_lahir`, `kode_role`) VALUES
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'A000000001', '573f22a1aa17b366f5489745dc4704e1.jpg', 'P', 'ahmad husain', 'DI Yogyakarta', '0895363260970', 'ahmad.ummgl@gmail.com', '2024-01-04', 1, 1, '1998-05-02', 'jakarta', 'R0001');

-- --------------------------------------------------------

--
-- Table structure for table `user_aktivasi`
--

CREATE TABLE `user_aktivasi` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `aktivasi` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `user_aktivasi`
--

INSERT INTO `user_aktivasi` (`id`, `username`, `aktivasi`) VALUES
(1, 'admin', 1);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `menu`
--
ALTER TABLE `menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_kategori`
--
ALTER TABLE `m_kategori`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_modul`
--
ALTER TABLE `m_modul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_role`
--
ALTER TABLE `m_role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role_aksi`
--
ALTER TABLE `role_aksi`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `sub_menu`
--
ALTER TABLE `sub_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_aktivasi`
--
ALTER TABLE `user_aktivasi`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=7;

--
-- AUTO_INCREMENT for table `m_kategori`
--
ALTER TABLE `m_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `m_modul`
--
ALTER TABLE `m_modul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=1000002;

--
-- AUTO_INCREMENT for table `m_role`
--
ALTER TABLE `m_role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `role_aksi`
--
ALTER TABLE `role_aksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT for table `user_aktivasi`
--
ALTER TABLE `user_aktivasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
