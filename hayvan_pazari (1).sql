-- phpMyAdmin SQL Dump
-- version 5.2.3
-- https://www.phpmyadmin.net/
--
-- Anamakine: 127.0.0.1:3306
-- Üretim Zamanı: 15 May 2026, 12:16:52
-- Sunucu sürümü: 8.4.7
-- PHP Sürümü: 8.3.28

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Veritabanı: `hayvan_pazari`
--

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kullanicilar`
--

DROP TABLE IF EXISTS `kullanicilar`;
CREATE TABLE IF NOT EXISTS `kullanicilar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `ad_soyad` varchar(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `eposta` varchar(100) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `sifre` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `rol` enum('admin','user') COLLATE utf8mb4_turkish_ci DEFAULT 'user',
  PRIMARY KEY (`id`),
  UNIQUE KEY `eposta` (`eposta`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kullanicilar`
--

INSERT INTO `kullanicilar` (`id`, `ad_soyad`, `eposta`, `sifre`, `rol`) VALUES
(1, 'Admin Sahap', 'admin@test.com', '123456', 'admin'),
(2, 'Uğur Komuşçu', 'ugurkomuscu@gmail.com', 'ugurkomuscu123', 'user'),
(3, 'Nisa Ayan', 'nisaayan@gmail.com', 'nisa1234', 'user'),
(4, 'uğur gümüşcü', 'ugrhg19@gmail.com', '123987', 'user');

-- --------------------------------------------------------

--
-- Tablo için tablo yapısı `kurbanliklar`
--

DROP TABLE IF EXISTS `kurbanliklar`;
CREATE TABLE IF NOT EXISTS `kurbanliklar` (
  `id` int NOT NULL AUTO_INCREMENT,
  `satici_id` int DEFAULT NULL,
  `tur` enum('Koç','Dana','Düve','Deve','Koyun') COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `cins` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `kilogram` int DEFAULT NULL,
  `yas` int DEFAULT NULL,
  `fiyat` decimal(10,2) DEFAULT NULL,
  `sehir` varchar(50) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `telefon` varchar(15) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `fotograf` varchar(255) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `aciklama` text COLLATE utf8mb4_turkish_ci,
  `kupe_no` varchar(20) COLLATE utf8mb4_turkish_ci DEFAULT NULL,
  `satildi_mi` tinyint(1) DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=22 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_turkish_ci;

--
-- Tablo döküm verisi `kurbanliklar`
--

INSERT INTO `kurbanliklar` (`id`, `satici_id`, `tur`, `cins`, `kilogram`, `yas`, `fiyat`, `sehir`, `telefon`, `fotograf`, `aciklama`, `kupe_no`, `satildi_mi`) VALUES
(20, 3, 'Dana', 'Holstein', 230, 4, 210000.00, 'Trabzon', '05364813661', '1778697433_Adaklik-ve-Kurbanlik-Dana-500-520-kg-resim-9.jpg', 'iyi güzel dana', 'TR659874', 0);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
