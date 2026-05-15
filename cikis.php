<?php
session_start(); // Mevcut oturumu yakala
session_destroy(); // Tüm oturum verilerini (id, ad_soyad vb.) sil
header("Location: giris.php"); // Kullanıcıyı giriş sayfasına yönlendir
exit;
?>