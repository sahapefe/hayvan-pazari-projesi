<?php 
session_start();
include 'baglan.php'; 

// --- İSTATİSTİK SORGULARI ---
$istatistik_sorgu = mysqli_query($baglanti, "SELECT 
    COUNT(*) as toplam_ilan, 
    AVG(fiyat) as ortalama_fiyat, 
    MIN(fiyat) as en_ucuz,
    SUM(kilogram) as toplam_tonaj 
    FROM kurbanliklar WHERE satildi_mi = 0");
$stats = mysqli_fetch_assoc($istatistik_sorgu);

$sehir_en_cok = mysqli_query($baglanti, "SELECT sehir, COUNT(*) as adet FROM kurbanliklar GROUP BY sehir ORDER BY adet DESC LIMIT 1");
$en_cok_sehir = mysqli_fetch_assoc($sehir_en_cok);

// --- BÖLGESEL KG/FİYAT ANALİZİ SORGUSU ---
$bolge_analiz_sorgu = mysqli_query($baglanti, "SELECT sehir, 
    AVG(fiyat / kilogram) as kg_ortalama_fiyat,
    COUNT(*) as ilan_sayisi
    FROM kurbanliklar 
    WHERE satildi_mi = 0 
    GROUP BY sehir 
    ORDER BY kg_ortalama_fiyat ASC");
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hayvan Pazarı - Kurbanlık İlanları</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-image: url('https://i.yenicaggazetesi.com/storage/old/d/other/2025/05/18/askalede-kurban-pazari-acildi-fiyatlar-cep-yakiyor-350-bin-tlye-buyukbas-yenicag-3.jpg');
            background-attachment: fixed;
            background-size: cover;
            background-position: center;
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }

        body::before {
            content: "";
            position: fixed;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(255, 255, 255, 0.8); 
            backdrop-filter: blur(8px); 
            z-index: -1;
        }

        .navbar { 
            background-color: #28a745 !important; 
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }

        .ilan-card { 
            transition: 0.3s; 
            border: none; 
            border-radius: 15px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(5px);
            overflow: hidden;
        }

        .ilan-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 15px 30px rgba(0,0,0,0.2); 
        }

        .price-tag { 
            color: #28a745; 
            font-weight: 800; 
            font-size: 1.3rem; 
        }

        .filter-header {
            background: rgba(255, 255, 255, 0.9);
            border-radius: 15px;
            padding: 20px;
            margin-bottom: 30px;
            border-bottom: 4px solid #28a745;
        }

        .stats-card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.05);
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold fs-3" href="index.php">HAYVAN PAZARI</a>
        <div class="ms-auto d-flex align-items-center">
            <?php if(isset($_SESSION['ad_soyad'])): ?>
                <span class="text-white me-3 d-none d-md-block">Hoş geldin, <b><?php echo $_SESSION['ad_soyad']; ?></b></span>
                <a href="ilanlarim.php" class="btn btn-outline-light btn-sm me-2">İlanlarım</a>
                <a href="ilan_ver.php" class="btn btn-warning fw-bold btn-sm me-2 shadow-sm">Ücretsiz İlan Ver</a>
                <a href="cikis.php" class="btn btn-outline-light btn-sm">Çıkış Yap</a>
            <?php else: ?>
                <a href="giris.php" class="btn btn-light btn-sm fw-bold px-3">Giriş Yap / Üye Ol</a>
            <?php endif; ?>
        </div>
    </div>
</nav>

<div class="container mt-4">
    <div class="row mb-4 text-center">
        <div class="col-md-3 mb-2">
            <div class="stats-card p-3">
                <small class="text-muted d-block">Toplam İlan</small>
                <span class="fw-bold fs-4 text-success"><?php echo $stats['toplam_ilan']; ?></span>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="stats-card p-3">
                <small class="text-muted d-block">Ortalama Fiyat</small>
                <span class="fw-bold fs-4 text-primary"><?php echo number_format($stats['ortalama_fiyat'] ?? 0, 0, ',', '.'); ?> ₺</span>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="stats-card p-3">
                <small class="text-muted d-block">En Çok İlan</small>
                <span class="fw-bold fs-4 text-danger"><?php echo ($en_cok_sehir['sehir'] ?? '-'); ?></span>
            </div>
        </div>
        <div class="col-md-3 mb-2">
            <div class="stats-card p-3">
                <small class="text-muted d-block">Toplam Tonaj</small>
                <span class="fw-bold fs-4 text-warning"><?php echo number_format(($stats['toplam_tonaj'] ?? 0) / 1000, 1); ?> Ton</span>
            </div>
        </div>
    </div>

    <div class="filter-header shadow-sm">
        <form action="index.php" method="GET" class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label small fw-bold text-success">Kurbanlık Türü</label>
                <select name="tur" class="form-select border-success">
                    <option value="">Tüm Kurbanlıklar</option>
                    <option value="Dana" <?php echo (@$_GET['tur'] == 'Dana') ? 'selected' : ''; ?>>Dana</option>
                    <option value="Koç" <?php echo (@$_GET['tur'] == 'Koç') ? 'selected' : ''; ?>>Koç</option>
                    <option value="Düve" <?php echo (@$_GET['tur'] == 'Düve') ? 'selected' : ''; ?>>Düve</option>
                </select>
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-success">Şehir Ara</label>
                <input type="text" name="sehir" class="form-control border-success" placeholder="Örn: Erzurum" value="<?php echo @$_GET['sehir']; ?>">
            </div>
            <div class="col-md-3">
                <label class="form-label small fw-bold text-success">Fiyat Sıralaması</label>
                <select name="sirala" class="form-select border-success">
                    <option value="yeni" <?php echo (@$_GET['sirala'] == 'yeni') ? 'selected' : ''; ?>>En Yeni İlanlar</option>
                    <option value="ucuz" <?php echo (@$_GET['sirala'] == 'ucuz') ? 'selected' : ''; ?>>Fiyat: Düşükten Yükseğe</option>
                    <option value="pahali" <?php echo (@$_GET['sirala'] == 'pahali') ? 'selected' : ''; ?>>Fiyat: Yüksekten Düşüğe</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-success w-100 fw-bold py-2 shadow-sm">FİLTRELE VE SIRALA</button>
            </div>
        </form>
    </div>

    <div class="row mb-5 justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm border-0 rounded-4 p-4" style="background: rgba(255, 255, 255, 0.95); backdrop-filter: blur(10px); border-left: 5px solid #28a745 !important;">
                <h4 class="fw-bold text-success mb-3">📈 Bölgesel KG/Fiyat Analizi</h4>
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="text-muted small text-uppercase">
                            <tr>
                                <th>Şehir</th>
                                <th>İlan Sayısı</th>
                                <th>Ort. KG Fiyatı</th>
                                <th class="text-end">Piyasa Durumu</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($analiz = mysqli_fetch_assoc($bolge_analiz_sorgu)): 
                                $kg_fiyat = $analiz['kg_ortalama_fiyat'];
                            ?>
                            <tr>
                                <td class="fw-bold text-dark"><?php echo $analiz['sehir']; ?></td>
                                <td><span class="badge bg-light text-dark border rounded-pill px-3"><?php echo $analiz['ilan_sayisi']; ?> İlan</span></td>
                                <td class="fw-bold text-success"><?php echo number_format($kg_fiyat, 2, ',', '.'); ?> ₺ / KG</td>
                                <td class="text-end">
                                    <?php if($kg_fiyat < 250): ?>
                                        <span class="badge bg-success shadow-sm">🔥 Fırsat Bölgesi</span>
                                    <?php elseif($kg_fiyat > 450): ?>
                                        <span class="badge bg-danger shadow-sm">📈 Yüksek Fiyat</span>
                                    <?php else: ?>
                                        <span class="badge bg-primary shadow-sm">✅ Normal Piyasa</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <?php
        $sorgu_cumlesi = "SELECT * FROM kurbanliklar WHERE satildi_mi = 0";
        
        if(!empty($_GET['tur'])) {
            $tur = mysqli_real_escape_string($baglanti, $_GET['tur']);
            $sorgu_cumlesi .= " AND tur = '$tur'";
        }
        if(!empty($_GET['sehir'])) {
            $sehir = mysqli_real_escape_string($baglanti, $_GET['sehir']);
            $sorgu_cumlesi .= " AND sehir LIKE '%$sehir%'";
        }

        // --- SQL SIRALAMA MANTIGI ---
        $sirala = $_GET['sirala'] ?? 'yeni';
        switch ($sirala) {
            case 'ucuz':
                $sorgu_cumlesi .= " ORDER BY fiyat ASC";
                break;
            case 'pahali':
                $sorgu_cumlesi .= " ORDER BY fiyat DESC";
                break;
            default:
                $sorgu_cumlesi .= " ORDER BY id DESC";
                break;
        }
        
        $ilanlar = mysqli_query($baglanti, $sorgu_cumlesi);

        if(mysqli_num_rows($ilanlar) > 0) {
            while($ilan = mysqli_fetch_assoc($ilanlar)):
        ?>
        <div class="col-lg-3 col-md-4 col-sm-6 mb-4">
            <div class="card ilan-card h-100 shadow-sm">
                <div style="height: 200px; overflow: hidden; position: relative;">
                    <?php if(!empty($ilan['fotograf']) && $ilan['fotograf'] != 'default.jpg'): ?>
                        <img src="uploads/<?php echo $ilan['fotograf']; ?>" class="w-100 h-100" style="object-fit: cover;">
                    <?php else: ?>
                        <div class="bg-secondary text-white d-flex align-items-center justify-content-center h-100">
                            <span>Görsel Yok</span>
                        </div>
                    <?php endif; ?>

                    <?php if(isset($_SESSION['user_id']) && ($_SESSION['rol'] == 'admin' || $_SESSION['user_id'] == $ilan['satici_id'])): ?>
                    <div style="position: absolute; top: 5px; right: 5px;">
                        <a href="ilan_duzenle.php?id=<?php echo $ilan['id']; ?>" class="btn btn-warning btn-sm p-1" title="Düzenle">✏️</a>
                        <a href="islem.php?sil_id=<?php echo $ilan['id']; ?>" class="btn btn-danger btn-sm p-1" onclick="return confirm('Silmek istiyor musun?')" title="Sil">🗑️</a>
                    </div>
                    <?php endif; ?>
                </div>
                
                <div class="card-body d-flex flex-column">
                    <div class="d-flex justify-content-between">
                        <small class="text-success fw-bold"><?php echo $ilan['tur']; ?></small>
                        <small class="text-muted"><?php echo $ilan['sehir']; ?></small>
                    </div>
                    <h5 class="card-title fw-bold text-dark mt-1"><?php echo $ilan['cins']; ?></h5>
                    <p class="mb-2 small text-muted">Ağırlık: <b><?php echo $ilan['kilogram']; ?> KG</b></p>
                    <div class="mt-auto">
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <span class="price-tag"><?php echo number_format($ilan['fiyat'], 0, ',', '.'); ?> ₺</span>
                            <a href="detay.php?id=<?php echo $ilan['id']; ?>" class="btn btn-sm btn-success rounded-pill px-3">İncele</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php 
            endwhile; 
        } else {
            echo '<div class="col-12 text-center py-5 bg-white rounded-4 shadow-sm">
                    <h4 class="text-muted">Aradığınız kriterlerde henüz ilan eklenmemiş.</h4>
                  </div>';
        }
        ?>
    </div>
</div>

</body>
</html>