<?php 
session_start();
// Giriş yapmayan ilan veremesin (PDF Gereksinimi: Kullanıcı Rolü Kontrolü)
if (!isset($_SESSION['user_id'])) { header("Location: giris.php"); exit; }
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İlan Ver - Hayvan Pazarı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body style="background: #f4f7f6;">

<div class="container mt-5">
    
    <?php if(isset($_GET['durum']) && $_GET['durum'] == "mukerrer_kupe"): ?>
        <div class="alert alert-danger border-0 shadow-sm rounded-4 mb-4 mx-auto" style="max-width: 600px;">
            <div class="d-flex align-items-center">
                <div class="fs-2 me-3">⚠️</div>
                <div>
                    <h5 class="alert-heading fw-bold mb-1">Hatalı Küpe Numarası!</h5>
                    <p class="mb-0 small">Bu küpe numarası ile daha önce sistemde ilan oluşturulmuş. Lütfen numarayı kontrol edip tekrar deneyin.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <div class="card shadow p-4" style="max-width: 600px; margin: auto; border-radius: 20px;">
        <div class="d-flex justify-content-between align-items-center mb-4">
             <h3 class="text-success fw-bold m-0">Kurbanlık İlanı Oluştur</h3>
             <a href="index.php" class="btn btn-sm btn-outline-secondary">Geri Dön</a>
        </div>
        
        <form action="islem.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label class="fw-bold">Hayvan Türü</label>
                <select name="tur" class="form-select" required>
                    <option value="Dana">Dana</option>
                    <option value="Koç">Koç</option>
                    <option value="Düve">Düve</option>
                </select>
            </div>
            
            <div class="mb-3">
                <label class="fw-bold">Cins / Irk</label>
                <input type="text" name="cins" class="form-control" placeholder="Örn: Holstein, Yerli" required>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Hayvanın Yaşı</label>
                    <input type="text" name="yas" class="form-control border-success" placeholder="Örn: 2 Yaşında" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold">Küpe Numarası</label>
                    <input type="text" name="kupe_no" class="form-control border-success" placeholder="Örn: TR123456" required>
                </div>
            </div>

            <div class="row">
                <div class="col-6 mb-3">
                    <label class="fw-bold">Kilo (KG)</label>
                    <input type="number" name="kilogram" class="form-control" required>
                </div>
                <div class="col-6 mb-3">
                    <label class="fw-bold">Fiyat (TL)</label>
                    <input type="number" name="fiyat" class="form-control" required>
                </div>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Şehir</label>
                <input type="text" name="sehir" class="form-control" placeholder="Örn: Erzurum" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Telefon Numarası</label>
                <input type="text" name="telefon" class="form-control" placeholder="05XX XXX XX XX" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">İlan Fotoğrafı</label>
                <input type="file" name="fotograf" class="form-control" accept="image/*" required>
            </div>

            <div class="mb-3">
                <label class="fw-bold">Açıklama</label>
                <textarea name="aciklama" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" name="ilan_ekle" class="btn btn-success w-100 fw-bold py-2 shadow-sm">İlanı Yayınla</button>
        </form>
    </div>
</div>
</body>
</html>