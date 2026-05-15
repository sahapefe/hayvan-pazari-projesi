<?php
$host = "localhost";
$user = "root";
$pass = ""; 
$db   = "hayvan_pazari"; // Veritabanı adını buraya göre güncelle

$baglanti = mysqli_connect($host, $user, $pass, $db);
if (!$baglanti) { die("Bağlantı hatası: " . mysqli_connect_error()); }
mysqli_set_charset($baglanti, "utf8");
?>