/*
 Navicat Premium Data Transfer

 Source Server         : local
 Source Server Type    : MySQL
 Source Server Version : 80030 (8.0.30)
 Source Host           : 127.0.0.1:3306
 Source Schema         : pamsimas

 Target Server Type    : MySQL
 Target Server Version : 80030 (8.0.30)
 File Encoding         : 65001

 Date: 03/11/2025 07:19:32
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for kategori_pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `kategori_pelanggan`;
CREATE TABLE `kategori_pelanggan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_kategori` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kategori` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `beban_tetap` decimal(15, 2) NULL DEFAULT 0.00,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `kode_kategori`(`kode_kategori` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori_pelanggan
-- ----------------------------
INSERT INTO `kategori_pelanggan` VALUES (1, 'KP-001', 'Standar', 'Kategori pelanggan biasa', 5000.00, 1, '2025-10-13 17:40:04', '2025-10-13 17:40:04');
INSERT INTO `kategori_pelanggan` VALUES (2, 'KP-002', 'Instansi', 'Kategori Instansi', 10000.00, 1, '2025-10-13 17:40:20', '2025-10-13 17:40:20');
INSERT INTO `kategori_pelanggan` VALUES (3, 'KP-003', 'Sekolah Negeri', 'Kategori Instansi', 3000.00, 1, '2025-10-13 17:40:34', '2025-10-13 17:43:47');

-- ----------------------------
-- Table structure for kategori_pengeluaran
-- ----------------------------
DROP TABLE IF EXISTS `kategori_pengeluaran`;
CREATE TABLE `kategori_pengeluaran`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_kategori` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_kategori` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `kode_kategori`(`kode_kategori` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kategori_pengeluaran
-- ----------------------------
INSERT INTO `kategori_pengeluaran` VALUES (1, 'PK-001', 'Gaji Karyawan', 'Pengeluaran gaji karyawan', 1, '2025-10-13 21:29:14', '2025-10-13 21:29:14');
INSERT INTO `kategori_pengeluaran` VALUES (2, 'PK-002', 'Makan Karyawan', 'Pengeluaran Makan', 1, '2025-10-13 21:29:27', '2025-10-13 21:30:47');

-- ----------------------------
-- Table structure for pelanggan
-- ----------------------------
DROP TABLE IF EXISTS `pelanggan`;
CREATE TABLE `pelanggan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_pelanggan` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_pelanggan` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `alamat` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `wilayah_id` int NOT NULL,
  `kategori_id` int NOT NULL,
  `no_telepon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `no_meter` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` enum('aktif','nonaktif','suspend') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'aktif',
  `tanggal_registrasi` date NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `kode_pelanggan`(`kode_pelanggan` ASC) USING BTREE,
  INDEX `kategori_id`(`kategori_id` ASC) USING BTREE,
  INDEX `idx_pelanggan_status`(`status` ASC) USING BTREE,
  INDEX `idx_pelanggan_wilayah`(`wilayah_id` ASC) USING BTREE,
  CONSTRAINT `pelanggan_ibfk_1` FOREIGN KEY (`wilayah_id`) REFERENCES `wilayah` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pelanggan_ibfk_2` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pelanggan
-- ----------------------------
INSERT INTO `pelanggan` VALUES (1, 'PLG20251013561', 'customer', 'Kendal', 1, 1, '2323131', '231231231', 'aktif', '2025-10-13', '2025-10-13 20:53:07', '2025-10-13 20:53:07');
INSERT INTO `pelanggan` VALUES (3, '66950', 'Jono B', 'Cepiring', 1, 1, '08121323', '2323131', 'aktif', '2025-10-13', '2025-10-13 21:01:37', '2025-10-13 21:01:37');
INSERT INTO `pelanggan` VALUES (4, '94856', 'customer', 'werwrwerw', 1, 1, '08121323', '2323131', 'aktif', '2025-10-13', '2025-10-18 21:45:39', '2025-10-18 21:45:39');

-- ----------------------------
-- Table structure for pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `pembayaran`;
CREATE TABLE `pembayaran`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_pembayaran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tagihan_id` int NOT NULL,
  `tanggal_bayar` datetime NOT NULL,
  `jumlah_bayar` decimal(15, 2) NOT NULL,
  `kasir_id` int NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `no_pembayaran`(`no_pembayaran` ASC) USING BTREE,
  INDEX `tagihan_id`(`tagihan_id` ASC) USING BTREE,
  INDEX `kasir_id`(`kasir_id` ASC) USING BTREE,
  INDEX `idx_pembayaran_tanggal`(`tanggal_bayar` ASC) USING BTREE,
  CONSTRAINT `pembayaran_ibfk_1` FOREIGN KEY (`tagihan_id`) REFERENCES `tagihan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pembayaran_ibfk_2` FOREIGN KEY (`kasir_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pembayaran
-- ----------------------------
INSERT INTO `pembayaran` VALUES (2, 'PB-68F39EF05EBCE', 3, '2025-10-18 00:00:00', 65000.00, 1, 'Pembayaran tagihan ID 3 oleh kasir ID 1', '2025-10-18 21:06:40');
INSERT INTO `pembayaran` VALUES (3, 'PB-68F5E65DA9753', 4, '2025-10-20 00:00:00', 105000.00, 1, 'Pembayaran tagihan ID 4 oleh kasir ID 1', '2025-10-20 14:35:57');

-- ----------------------------
-- Table structure for pencatatan_meter
-- ----------------------------
DROP TABLE IF EXISTS `pencatatan_meter`;
CREATE TABLE `pencatatan_meter`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `pelanggan_id` int NOT NULL,
  `periode_tahun` int NOT NULL,
  `periode_bulan` int NOT NULL,
  `tanggal_catat` date NOT NULL,
  `meter_awal` int NOT NULL,
  `meter_akhir` int NOT NULL,
  `pemakaian` int GENERATED ALWAYS AS ((`meter_akhir` - `meter_awal`)) STORED NULL,
  `petugas_id` int NOT NULL,
  `foto_meter` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `status` enum('draft','verified','billed') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'draft',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_periode`(`pelanggan_id` ASC, `periode_tahun` ASC, `periode_bulan` ASC) USING BTREE,
  INDEX `petugas_id`(`petugas_id` ASC) USING BTREE,
  INDEX `idx_pencatatan_periode`(`periode_tahun` ASC, `periode_bulan` ASC) USING BTREE,
  CONSTRAINT `pencatatan_meter_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `pencatatan_meter_ibfk_2` FOREIGN KEY (`petugas_id`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 22 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pencatatan_meter
-- ----------------------------
INSERT INTO `pencatatan_meter` VALUES (20, 3, 2025, 10, '2025-10-18', 0, 30, DEFAULT, 1, NULL, 'tttt', 'billed', '2025-10-18 20:28:32', '2025-10-18 20:28:32');
INSERT INTO `pencatatan_meter` VALUES (21, 4, 2025, 10, '2025-10-18', 0, 50, DEFAULT, 1, 'uploads/meter/meter_4_1760798765.png', 'ada', 'billed', '2025-10-18 21:46:05', '2025-10-18 21:46:05');

-- ----------------------------
-- Table structure for pengeluaran
-- ----------------------------
DROP TABLE IF EXISTS `pengeluaran`;
CREATE TABLE `pengeluaran`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_pengeluaran` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_pengeluaran` date NOT NULL,
  `kategori_pengeluaran_id` int NOT NULL,
  `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `jumlah` decimal(15, 2) NOT NULL,
  `penerima` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `status` enum('pending','approved','rejected') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'pending',
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `diinput_oleh` int NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `no_pengeluaran`(`no_pengeluaran` ASC) USING BTREE,
  INDEX `kategori_pengeluaran_id`(`kategori_pengeluaran_id` ASC) USING BTREE,
  INDEX `idx_pengeluaran_tanggal`(`tanggal_pengeluaran` ASC) USING BTREE,
  INDEX `diinput_oleh`(`diinput_oleh` ASC) USING BTREE,
  CONSTRAINT `pengeluaran_ibfk_1` FOREIGN KEY (`kategori_pengeluaran_id`) REFERENCES `kategori_pengeluaran` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `pengeluaran_ibfk_2` FOREIGN KEY (`diinput_oleh`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pengeluaran
-- ----------------------------
INSERT INTO `pengeluaran` VALUES (2, 'EXP000001', '2025-10-18', 1, 'Gaji Oktober 2025', 10000000.00, 'Karyawan', 'approved', '2025-10-18 22:33:06', '2025-10-18 22:37:43', 1);
INSERT INTO `pengeluaran` VALUES (4, 'EXP000002', '2025-10-20', 2, 'Acara Oktober 2025', 500000.00, 'Karyawan', 'approved', '2025-10-20 14:38:18', '2025-10-20 14:38:18', 1);

-- ----------------------------
-- Table structure for struk_pembayaran
-- ----------------------------
DROP TABLE IF EXISTS `struk_pembayaran`;
CREATE TABLE `struk_pembayaran`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `pembayaran_id` int NOT NULL,
  `nomor_struk` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `tanggal_cetak` datetime NOT NULL,
  `dicetak_oleh` int NOT NULL,
  `file_path` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `nomor_struk`(`nomor_struk` ASC) USING BTREE,
  INDEX `pembayaran_id`(`pembayaran_id` ASC) USING BTREE,
  INDEX `dicetak_oleh`(`dicetak_oleh` ASC) USING BTREE,
  CONSTRAINT `struk_pembayaran_ibfk_1` FOREIGN KEY (`pembayaran_id`) REFERENCES `pembayaran` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT,
  CONSTRAINT `struk_pembayaran_ibfk_2` FOREIGN KEY (`dicetak_oleh`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of struk_pembayaran
-- ----------------------------

-- ----------------------------
-- Table structure for tagihan
-- ----------------------------
DROP TABLE IF EXISTS `tagihan`;
CREATE TABLE `tagihan`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `no_tagihan` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `pelanggan_id` int NOT NULL,
  `pencatatan_meter_id` int NOT NULL,
  `periode_tahun` int NOT NULL,
  `periode_bulan` int NOT NULL,
  `tanggal_tagihan` date NOT NULL,
  `tanggal_jatuh_tempo` date NOT NULL,
  `pemakaian` int NOT NULL,
  `biaya_pemakaian` decimal(15, 2) NOT NULL,
  `beban_tetap` decimal(15, 2) NULL DEFAULT 0.00,
  `denda` decimal(15, 2) NULL DEFAULT 0.00,
  `total_tagihan` decimal(15, 2) NOT NULL,
  `status_pembayaran` enum('belum_bayar','sebagian','lunas') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT 'belum_bayar',
  `created_by` int NOT NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `no_tagihan`(`no_tagihan` ASC) USING BTREE,
  INDEX `pelanggan_id`(`pelanggan_id` ASC) USING BTREE,
  INDEX `created_by`(`created_by` ASC) USING BTREE,
  INDEX `idx_tagihan_status`(`status_pembayaran` ASC) USING BTREE,
  INDEX `idx_tagihan_periode`(`periode_tahun` ASC, `periode_bulan` ASC) USING BTREE,
  INDEX `tagihan_ibfk_2`(`pencatatan_meter_id` ASC) USING BTREE,
  CONSTRAINT `tagihan_ibfk_1` FOREIGN KEY (`pelanggan_id`) REFERENCES `pelanggan` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `tagihan_ibfk_2` FOREIGN KEY (`pencatatan_meter_id`) REFERENCES `pencatatan_meter` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `tagihan_ibfk_3` FOREIGN KEY (`created_by`) REFERENCES `users` (`id`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 5 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tagihan
-- ----------------------------
INSERT INTO `tagihan` VALUES (3, 'TAG/2025/10/0001', 3, 20, 2025, 10, '2025-10-18', '2025-10-25', 30, 60000.00, 5000.00, 0.00, 65000.00, 'lunas', 1, '2025-10-18 20:28:32', '2025-10-18 21:06:40');
INSERT INTO `tagihan` VALUES (4, 'TAG/2025/10/0002', 4, 21, 2025, 10, '2025-10-18', '2025-10-25', 50, 100000.00, 5000.00, 0.00, 105000.00, 'lunas', 1, '2025-10-18 21:46:05', '2025-10-20 14:35:57');

-- ----------------------------
-- Table structure for tarif_bertingkat
-- ----------------------------
DROP TABLE IF EXISTS `tarif_bertingkat`;
CREATE TABLE `tarif_bertingkat`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kategori_id` int NOT NULL,
  `tingkat` int NOT NULL,
  `batas_bawah` int NOT NULL,
  `batas_atas` int NULL DEFAULT NULL,
  `harga_per_m3` decimal(15, 2) NOT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `unique_tingkat`(`kategori_id` ASC, `tingkat` ASC) USING BTREE,
  CONSTRAINT `tarif_bertingkat_ibfk_1` FOREIGN KEY (`kategori_id`) REFERENCES `kategori_pelanggan` (`id`) ON DELETE CASCADE ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of tarif_bertingkat
-- ----------------------------
INSERT INTO `tarif_bertingkat` VALUES (1, 1, 1, 0, 20, 1500.00, 'Paling mura', '2025-10-13 20:09:10', '2025-10-13 20:16:38');
INSERT INTO `tarif_bertingkat` VALUES (2, 1, 2, 21, 50, 2000.00, 'Medium', '2025-10-13 20:09:36', '2025-10-13 20:09:36');

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `username` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_lengkap` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `no_telepon` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `role` enum('admin','Ketua','Petugas Lapangan','Kasir') CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `is_active` tinyint(1) NULL DEFAULT 1,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `username`(`username` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of users
-- ----------------------------
INSERT INTO `users` VALUES (1, 'admin', '0192023a7bbd73250516f069df18b500', 'Admin Kendal', '08232323', 'admin', 1, '2025-10-12 08:53:27', '2025-10-12 08:53:27');
INSERT INTO `users` VALUES (3, 'ketua', 'c39f48f2b9f2499963622152a2e9a97b', 'Ketua Pamsimas', '', 'Ketua', 1, '2025-10-20 21:20:57', '2025-10-20 21:20:57');
INSERT INTO `users` VALUES (4, 'petugas', '570c396b3fc856eceb8aa7357f32af1a', 'Petugas Lapangan', '', 'Petugas Lapangan', 1, '2025-10-20 21:21:17', '2025-10-20 21:22:04');
INSERT INTO `users` VALUES (5, 'kasir', 'de28f8f7998f23ab4194b51a6029416f', 'Kasir Pamsimas', '', 'Kasir', 1, '2025-10-20 21:21:42', '2025-10-20 21:21:42');

-- ----------------------------
-- Table structure for wilayah
-- ----------------------------
DROP TABLE IF EXISTS `wilayah`;
CREATE TABLE `wilayah`  (
  `id` int NOT NULL AUTO_INCREMENT,
  `kode_wilayah` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rt` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `rw` varchar(5) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NOT NULL,
  `nama_wilayah` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL DEFAULT NULL,
  `keterangan` text CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci NULL,
  `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `kode_wilayah`(`kode_wilayah` ASC) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 3 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of wilayah
-- ----------------------------
INSERT INTO `wilayah` VALUES (1, '0101', '01', '01', 'Ngampela', '-', '2025-10-13 17:22:55', '2025-10-13 17:24:58');

-- ----------------------------
-- View structure for vw_arus_kas
-- ----------------------------
DROP VIEW IF EXISTS `vw_arus_kas`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vw_arus_kas` AS select `vw_laporan_pemasukan`.`tanggal` AS `tanggal`,`vw_laporan_pemasukan`.`periode` AS `periode`,'Pemasukan' AS `tipe`,`vw_laporan_pemasukan`.`no_pembayaran` AS `nomor_transaksi`,`vw_laporan_pemasukan`.`nama_pelanggan` AS `keterangan`,`vw_laporan_pemasukan`.`jumlah_bayar` AS `jumlah` from `vw_laporan_pemasukan` union all select `vw_laporan_pengeluaran`.`tanggal` AS `tanggal`,`vw_laporan_pengeluaran`.`periode` AS `periode`,'Pengeluaran' AS `tipe`,`vw_laporan_pengeluaran`.`no_pengeluaran` AS `nomor_transaksi`,`vw_laporan_pengeluaran`.`deskripsi` AS `keterangan`,-(`vw_laporan_pengeluaran`.`jumlah`) AS `jumlah` from `vw_laporan_pengeluaran` where (`vw_laporan_pengeluaran`.`status` = 'approved');

-- ----------------------------
-- View structure for vw_laporan_pemasukan
-- ----------------------------
DROP VIEW IF EXISTS `vw_laporan_pemasukan`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vw_laporan_pemasukan` AS select date_format(`p`.`tanggal_bayar`,'%Y-%m') AS `periode`,cast(`p`.`tanggal_bayar` as date) AS `tanggal`,`p`.`no_pembayaran` AS `no_pembayaran`,`pl`.`kode_pelanggan` AS `kode_pelanggan`,`pl`.`nama_pelanggan` AS `nama_pelanggan`,`t`.`no_tagihan` AS `no_tagihan`,`p`.`jumlah_bayar` AS `jumlah_bayar`,`u`.`nama_lengkap` AS `kasir` from (((`pembayaran` `p` join `tagihan` `t` on((`p`.`tagihan_id` = `t`.`id`))) join `pelanggan` `pl` on((`t`.`pelanggan_id` = `pl`.`id`))) join `users` `u` on((`p`.`kasir_id` = `u`.`id`)));

-- ----------------------------
-- View structure for vw_laporan_pengeluaran
-- ----------------------------
DROP VIEW IF EXISTS `vw_laporan_pengeluaran`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vw_laporan_pengeluaran` AS select date_format(`pg`.`tanggal_pengeluaran`,'%Y-%m') AS `periode`,`pg`.`tanggal_pengeluaran` AS `tanggal`,`pg`.`no_pengeluaran` AS `no_pengeluaran`,`kp`.`nama_kategori` AS `nama_kategori`,`pg`.`deskripsi` AS `deskripsi`,`pg`.`jumlah` AS `jumlah`,`pg`.`penerima` AS `penerima`,`pg`.`status` AS `status`,`u`.`nama_lengkap` AS `diinput_oleh`,`pg`.`id` AS `id` from ((`pengeluaran` `pg` join `kategori_pengeluaran` `kp` on((`pg`.`kategori_pengeluaran_id` = `kp`.`id`))) join `users` `u` on((`pg`.`diinput_oleh` = `u`.`id`)));

-- ----------------------------
-- View structure for vw_perekaman_meter
-- ----------------------------
DROP VIEW IF EXISTS `vw_perekaman_meter`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vw_perekaman_meter` AS select `pencatatan_meter`.`id` AS `id`,`pencatatan_meter`.`pelanggan_id` AS `pelanggan_id`,`pencatatan_meter`.`periode_tahun` AS `periode_tahun`,`pencatatan_meter`.`periode_bulan` AS `periode_bulan`,`pencatatan_meter`.`tanggal_catat` AS `tanggal_catat`,`pencatatan_meter`.`meter_awal` AS `meter_awal`,`pencatatan_meter`.`meter_akhir` AS `meter_akhir`,`pencatatan_meter`.`pemakaian` AS `pemakaian`,`pencatatan_meter`.`petugas_id` AS `petugas_id`,`pencatatan_meter`.`foto_meter` AS `foto_meter`,`pencatatan_meter`.`keterangan` AS `keterangan`,`pencatatan_meter`.`status` AS `status`,`pencatatan_meter`.`created_at` AS `created_at`,`pencatatan_meter`.`updated_at` AS `updated_at`,`pelanggan`.`nama_pelanggan` AS `nama_pelanggan`,`pelanggan`.`alamat` AS `alamat`,`users`.`nama_lengkap` AS `nama_lengkap`,`pelanggan`.`no_meter` AS `no_meter` from ((`pencatatan_meter` join `pelanggan` on((`pencatatan_meter`.`pelanggan_id` = `pelanggan`.`id`))) join `users` on((`pencatatan_meter`.`petugas_id` = `users`.`id`)));

-- ----------------------------
-- View structure for vw_struk
-- ----------------------------
DROP VIEW IF EXISTS `vw_struk`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vw_struk` AS select `vw_tagihan`.`id` AS `id`,`vw_tagihan`.`no_tagihan` AS `no_tagihan`,`vw_tagihan`.`pelanggan_id` AS `pelanggan_id`,`vw_tagihan`.`pencatatan_meter_id` AS `pencatatan_meter_id`,`vw_tagihan`.`periode_tahun` AS `periode_tahun`,`vw_tagihan`.`periode_bulan` AS `periode_bulan`,`vw_tagihan`.`tanggal_tagihan` AS `tanggal_tagihan`,`vw_tagihan`.`tanggal_jatuh_tempo` AS `tanggal_jatuh_tempo`,`vw_tagihan`.`pemakaian` AS `pemakaian`,`vw_tagihan`.`biaya_pemakaian` AS `biaya_pemakaian`,`vw_tagihan`.`beban_tetap` AS `beban_tetap`,`vw_tagihan`.`denda` AS `denda`,`vw_tagihan`.`total_tagihan` AS `total_tagihan`,`vw_tagihan`.`status_pembayaran` AS `status_pembayaran`,`vw_tagihan`.`created_by` AS `created_by`,`vw_tagihan`.`created_at` AS `created_at`,`vw_tagihan`.`updated_at` AS `updated_at`,`vw_tagihan`.`nama_pelanggan` AS `nama_pelanggan`,`vw_tagihan`.`kode_pelanggan` AS `kode_pelanggan`,`vw_tagihan`.`alamat` AS `alamat`,`vw_tagihan`.`meter_awal` AS `meter_awal`,`vw_tagihan`.`meter_akhir` AS `meter_akhir`,`vw_tagihan`.`tanggal_catat` AS `tanggal_catat`,`vw_tagihan`.`nama_lengkap` AS `nama_lengkap`,`vw_tagihan`.`foto_meter` AS `foto_meter`,`pembayaran`.`tanggal_bayar` AS `tanggal_bayar`,`pembayaran`.`jumlah_bayar` AS `jumlah_bayar`,`pembayaran`.`no_pembayaran` AS `no_pembayaran` from (`vw_tagihan` join `pembayaran` on((`vw_tagihan`.`id` = `pembayaran`.`tagihan_id`)));

-- ----------------------------
-- View structure for vw_tagihan
-- ----------------------------
DROP VIEW IF EXISTS `vw_tagihan`;
CREATE ALGORITHM = UNDEFINED SQL SECURITY DEFINER VIEW `vw_tagihan` AS select `tagihan`.`id` AS `id`,`tagihan`.`no_tagihan` AS `no_tagihan`,`tagihan`.`pelanggan_id` AS `pelanggan_id`,`tagihan`.`pencatatan_meter_id` AS `pencatatan_meter_id`,`tagihan`.`periode_tahun` AS `periode_tahun`,`tagihan`.`periode_bulan` AS `periode_bulan`,`tagihan`.`tanggal_tagihan` AS `tanggal_tagihan`,`tagihan`.`tanggal_jatuh_tempo` AS `tanggal_jatuh_tempo`,`tagihan`.`pemakaian` AS `pemakaian`,`tagihan`.`biaya_pemakaian` AS `biaya_pemakaian`,`tagihan`.`beban_tetap` AS `beban_tetap`,`tagihan`.`denda` AS `denda`,`tagihan`.`total_tagihan` AS `total_tagihan`,`tagihan`.`status_pembayaran` AS `status_pembayaran`,`tagihan`.`created_by` AS `created_by`,`tagihan`.`created_at` AS `created_at`,`tagihan`.`updated_at` AS `updated_at`,`pelanggan`.`nama_pelanggan` AS `nama_pelanggan`,`pelanggan`.`kode_pelanggan` AS `kode_pelanggan`,`pelanggan`.`alamat` AS `alamat`,`pencatatan_meter`.`meter_awal` AS `meter_awal`,`pencatatan_meter`.`meter_akhir` AS `meter_akhir`,`pencatatan_meter`.`tanggal_catat` AS `tanggal_catat`,`users`.`nama_lengkap` AS `nama_lengkap`,`pencatatan_meter`.`foto_meter` AS `foto_meter` from (((`tagihan` left join `pelanggan` on((`tagihan`.`pelanggan_id` = `pelanggan`.`id`))) join `pencatatan_meter` on(((`tagihan`.`pencatatan_meter_id` = `pencatatan_meter`.`id`) and (`pelanggan`.`id` = `pencatatan_meter`.`pelanggan_id`)))) join `users` on(((`pencatatan_meter`.`petugas_id` = `users`.`id`) and (`tagihan`.`created_by` = `users`.`id`))));

SET FOREIGN_KEY_CHECKS = 1;
