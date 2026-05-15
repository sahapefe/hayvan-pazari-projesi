<?php
session_start();
include 'baglan.php';

// --- 1. KAYIT OLMA ---
if (isset($_POST['kayit_ol'])) {
    $ad_soyad = mysqli_real_escape_string($baglanti, $_POST['ad_soyad']);
    $eposta = mysqli_real_escape_string($baglanti, $_POST['eposta']);
    $sifre = $_POST['sifre']; 
    $rol = "user"; // Varsayılan rol

    $kaydet = mysqli_query($baglanti, "INSERT INTO kullanicilar (ad_soyad, eposta, sifre, rol) VALUES ('$ad_soyad', '$eposta', '$sifre', '$rol')");

    if ($kaydet) { header("Location: giris.php?durum=ok"); exit; }
    else { header("Location: kayit.php?durum=hata"); exit; }
}

// --- 2. GİRİŞ YAPMA ---
if (isset($_POST['giris_yap'])) {
    $eposta = mysqli_real_escape_string($baglanti, $_POST['eposta']);
    $sifre = mysqli_real_escape_string($baglanti, $_POST['sifre']);

    $sorgu = mysqli_query($baglanti, "SELECT * FROM kullanicilar WHERE eposta='$eposta' AND sifre='$sifre'");
    if (mysqli_num_rows($sorgu) > 0) {
        $kullanici = mysqli_fetch_assoc($sorgu);
        $_SESSION['user_id'] = $kullanici['id'];
        $_SESSION['ad_soyad'] = $kullanici['ad_soyad'];
        $_SESSION['rol'] = $kullanici['rol'];
        header("Location: index.php"); exit;
    } else {
        header("Location: giris.php?durum=hata"); exit;
    }
}

// --- 3. İLAN EKLEME ---
if (isset($_POST['ilan_ekle'])) {
    $satici_id = $_SESSION['user_id'];
    $tur = mysqli_real_escape_string($baglanti, $_POST['tur']);
    $cins = mysqli_real_escape_string($baglanti, $_POST['cins']);
    $kilogram = $_POST['kilogram'];
    $fiyat = $_POST['fiyat'];
    $sehir = mysqli_real_escape_string($baglanti, $_POST['sehir']);
    $telefon = mysqli_real_escape_string($baglanti, $_POST['telefon']);
    $aciklama = mysqli_real_escape_string($baglanti, $_POST['aciklama']);
    $yas = mysqli_real_escape_string($baglanti, $_POST['yas']);
    $kupe_no = mysqli_real_escape_string($baglanti, $_POST['kupe_no']);

    // --- MÜKERRER KÜPE NO KONTROLÜ (ÖZGÜN ÖZELLİK) ---
    $kontrol = mysqli_query($baglanti, "SELECT id FROM kurbanliklar WHERE kupe_no = '$kupe_no'");
    if (mysqli_num_rows($kontrol) > 0) {
        header("Location: ilan_ver.php?durum=mukerrer_kupe");
        exit;
    }

    $dizin = "uploads/";
    $dosya_adi = time() . "_" . $_FILES['fotograf']['name']; 
    
    if (move_uploaded_file($_FILES['fotograf']['tmp_name'], $dizin . $dosya_adi)) {
        $sorgu = mysqli_query($baglanti, "INSERT INTO kurbanliklar (satici_id, tur, cins, kilogram, fiyat, sehir, telefon, aciklama, fotograf, yas, kupe_no) 
                                          VALUES ('$satici_id', '$tur', '$cins', '$kilogram', '$fiyat', '$sehir', '$telefon', '$aciklama', '$dosya_adi', '$yas', '$kupe_no')");
        if ($sorgu) { header("Location: index.php?ilan=basarili"); exit; }
    }
}

// --- 4. İLAN GÜNCELLEME ---
if (isset($_POST['ilan_guncelle'])) {
    $ilan_id = $_POST['ilan_id'];
    $tur = mysqli_real_escape_string($baglanti, $_POST['tur']);
    $cins = mysqli_real_escape_string($baglanti, $_POST['cins']);
    $fiyat = $_POST['fiyat'];
    $kilogram = $_POST['kilogram'];
    $yas = mysqli_real_escape_string($baglanti, $_POST['yas']);
    $kupe_no = mysqli_real_escape_string($baglanti, $_POST['kupe_no']);

    $resim_ek = "";
    if ($_FILES['fotograf']['size'] > 0) {
        $dosya_adi = time() . "_" . $_FILES['fotograf']['name'];
        move_uploaded_file($_FILES['fotograf']['tmp_name'], "uploads/" . $dosya_adi);
        $resim_ek = ", fotograf='$dosya_adi'";
    }

    $guncelle = mysqli_query($baglanti, "UPDATE kurbanliklar SET 
        tur='$tur', 
        cins='$cins', 
        fiyat='$fiyat', 
        kilogram='$kilogram', 
        yas='$yas', 
        kupe_no='$kupe_no' 
        $resim_ek 
        WHERE id='$ilan_id'");

    if ($guncelle) {
        header("Location: ilanlarim.php?durum=ok");
        exit;
    } else {
        echo "Hata: " . mysqli_error($baglanti);
    }
}

// --- 5. İLAN SİLME ---
if (isset($_GET['sil_id'])) {
    $sil_id = mysqli_real_escape_string($baglanti, $_GET['sil_id']);
    $user_id = $_SESSION['user_id'];
    $rol = $_SESSION['rol'];

    if ($rol == 'admin') {
        mysqli_query($baglanti, "DELETE FROM kurbanliklar WHERE id = '$sil_id'");
    } else {
        mysqli_query($baglanti, "DELETE FROM kurbanliklar WHERE id = '$sil_id' AND satici_id = '$user_id'");
    }
    header("Location: ilanlarim.php?durum=silindi"); exit;
}
?>