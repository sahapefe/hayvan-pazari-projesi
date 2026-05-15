<?php 
session_start();
include 'baglan.php';

// Güvenlik: Giriş yapmamışsa at
if (!isset($_SESSION['user_id'])) { header("Location: giris.php"); exit; }

$id = mysqli_real_escape_string($baglanti, $_GET['id']);
$sorgu = mysqli_query($baglanti, "SELECT * FROM kurbanliklar WHERE id='$id'");
$ilan = mysqli_fetch_assoc($sorgu);

// Güvenlik: Admin değilse ve ilanın sahibi değilse düzenleyemesin
if ($_SESSION['rol'] != 'admin' && $ilan['satici_id'] != $_SESSION['user_id']) {
    die("<div style='color:white; text-align:center; margin-top:50px;'><h2>Bu ilanı düzenleme yetkiniz yok!</h2><a href='index.php'>Geri Dön</a></div>");
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>İlan Düzenle - Hayvan Pazarı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://i.yenicaggazetesi.com/storage/old/d/other/2025/05/18/askalede-kurban-pazari-acildi-fiyatlar-cep-yakiyor-350-bin-tlye-buyukbas-yenicag-3.jpg');
            background-attachment: fixed; background-size: cover; background-position: center;
            min-height: 100vh; font-family: 'Segoe UI', sans-serif;
        }
        body::before {
            content: ""; position: fixed; top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.7); backdrop-filter: blur(10px); z-index: -1;
        }
        .navbar { background-color: #28a745 !important; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .edit-card {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 20px;
            border: none;
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            padding: 30px;
            margin-top: 50px;
        }
        .btn-update { background-color: #28a745; color: white; font-weight: bold; border-radius: 10px; }
        .btn-update:hover { background-color: #218838; color: white; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="index.php">HAYVAN PAZARI</a>
        <div class="ms-auto">
            <a href="index.php" class="btn btn-outline-light btn-sm">← Vazgeç ve Dön</a>
        </div>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-7">
            <div class="card edit-card">
                <h3 class="text-center text-success fw-bold mb-4">İlan Bilgilerini Güncelle</h3>
                
                <form action="islem.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="ilan_id" value="<?php echo $ilan['id']; ?>">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Hayvan Türü</label>
                            <select name="tur" class="form-select border-success">
                                <option value="Dana" <?php if($ilan['tur']=="Dana") echo "selected"; ?>>Dana</option>
                                <option value="Koç" <?php if($ilan['tur']=="Koç") echo "selected"; ?>>Koç</option>
                                <option value="Düve" <?php if($ilan['tur']=="Düve") echo "selected"; ?>>Düve</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Cins / Irk</label>
                            <input type="text" name="cins" class="form-control border-success" value="<?php echo $ilan['cins']; ?>" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Fiyat (₺)</label>
                            <input type="number" name="fiyat" class="form-control border-success" value="<?php echo $ilan['fiyat']; ?>" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold">Kilo (KG)</label>
                            <input type="number" name="kilogram" class="form-control border-success" value="<?php echo $ilan['kilogram']; ?>" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold">Mevcut Fotoğraf</label><br>
                        <img src="uploads/<?php echo $ilan['fotograf']; ?>" class="rounded mb-2 shadow-sm" style="height: 100px; object-fit: cover;">
                        <input type="file" name="fotograf" class="form-control border-success">
                        <small class="text-muted">Değiştirmek istemiyorsanız yeni fotoğraf seçmeyin.</small>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-bold">Açıklama</label>
                        <textarea name="aciklama" class="form-control border-success" rows="3"><?php echo $ilan['aciklama']; ?></textarea>
                    </div>
<div class="row">
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Hayvanın Yaşı</label>
        <input type="text" name="yas" class="form-control border-success" placeholder="Örn: 2 Yaşında" value="<?php echo isset($ilan) ? $ilan['yas'] : ''; ?>" required>
    </div>
    <div class="col-md-6 mb-3">
        <label class="form-label fw-bold">Küpe Numarası</label>
        <input type="text" name="kupe_no" class="form-control border-success" placeholder="Örn: TR123456" value="<?php echo isset($ilan) ? $ilan['kupe_no'] : ''; ?>" required>
    </div>
</div>

                    <button type="submit" name="ilan_guncelle" class="btn btn-update w-100 py-2">DEĞİŞİKLİKLERİ KAYDET</button>
                </form>
            </div>
        </div>
    </div>
</div>

</body>
</html>