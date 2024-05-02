/*
 Navicat Premium Data Transfer

 Source Server         : Laragon
 Source Server Type    : MariaDB
 Source Server Version : 101105 (10.11.5-MariaDB-log)
 Source Host           : localhost:3306
 Source Schema         : simdata_sosial

 Target Server Type    : MariaDB
 Target Server Version : 101105 (10.11.5-MariaDB-log)
 File Encoding         : 65001

 Date: 28/11/2023 07:40:36
*/

SET NAMES utf8mb4;
SET
    FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for hubungan_keluarga
-- ----------------------------
DROP TABLE IF EXISTS `hubungan_keluarga`;
CREATE TABLE `hubungan_keluarga`
(
    `id`            bigint(20) UNSIGNED                                           NOT NULL AUTO_INCREMENT,
    `nama_hubungan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 8
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of hubungan_keluarga
-- ----------------------------
INSERT INTO `hubungan_keluarga`
VALUES (1, 'Suami');
INSERT INTO `hubungan_keluarga`
VALUES (2, 'Istri');
INSERT INTO `hubungan_keluarga`
VALUES (3, 'Anak');
INSERT INTO `hubungan_keluarga`
VALUES (4, 'Keponakan');
INSERT INTO `hubungan_keluarga`
VALUES (5, 'Paman');
INSERT INTO `hubungan_keluarga`
VALUES (6, 'Bibi');
INSERT INTO `hubungan_keluarga`
VALUES (7, 'Keluarga Lainnya');

-- ----------------------------
-- Table structure for jenis_bantuan
-- ----------------------------
DROP TABLE IF EXISTS `jenis_bantuan`;
CREATE TABLE `jenis_bantuan`
(
    `id`           bigint(20) UNSIGNED                                           NOT NULL AUTO_INCREMENT,
    `nama_bantuan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `alias`        varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
    `warna`        varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
    `deskripsi`    varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 6
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jenis_bantuan
-- ----------------------------
INSERT INTO `jenis_bantuan`
VALUES (1, 'Program Keluarga Harapan', 'PKH', 'success',
        'Bantuan ini disalurkan kepada beberapa kategori yaitu Ibu hamil, anak usia dini, lansia, disabilitas, pelajar SD, SMP dan SMA. 	masing-masing kategori menerima bansos dengan nominal yang berbeda-beda. ');
INSERT INTO `jenis_bantuan`
VALUES (2, 'Bantuan Pangan Non Tunai', 'BPNT', 'info',
        'Bantuan ini disalurkan dalam bentuk non tunai kepada Keluarga Penerima Manfaat (KPM).');
INSERT INTO `jenis_bantuan`
VALUES (3, 'Bantuan Iuran Jaminan Kesehatan (BPJS)', 'PBI-JK', 'warning',
        'Program bansos rutin yang cair setiap bulan. Para penerima bantuan ini dapat menggunakan layanan fasilitas kesehatan BPJS Kesehatan secara gratis tanpa harus membayar iuran');
INSERT INTO `jenis_bantuan`
VALUES (4, 'Bantuan Terhadap Penyandang Cacat/ Disabilitas', 'BTPD', 'gray',
        'Bantuan Sosial berupa paket sembako kepada lansia dan penyandang disabilitas');
INSERT INTO `jenis_bantuan`
VALUES (5, 'Bantuan Sosial Beras Sejahtera', 'RASTRA', 'danger',
        'Bantuan Sosial yang disalurkan oleh Pemerintah kepada KPM dalam bentuk beras dan disalurkan setiap bulannya.');

-- ----------------------------
-- Table structure for jenis_pekerjaan
-- ----------------------------
DROP TABLE IF EXISTS `jenis_pekerjaan`;
CREATE TABLE `jenis_pekerjaan`
(
    `id`             bigint(20) UNSIGNED                                           NOT NULL AUTO_INCREMENT,
    `nama_pekerjaan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 7
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jenis_pekerjaan
-- ----------------------------
INSERT INTO `jenis_pekerjaan`
VALUES (1, 'PETANI');
INSERT INTO `jenis_pekerjaan`
VALUES (2, 'TUKANG');
INSERT INTO `jenis_pekerjaan`
VALUES (3, 'PEDAGANG');
INSERT INTO `jenis_pekerjaan`
VALUES (4, 'PERAWAT');
INSERT INTO `jenis_pekerjaan`
VALUES (5, 'PEKERJA KONTRAK');
INSERT INTO `jenis_pekerjaan`
VALUES (6, 'TIDAK BEKERJA');

-- ----------------------------
-- Table structure for jenis_pelayanan
-- ----------------------------
DROP TABLE IF EXISTS `jenis_pelayanan`;
CREATE TABLE `jenis_pelayanan`
(
    `id`        bigint(20) UNSIGNED                                           NOT NULL AUTO_INCREMENT,
    `nama_ppks` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
    `alias`     varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
    `deskripsi` text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci         NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 2
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of jenis_pelayanan
-- ----------------------------
INSERT INTO `jenis_pelayanan`
VALUES (1, 'Anak Balita Telantar', 'ABT',
        'seorang anak berusia 5 (lima) tahun ke bawah yang ditelantarkan orang tuanya dan/atau berada di dalam keluarga tidak mampu oleh orang tua/keluarga yang tidak memberikan pengasuhan, perawatan, pembinaan dan perlindungan bagi anak sehingga hak-hak dasarnya semakin tidak terpenuhi serta anak dieksploitasi untuk tujuan tertentu');

-- ----------------------------
-- Table structure for kriteria_jenis_pelayanan
-- ----------------------------
DROP TABLE IF EXISTS `kriteria_jenis_pelayanan`;
CREATE TABLE `kriteria_jenis_pelayanan`
(
    `kriteria_pelayanan_id` bigint(20) UNSIGNED NOT NULL,
    `jenis_pelayanan_id`    bigint(20) UNSIGNED NOT NULL,
    INDEX `kriteria_jenis_pelayanan_kriteria_pelayanan_id_foreign` (`kriteria_pelayanan_id` ASC) USING BTREE,
    INDEX `kriteria_jenis_pelayanan_jenis_pelayanan_id_foreign` (`jenis_pelayanan_id` ASC) USING BTREE,
    CONSTRAINT `kriteria_jenis_pelayanan_jenis_pelayanan_id_foreign` FOREIGN KEY (`jenis_pelayanan_id`) REFERENCES `jenis_pelayanan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE,
    CONSTRAINT `kriteria_jenis_pelayanan_kriteria_pelayanan_id_foreign` FOREIGN KEY (`kriteria_pelayanan_id`) REFERENCES `kriteria_pelayanan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kriteria_jenis_pelayanan
-- ----------------------------
INSERT INTO `kriteria_jenis_pelayanan`
VALUES (1, 1);
INSERT INTO `kriteria_jenis_pelayanan`
VALUES (2, 1);
INSERT INTO `kriteria_jenis_pelayanan`
VALUES (3, 1);
INSERT INTO `kriteria_jenis_pelayanan`
VALUES (4, 1);
INSERT INTO `kriteria_jenis_pelayanan`
VALUES (5, 1);
INSERT INTO `kriteria_jenis_pelayanan`
VALUES (6, 1);

-- ----------------------------
-- Table structure for kriteria_pelayanan
-- ----------------------------
DROP TABLE IF EXISTS `kriteria_pelayanan`;
CREATE TABLE `kriteria_pelayanan`
(
    `id`                 bigint(20) UNSIGNED                                           NOT NULL AUTO_INCREMENT,
    `jenis_pelayanan_id` bigint(20) UNSIGNED                                           NULL DEFAULT NULL,
    `nama_kriteria`      text CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci         NOT NULL,
    `deskripsi`          varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL,
    PRIMARY KEY (`id`) USING BTREE,
    INDEX `kriteria_pelayanan_jenis_pelayanan_id_foreign` (`jenis_pelayanan_id` ASC) USING BTREE,
    CONSTRAINT `kriteria_pelayanan_jenis_pelayanan_id_foreign` FOREIGN KEY (`jenis_pelayanan_id`) REFERENCES `jenis_pelayanan` (`id`) ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE = InnoDB
  AUTO_INCREMENT = 7
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of kriteria_pelayanan
-- ----------------------------
INSERT INTO `kriteria_pelayanan`
VALUES (1, NULL, 'Terlantar/ tanpa asuhan yang layak', NULL);
INSERT INTO `kriteria_pelayanan`
VALUES (2, NULL, 'Berasal dari keluarga sangat miskin / miskin', NULL);
INSERT INTO `kriteria_pelayanan`
VALUES (3, NULL, 'Kehilangan hak asuh dari orangtua/ keluarga', NULL);
INSERT INTO `kriteria_pelayanan`
VALUES (4, NULL, 'Anak balita yang mengalami perlakuan salah dan diterlantarkan oleh orang tua/keluarga', NULL);
INSERT INTO `kriteria_pelayanan`
VALUES (5, NULL,
        'Anak balita yang dieksploitasi secara ekonomi seperti anak balita yang disalahgunakan orang tua menjadi pengemis di jalanan',
        NULL);
INSERT INTO `kriteria_pelayanan`
VALUES (6, NULL, 'Anak balita yang menderita gizi buruk atau kurang', NULL);

-- ----------------------------
-- Table structure for pendidikan_terakhir
-- ----------------------------
DROP TABLE IF EXISTS `pendidikan_terakhir`;
CREATE TABLE `pendidikan_terakhir`
(
    `id`              bigint(20) UNSIGNED                                           NOT NULL AUTO_INCREMENT,
    `nama_pendidikan` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '',
    PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB
  AUTO_INCREMENT = 6
  CHARACTER SET = utf8mb4
  COLLATE = utf8mb4_unicode_ci
  ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of pendidikan_terakhir
-- ----------------------------
INSERT INTO `pendidikan_terakhir`
VALUES (1, 'SD');
INSERT INTO `pendidikan_terakhir`
VALUES (2, 'SMP');
INSERT INTO `pendidikan_terakhir`
VALUES (3, 'SMA');
INSERT INTO `pendidikan_terakhir`
VALUES (4, 'MAN');
INSERT INTO `pendidikan_terakhir`
VALUES (5, 'TIDAK SEKOLAH');

SET
    FOREIGN_KEY_CHECKS = 1;
