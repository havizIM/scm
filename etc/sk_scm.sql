-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 13 Agu 2019 pada 18.02
-- Versi server: 10.1.40-MariaDB
-- Versi PHP: 7.1.29

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sk_scm`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `bank_account`
--

CREATE TABLE `bank_account` (
  `id_account` int(11) NOT NULL,
  `id_supplier` varchar(11) NOT NULL,
  `nama_bank` varchar(30) NOT NULL,
  `cabang` varchar(50) NOT NULL,
  `pemilik_account` varchar(100) NOT NULL,
  `no_rekening` varchar(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `bank_account`
--

INSERT INTO `bank_account` (`id_account`, `id_supplier`, `nama_bank`, `cabang`, `pemilik_account`, `no_rekening`) VALUES
(7, 'SP-00000001', 'BCA', 'Jembatan 5', 'Haviz Indra Maulana', '1791606298');

-- --------------------------------------------------------

--
-- Struktur dari tabel `category`
--

CREATE TABLE `category` (
  `id_category` varchar(11) NOT NULL,
  `nama_category` varchar(50) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `category`
--

INSERT INTO `category` (`id_category`, `nama_category`) VALUES
('CAT-0000001', 'Makanan'),
('CAT-0000002', 'Minuman'),
('CAT-0000003', 'Perlengkapan');

-- --------------------------------------------------------

--
-- Struktur dari tabel `group`
--

CREATE TABLE `group` (
  `id_group` int(11) NOT NULL,
  `nama_group` varchar(50) NOT NULL,
  `lokasi_group` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `group`
--

INSERT INTO `group` (`id_group`, `nama_group`, `lokasi_group`) VALUES
(2, 'Area 1', 'DKI Jakarta'),
(5, 'Area 2', 'Depok');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoice`
--

CREATE TABLE `invoice` (
  `no_invoice` varchar(11) NOT NULL,
  `no_order` varchar(11) NOT NULL,
  `status_invoice` enum('Open','Close') NOT NULL,
  `tgl_invoice` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `tgl_tempo` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `invoice`
--

INSERT INTO `invoice` (`no_invoice`, `no_order`, `status_invoice`, `tgl_invoice`, `tgl_tempo`) VALUES
('INV-0000001', 'PO-00000001', 'Open', '2019-08-13 08:36:35', '2019-08-15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `invoice_detail`
--

CREATE TABLE `invoice_detail` (
  `no_invoice` varchar(11) NOT NULL,
  `deskripsi` varchar(100) NOT NULL,
  `harga` int(10) NOT NULL,
  `qty` int(5) NOT NULL,
  `ppn` int(10) NOT NULL,
  `total_harga` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `invoice_detail`
--

INSERT INTO `invoice_detail` (`no_invoice`, `deskripsi`, `harga`, `qty`, `ppn`, `total_harga`) VALUES
('INV-0000001', 'Test 1', 200000, 1, 20000, 220000),
('INV-0000001', 'Test 2', 100000, 1, 10000, 110000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `order`
--

CREATE TABLE `order` (
  `no_order` varchar(11) NOT NULL,
  `id_warehouse` varchar(11) NOT NULL,
  `id_supplier` varchar(11) NOT NULL,
  `status_order` enum('Open','Close') NOT NULL,
  `tgl_order` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `order`
--

INSERT INTO `order` (`no_order`, `id_warehouse`, `id_supplier`, `status_order`, `tgl_order`) VALUES
('PO-00000001', 'WH-00000001', 'SP-00000001', 'Open', '2019-08-13 08:31:18'),
('PO-00000002', 'WH-00000001', 'SP-00000001', 'Open', '2019-08-13 15:37:49');

-- --------------------------------------------------------

--
-- Struktur dari tabel `order_detail`
--

CREATE TABLE `order_detail` (
  `no_order` varchar(11) NOT NULL,
  `id_product` varchar(11) NOT NULL,
  `qty` int(5) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `order_detail`
--

INSERT INTO `order_detail` (`no_order`, `id_product`, `qty`) VALUES
('PO-00000001', 'PR-00000002', 2),
('PO-00000001', 'PR-00000001', 100),
('PO-00000002', 'PR-00000003', 2),
('PO-00000002', 'PR-00000002', 3),
('PO-00000002', 'PR-00000001', 100);

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment`
--

CREATE TABLE `payment` (
  `no_payment` varchar(11) NOT NULL,
  `id_account` int(11) NOT NULL,
  `tgl_payment` date NOT NULL,
  `total_bayar` int(10) NOT NULL,
  `tgl_input_payment` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `payment`
--

INSERT INTO `payment` (`no_payment`, `id_account`, `tgl_payment`, `total_bayar`, `tgl_input_payment`) VALUES
('PVC-0000001', 7, '2019-08-13', 220000, '2019-08-13 15:59:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `payment_detail`
--

CREATE TABLE `payment_detail` (
  `no_payment` varchar(11) NOT NULL,
  `no_invoice` varchar(11) NOT NULL,
  `jml_bayar` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `payment_detail`
--

INSERT INTO `payment_detail` (`no_payment`, `no_invoice`, `jml_bayar`) VALUES
('PVC-0000001', 'INV-0000001', 220000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pic`
--

CREATE TABLE `pic` (
  `id_pic` int(11) NOT NULL,
  `id_supplier` varchar(11) NOT NULL,
  `nama_pic` varchar(50) NOT NULL,
  `handphone` varchar(12) NOT NULL,
  `email_pic` varchar(30) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(25) NOT NULL,
  `token` varchar(20) NOT NULL,
  `tgl_reg_pic` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `pic`
--

INSERT INTO `pic` (`id_pic`, `id_supplier`, `nama_pic`, `handphone`, `email_pic`, `username`, `password`, `token`, `tgl_reg_pic`) VALUES
(6, 'SP-00000001', 'Ndi', '081355754092', 'viz.ndinq@gmail.cm', 'havizim', '9bdok', '', '2019-08-13 04:38:03');

-- --------------------------------------------------------

--
-- Struktur dari tabel `product`
--

CREATE TABLE `product` (
  `id_product` varchar(11) NOT NULL,
  `id_supplier` varchar(11) NOT NULL,
  `id_category` varchar(11) NOT NULL,
  `satuan` varchar(10) NOT NULL,
  `nama_product` varchar(100) NOT NULL,
  `harga` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `product`
--

INSERT INTO `product` (`id_product`, `id_supplier`, `id_category`, `satuan`, `nama_product`, `harga`) VALUES
('PR-00000001', 'SP-00000001', 'CAT-0000002', 'Crat', 'Fanta', 2),
('PR-00000002', 'SP-00000001', 'CAT-0000002', 'Meter', 'Coba', 20000),
('PR-00000003', 'SP-00000001', 'CAT-0000002', 'Pcs', 'Lap Basah', 15000);

-- --------------------------------------------------------

--
-- Struktur dari tabel `shipping`
--

CREATE TABLE `shipping` (
  `no_shipping` varchar(11) NOT NULL,
  `no_order` varchar(11) NOT NULL,
  `tgl_shipping` date NOT NULL,
  `status_shipping` enum('Open','Close') NOT NULL,
  `tgl_receive` date NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `shipping`
--

INSERT INTO `shipping` (`no_shipping`, `no_order`, `tgl_shipping`, `status_shipping`, `tgl_receive`) VALUES
('DO-00000001', 'PO-00000001', '2019-08-13', 'Close', '2019-08-13');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supplier`
--

CREATE TABLE `supplier` (
  `id_supplier` varchar(11) NOT NULL,
  `nama_supplier` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telepon` varchar(12) NOT NULL,
  `fax` varchar(12) NOT NULL,
  `npwp` varchar(20) NOT NULL,
  `email` varchar(30) NOT NULL,
  `tgl_reg_supplier` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `status_supplier` enum('Aktif','Nonaktif','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `supplier`
--

INSERT INTO `supplier` (`id_supplier`, `nama_supplier`, `alamat`, `telepon`, `fax`, `npwp`, `email`, `tgl_reg_supplier`, `status_supplier`) VALUES
('SP-00000001', 'PT. AAA', 'Jakarta', '081355754092', '021 13758371', '13768137691', 'viz.ndinq@gmail.com', '2019-08-13 04:38:03', 'Aktif');

-- --------------------------------------------------------

--
-- Struktur dari tabel `supply_group`
--

CREATE TABLE `supply_group` (
  `id_group` int(11) NOT NULL,
  `id_supplier` varchar(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `supply_group`
--

INSERT INTO `supply_group` (`id_group`, `id_supplier`) VALUES
(2, 'SP-00000001');

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id_user` varchar(11) NOT NULL,
  `nama_lengkap` varchar(30) NOT NULL,
  `email` varchar(30) NOT NULL,
  `telepon` varchar(12) NOT NULL,
  `jenis_kelamin` enum('L','P','','') NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(25) NOT NULL,
  `level` enum('Admin','Finance','Warehouse','','') NOT NULL,
  `status` enum('Aktif','Nonaktif','','') NOT NULL,
  `token` varchar(15) NOT NULL,
  `tgl_reg_user` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id_user`, `nama_lengkap`, `email`, `telepon`, `jenis_kelamin`, `alamat`, `username`, `password`, `level`, `status`, `token`, `tgl_reg_user`) VALUES
('USR-0000001', 'Helpdesk - Administrator', 'helpdesk-scm@gmail.com', '081355754092', 'L', 'Jakarta', 'helpdesk', 'helpdesk', 'Admin', 'Aktif', '875a8f2f42c570f', '2019-08-11 19:49:47'),
('USR-0000002', 'Rudi Kurniawan a', 'rudikubk@gmail.com', '081355754092', 'L', 'Jakarta', 'rudiubk', 'rudi', 'Warehouse', 'Aktif', '6f0f639126c5d9e', '2019-08-13 08:30:44'),
('USR-0000003', 'Yugi Setiawan', 'yugisetiawan@gmail.com', '081355754092', 'L', 'Jakarta', 'yugi', 'yugi', 'Finance', 'Aktif', '72c9b19f83c4468', '2019-08-12 01:20:10'),
('USR-0000004', 'Ulfia Risqika', 'ulfia@gmail.com', '08135891385', 'P', 'Jakarta', 'ulfia', 'u3moa', 'Warehouse', 'Aktif', 'f3ff4c466a058ef', '2019-08-13 15:13:07');

-- --------------------------------------------------------

--
-- Struktur dari tabel `warehouse`
--

CREATE TABLE `warehouse` (
  `id_warehouse` varchar(11) NOT NULL,
  `id_group` int(11) NOT NULL,
  `id_user` varchar(11) NOT NULL,
  `nama_warehouse` varchar(50) NOT NULL,
  `alamat` varchar(100) NOT NULL,
  `telepon` varchar(12) NOT NULL,
  `fax` varchar(12) NOT NULL,
  `email` varchar(50) NOT NULL,
  `tgl_reg_warehouse` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

--
-- Dumping data untuk tabel `warehouse`
--

INSERT INTO `warehouse` (`id_warehouse`, `id_group`, `id_user`, `nama_warehouse`, `alamat`, `telepon`, `fax`, `email`, `tgl_reg_warehouse`) VALUES
('WH-00000001', 2, 'USR-0000002', 'Dominos Angke Jaya', 'Jl. Angke Jaya Raya', '081355754092', '021123123', 'viz.ndinq@gmail.com', '2019-07-25 12:05:59'),
('WH-00000002', 5, 'USR-0000004', 'Dominos Pizza Depok', 'Depok', '081257832131', '138691378691', 'dominozdepok@gmail.com', '2019-08-13 15:14:20');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `bank_account`
--
ALTER TABLE `bank_account`
  ADD PRIMARY KEY (`id_account`),
  ADD KEY `supplier` (`id_supplier`);

--
-- Indeks untuk tabel `category`
--
ALTER TABLE `category`
  ADD PRIMARY KEY (`id_category`);

--
-- Indeks untuk tabel `group`
--
ALTER TABLE `group`
  ADD PRIMARY KEY (`id_group`);

--
-- Indeks untuk tabel `invoice`
--
ALTER TABLE `invoice`
  ADD PRIMARY KEY (`no_invoice`),
  ADD KEY `order` (`no_order`);

--
-- Indeks untuk tabel `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD KEY `invoice` (`no_invoice`);

--
-- Indeks untuk tabel `order`
--
ALTER TABLE `order`
  ADD PRIMARY KEY (`no_order`),
  ADD KEY `warehouse` (`id_warehouse`),
  ADD KEY `supplier` (`id_supplier`);

--
-- Indeks untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  ADD KEY `order` (`no_order`),
  ADD KEY `product` (`id_product`);

--
-- Indeks untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD PRIMARY KEY (`no_payment`),
  ADD KEY `bank` (`id_account`),
  ADD KEY `bank_2` (`id_account`);

--
-- Indeks untuk tabel `payment_detail`
--
ALTER TABLE `payment_detail`
  ADD KEY `payment` (`no_payment`),
  ADD KEY `invoice` (`no_invoice`);

--
-- Indeks untuk tabel `pic`
--
ALTER TABLE `pic`
  ADD PRIMARY KEY (`id_pic`),
  ADD KEY `supplier` (`id_supplier`);

--
-- Indeks untuk tabel `product`
--
ALTER TABLE `product`
  ADD PRIMARY KEY (`id_product`),
  ADD KEY `supplier` (`id_supplier`),
  ADD KEY `category` (`id_category`);

--
-- Indeks untuk tabel `shipping`
--
ALTER TABLE `shipping`
  ADD PRIMARY KEY (`no_shipping`),
  ADD KEY `invoice` (`no_order`);

--
-- Indeks untuk tabel `supplier`
--
ALTER TABLE `supplier`
  ADD PRIMARY KEY (`id_supplier`);

--
-- Indeks untuk tabel `supply_group`
--
ALTER TABLE `supply_group`
  ADD KEY `supplier` (`id_supplier`),
  ADD KEY `group` (`id_group`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id_user`);

--
-- Indeks untuk tabel `warehouse`
--
ALTER TABLE `warehouse`
  ADD PRIMARY KEY (`id_warehouse`),
  ADD KEY `group` (`id_group`),
  ADD KEY `user` (`id_user`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `bank_account`
--
ALTER TABLE `bank_account`
  MODIFY `id_account` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `group`
--
ALTER TABLE `group`
  MODIFY `id_group` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `pic`
--
ALTER TABLE `pic`
  MODIFY `id_pic` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `bank_account`
--
ALTER TABLE `bank_account`
  ADD CONSTRAINT `bank_account_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `invoice`
--
ALTER TABLE `invoice`
  ADD CONSTRAINT `invoice_ibfk_1` FOREIGN KEY (`no_order`) REFERENCES `order` (`no_order`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `invoice_detail`
--
ALTER TABLE `invoice_detail`
  ADD CONSTRAINT `invoice_detail_ibfk_1` FOREIGN KEY (`no_invoice`) REFERENCES `invoice` (`no_invoice`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order`
--
ALTER TABLE `order`
  ADD CONSTRAINT `order_ibfk_1` FOREIGN KEY (`id_warehouse`) REFERENCES `warehouse` (`id_warehouse`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `order_detail`
--
ALTER TABLE `order_detail`
  ADD CONSTRAINT `order_detail_ibfk_1` FOREIGN KEY (`no_order`) REFERENCES `order` (`no_order`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `order_detail_ibfk_2` FOREIGN KEY (`id_product`) REFERENCES `product` (`id_product`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payment`
--
ALTER TABLE `payment`
  ADD CONSTRAINT `payment_ibfk_1` FOREIGN KEY (`id_account`) REFERENCES `bank_account` (`id_account`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `payment_detail`
--
ALTER TABLE `payment_detail`
  ADD CONSTRAINT `payment_detail_ibfk_1` FOREIGN KEY (`no_invoice`) REFERENCES `invoice` (`no_invoice`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `payment_detail_ibfk_2` FOREIGN KEY (`no_payment`) REFERENCES `payment` (`no_payment`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pic`
--
ALTER TABLE `pic`
  ADD CONSTRAINT `pic_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `product`
--
ALTER TABLE `product`
  ADD CONSTRAINT `product_ibfk_1` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `product_ibfk_2` FOREIGN KEY (`id_category`) REFERENCES `category` (`id_category`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `shipping`
--
ALTER TABLE `shipping`
  ADD CONSTRAINT `shipping_ibfk_1` FOREIGN KEY (`no_order`) REFERENCES `order` (`no_order`);

--
-- Ketidakleluasaan untuk tabel `supply_group`
--
ALTER TABLE `supply_group`
  ADD CONSTRAINT `supply_group_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `group` (`id_group`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `supply_group_ibfk_2` FOREIGN KEY (`id_supplier`) REFERENCES `supplier` (`id_supplier`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `warehouse`
--
ALTER TABLE `warehouse`
  ADD CONSTRAINT `warehouse_ibfk_1` FOREIGN KEY (`id_group`) REFERENCES `group` (`id_group`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `warehouse_ibfk_2` FOREIGN KEY (`id_user`) REFERENCES `user` (`id_user`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
