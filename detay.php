<?php 
session_start();
include 'baglan.php';

// Linkten gelen ID'yi alıp o hayvanın bilgilerini çekiyoruz
if(isset($_GET['id'])) {
    $id = mysqli_real_escape_string($baglanti, $_GET['id']);
    $sorgu = mysqli_query($baglanti, "SELECT kurbanliklar.*, kullanicilar.ad_soyad 
    FROM kurbanliklar 
    INNER JOIN kullanicilar ON kurbanliklar.satici_id = kullanicilar.id 
    WHERE kurbanliklar.id = '$id'");
    $ilan = mysqli_fetch_assoc($sorgu);
    
    if(!$ilan) { header("Location: index.php"); exit; }

    // HESAPLAMA MANTIĞI (Özgün Özellik)
    $fiyat = $ilan['fiyat'];
    $kilo = $ilan['kilogram'];
    // Büyükbaş ise 7 hisse, küçükbaş ise 1 hisse varsayalım
    $hisse_sayisi = ($ilan['tur'] == 'Dana' || $ilan['tur'] == 'Düve') ? 7 : 1;
    $hisse_basi_fiyat = $fiyat / $hisse_sayisi;
    $tahmini_et = $kilo * 0.45; // Canlı kilodan %45 et verimi (Genel kabul)
    $hisse_basi_et = $tahmini_et / $hisse_sayisi;
} else {
    header("Location: index.php"); exit;
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title><?php echo $ilan['cins']; ?> - İlan Detayı</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.css" />
    <style>
        body {
            background-image: url('https://i.yenicaggazetesi.com/storage/old/d/other/2025/05/18/askalede-kurban-pazari-acildi-fiyatlar-cep-yakiyor-350-bin-tlye-buyukbas-yenicag-3.jpg');
            background-attachment: fixed; background-size: cover; min-height: 100vh;
        }
        .overlay { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(8px); min-height: 100vh; padding: 40px 0; }
        .detail-card { border-radius: 20px; border: none; overflow: hidden; background: white; }
        .calc-box { background: #f1f8f5; border-left: 6px solid #28a745; border-radius: 12px; padding: 20px; }
    </style>
</head>
<body>
<div class="overlay">
    <div class="container">
        <a href="index.php" class="btn btn-success mb-3">← İlanlara Dön</a>
        <div class="card detail-card shadow-lg">
            <div class="row g-0">
                <div class="col-md-6">
                    <a href="uploads/<?php echo $ilan['fotograf']; ?>" data-fancybox="gallery" data-caption="<?php echo $ilan['cins']; ?>">
        <img src="uploads/<?php echo $ilan['fotograf']; ?>" class="img-fluid h-100 w-100" style="object-fit: cover; min-height: 400px; cursor: zoom-in;">
    </a>
                </div>
                <div class="col-md-6 p-4">
                    <h2 class="fw-bold text-success mb-3"><?php echo $ilan['tur'] . " - " . $ilan['cins']; ?></h2>
                    <h1 class="display-5 fw-bold text-dark mb-4"><?php echo number_format($fiyat, 0, ',', '.'); ?> ₺</h1>
                    
                    <div class="mb-4">
                        <p class="mb-1">📍 <b>Konum:</b> <?php echo $ilan['sehir']; ?></p>
                        <p class="mb-1">⚖️ <b>Canlı Ağırlık:</b> <?php echo $kilo; ?> KG</p>
                        <p class="mb-1">👤 <b>İlan Sahibi:</b> <?php echo $ilan['ad_soyad']; ?></p>
                        <p class="mb-1">📞 <b>Satıcı Tel:</b> <a href="tel:<?php echo $ilan['telefon']; ?>" class="text-decoration-none fw-bold"><?php echo $ilan['telefon']; ?></a></p>
                        <p class="mb-1">🆔 <b>Küpe No:</b> <?php echo $ilan['kupe_no']; ?></p>
                        <p class="mb-1">📅 <b>Yaş:</b> <?php echo $ilan['yas']; ?></p>

                    </div>
                    <div class="calc-box shadow-sm mb-4">
                        <h5 class="fw-bold text-success mb-3">Bayramlık Hesap Cetveli</h5>
                        <div class="row">
                            <div class="col-6 border-end">
                                <small class="text-muted d-block">Hisse Başı (<?php echo $hisse_sayisi; ?> Kişi)</small>
                                <span class="fs-4 fw-bold text-dark"><?php echo number_format($hisse_basi_fiyat, 0, ',', '.'); ?> ₺</span>
                            </div>
                            <div class="col-6">
                                <small class="text-muted d-block">Kişi Başı Tahmini Et</small>
                                <span class="fs-4 fw-bold text-dark">~<?php echo round($hisse_basi_et, 1); ?> KG</span>
                            </div>
                        </div>
                    </div>

                    <p class="text-muted italic"><b>İlan Açıklaması:</b><br><?php echo $ilan['aciklama']; ?></p>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui@5.0/dist/fancybox/fancybox.umd.js"></script>
    <script>
        Fancybox.bind("[data-fancybox]", {
            // Ayarlar buraya gelebilir
        });
    </script>
</body>
</html>