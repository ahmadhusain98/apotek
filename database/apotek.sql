-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Feb 04, 2024 at 07:59 PM
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
-- Table structure for table `akses_modul`
--

CREATE TABLE `akses_modul` (
  `id` int(11) NOT NULL,
  `kode_role` varchar(10) NOT NULL,
  `id_modul` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akses_modul`
--

INSERT INTO `akses_modul` (`id`, `kode_role`, `id_modul`) VALUES
(2, 'R0002', 1),
(3, 'R0003', 1),
(4, 'R0004', 1),
(5, 'R0005', 1),
(6, 'R0001', 2),
(7, 'R0003', 2),
(8, 'R0001', 3),
(9, 'R0001', 4),
(10, 'R0001', 5),
(11, 'R0001', 6),
(12, 'R0001', 7),
(13, 'R0001', 8),
(14, 'R0002', 4),
(15, 'R0003', 4),
(17, 'R0003', 5),
(18, 'R0004', 5),
(19, 'R0003', 6),
(20, 'R0004', 6),
(21, 'R0003', 7),
(22, 'R0004', 7),
(23, 'R0003', 8),
(24, 'R0004', 8),
(25, 'R0001', 1);

-- --------------------------------------------------------

--
-- Table structure for table `akses_unit`
--

CREATE TABLE `akses_unit` (
  `id` int(11) NOT NULL,
  `username` varchar(20) NOT NULL,
  `kode_unit` varchar(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `akses_unit`
--

INSERT INTO `akses_unit` (`id`, `username`, `kode_unit`) VALUES
(6, 'admin', 'DIY'),
(7, 'admin', 'MGL'),
(12, 'admin1', 'MGL');

-- --------------------------------------------------------

--
-- Table structure for table `barang`
--

CREATE TABLE `barang` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `kategori` varchar(10) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- --------------------------------------------------------

--
-- Table structure for table `harga_unit`
--

CREATE TABLE `harga_unit` (
  `id` int(11) NOT NULL,
  `kode_unit` varchar(10) NOT NULL,
  `kode_barang` varchar(10) NOT NULL,
  `harga_beli` int(11) NOT NULL,
  `kena_pajak` int(1) NOT NULL DEFAULT 0,
  `harga_beli_ppn` int(11) NOT NULL,
  `harga_net` int(11) NOT NULL,
  `harga_jual` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

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
(3, 'Pembelian', '<i class=\"fas fa-fw fa-solid fa-truck-ramp-box\"></i>', 'Pembelian', 6),
(4, 'Ubah Posisi Modul', '<i class=\"fas fa-fw fa-solid fa-bars\"></i>', 'C_modul', 3),
(5, 'Modul', '<i class=\"fas fa-fw fa-solid fa-bars\"></i>', 'C_modul/l_modul', 3),
(6, 'Inti', '<i class=\"fa-solid fa-record-vinyl\"></i>', 'Inti', 2),
(7, 'Aktivasi Akun', '<i class=\"fa-solid fa-user-check\"></i>', 'Aktifasi', 4),
(9, 'Penjualan', '<i class=\"fa-solid fa-money-bill-transfer\"></i>', 'Penjualan', 7),
(10, 'Stok Persediaan', '<i class=\"fa-solid fa-chart-pie\"></i>', 'Stok', 8),
(11, 'Kasir', '<i class=\"fa-solid fa-cash-register\"></i>', 'Kasir', 5),
(12, 'Deposit', '<i class=\"fa-solid fa-money-bill-transfer\"></i>', 'Deposit', 5),
(13, 'Cabang', '<i class=\"fa-solid fa-building-circle-check\"></i>', 'Cabang', 2),
(14, 'Umum', '<i class=\"fa-solid fa-globe\"></i>', 'Umum', 2),
(15, 'Akses Modul', '<i class=\"fa-solid fa-fingerprint\"></i>', 'Akses_modul', 4);

-- --------------------------------------------------------

--
-- Table structure for table `m_kategori`
--

CREATE TABLE `m_kategori` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_kategori`
--

INSERT INTO `m_kategori` (`id`, `kode`, `nama`) VALUES
(1, 'KAT0000001', 'Obat Ringan');

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
(1, 'Beranda'),
(2, 'Master'),
(3, 'Pengaturan'),
(4, 'Keamanan'),
(5, 'Pembayaran'),
(6, 'Barang Masuk'),
(7, 'Barang Keluar'),
(8, 'Laporan');

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
-- Table structure for table `m_satuan`
--

CREATE TABLE `m_satuan` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_satuan`
--

INSERT INTO `m_satuan` (`id`, `kode`, `nama`) VALUES
(2, 'SAT0000001', 'Pcs');

-- --------------------------------------------------------

--
-- Table structure for table `m_tempo`
--

CREATE TABLE `m_tempo` (
  `id` int(11) NOT NULL,
  `keterangan` text NOT NULL,
  `hitung` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_tempo`
--

INSERT INTO `m_tempo` (`id`, `keterangan`, `hitung`) VALUES
(2, 'Tempo 1 Minggu', 7);

-- --------------------------------------------------------

--
-- Table structure for table `m_unit`
--

CREATE TABLE `m_unit` (
  `id` int(11) NOT NULL,
  `kode_unit` varchar(10) NOT NULL,
  `nama_unit` text NOT NULL,
  `foto` text NOT NULL,
  `alamat` text NOT NULL,
  `kontak` varchar(200) NOT NULL,
  `penanggungjawab` varchar(200) NOT NULL,
  `tgl_mulai` date NOT NULL,
  `tgl_selesai` date NOT NULL,
  `status_unit` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_unit`
--

INSERT INTO `m_unit` (`id`, `kode_unit`, `nama_unit`, `foto`, `alamat`, `kontak`, `penanggungjawab`, `tgl_mulai`, `tgl_selesai`, `status_unit`) VALUES
(7, 'DIY', 'Yogyakarta', 'default.png', 'Yogyakarta, Jl. Magelang', '00123', 'Ahmad Husain', '2023-01-01', '2024-03-01', 1),
(8, 'MGL', 'Magelang', 'default.png', 'Magelang, Jl. Borobudur', '000123', 'Ardi', '2024-01-01', '2025-01-01', 1);

-- --------------------------------------------------------

--
-- Table structure for table `m_vendor`
--

CREATE TABLE `m_vendor` (
  `id` int(11) NOT NULL,
  `kode` varchar(10) NOT NULL,
  `nama` varchar(200) NOT NULL,
  `alamat` text NOT NULL,
  `nohp` varchar(15) NOT NULL,
  `email` varchar(200) NOT NULL,
  `trx_terakhir` datetime NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- Dumping data for table `m_vendor`
--

INSERT INTO `m_vendor` (`id`, `kode`, `nama`, `alamat`, `nohp`, `email`, `trx_terakhir`, `status`) VALUES
(2, 'Garuda', 'PT. Garuda Nusantara', 'Jl. Magelang Utara', '000123', 'garuda@pt.nusantara', '0000-00-00 00:00:00', 1);

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
(4, 'Kategori Barang', 'Inti/kategori', 6),
(5, 'Satuan Barang', 'Inti/satuan', 6),
(6, 'Penerimaan Barang', 'Pembelian/penerimaan', 3),
(7, 'Retur Barang', 'Pembelian/retur', 3),
(8, 'Jual', 'Penjualan/jual', 9),
(9, 'Retur', 'Penjualan/retur', 9),
(11, 'Laporan', 'Pembelian/laporan', 3),
(12, 'Laporan', 'Penjualan/laporan', 9),
(13, 'Bayar', 'Kasir/bayar', 11),
(14, 'Retur', 'Kasir/retur', 11),
(15, 'Unit', 'Cabang/unit', 13),
(16, 'Pengelola Unit', 'Cabang/pengelola', 13),
(18, 'Vendor', 'Umum/vendor', 14),
(19, 'Jatuh Tempo', 'Inti/tempo', 6),
(20, 'Barang', 'Umum/barang', 14);

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
(1, 'admin', 'admin', '21232f297a57a5a743894a0e4a801fc3', 'A000000001', '573f22a1aa17b366f5489745dc4704e1.jpg', 'P', 'ahmad husain', 'DI Yogyakarta', '0895363260970', 'ahmad.ummgl@gmail.com', '2024-01-04', 1, 0, '1998-05-02', 'jakarta', 'R0001'),
(5, 'ahmadhusain', 'ahmadhusain', '0a61eae58bcb5869aee9c0ba6753180a', 'A000000002', 'default1.svg', 'P', 'Ahmad Husain', '-', '123', 'ahmad@gmail.com', '2024-01-24', 1, 0, '1998-05-02', 'jakarta', 'R0005'),
(6, 'user', 'user', 'ee11cbb19052e40b07aac0ca060c23ee', 'U000000001', 'default2.svg', 'W', 'user', 'mana aja', '123', 'user@gmail.com', '2024-01-24', 1, 0, '2000-01-01', 'mana', 'R0005'),
(12, 'admin1', 'admin1', 'e00cf25ad42683b3df678c61f42c6bda', 'A000000002', 'default2.svg', 'W', 'michel', '-', '123', '123@gmail.com', '2024-02-02', 1, 0, '2000-02-02', '-', 'R0001');

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
(1, 'admin', 1),
(5, 'ahmadhusain', 0),
(6, 'user', 1),
(12, 'admin1', 0);

--
-- Indexes for dumped tables
--

--
-- Indexes for table `akses_modul`
--
ALTER TABLE `akses_modul`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `akses_unit`
--
ALTER TABLE `akses_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `barang`
--
ALTER TABLE `barang`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `harga_unit`
--
ALTER TABLE `harga_unit`
  ADD PRIMARY KEY (`id`);

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
-- Indexes for table `m_satuan`
--
ALTER TABLE `m_satuan`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_tempo`
--
ALTER TABLE `m_tempo`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_unit`
--
ALTER TABLE `m_unit`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `m_vendor`
--
ALTER TABLE `m_vendor`
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
-- AUTO_INCREMENT for table `akses_modul`
--
ALTER TABLE `akses_modul`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT for table `akses_unit`
--
ALTER TABLE `akses_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `barang`
--
ALTER TABLE `barang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `harga_unit`
--
ALTER TABLE `harga_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `menu`
--
ALTER TABLE `menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=16;

--
-- AUTO_INCREMENT for table `m_kategori`
--
ALTER TABLE `m_kategori`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

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
-- AUTO_INCREMENT for table `m_satuan`
--
ALTER TABLE `m_satuan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_tempo`
--
ALTER TABLE `m_tempo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `m_unit`
--
ALTER TABLE `m_unit`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT for table `m_vendor`
--
ALTER TABLE `m_vendor`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `role_aksi`
--
ALTER TABLE `role_aksi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT for table `sub_menu`
--
ALTER TABLE `sub_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;

--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;

--
-- AUTO_INCREMENT for table `user_aktivasi`
--
ALTER TABLE `user_aktivasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
