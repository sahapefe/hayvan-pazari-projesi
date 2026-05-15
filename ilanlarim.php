<?php 
session_start(); include 'baglan.php';
if (!isset($_SESSION['user_id'])) { header("Location: giris.php"); exit; }
$user_id = $_SESSION['user_id'];
$rol = $_SESSION['rol'];

// Admin ise tüm ilanları, değilse sadece kendi ilanlarını görsün
$sql = ($rol == 'admin') ? "SELECT * FROM kurbanliklar" : "SELECT * FROM kurbanliklar WHERE satici_id = '$user_id'";
$sorgu = mysqli_query($baglanti, $sql);
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>İlanlarım</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-5">
    <div class="d-flex justify-content-between mb-3">
        <h2><?php echo ($rol == 'admin') ? "Tüm İlanlar (Yönetici)" : "İlanlarım"; ?></h2>
        <a href="index.php" class="btn btn-secondary">Geri Dön</a>
    </div>
    <table class="table table-white table-striped shadow-sm rounded">
        <thead>
            <tr>
                <th>Resim</th><th>Tür</th><th>Fiyat</th><th>İşlem</th>
            </tr>
        </thead>
        <tbody>
            <?php while($ilan = mysqli_fetch_assoc($sorgu)): ?>
            <tr>
                <td><img src="uploads/<?php echo $ilan['fotograf']; ?>" width="50"></td>
                <td><?php echo $ilan['cins']; ?></td>
                <td><?php echo number_format($ilan['fiyat'], 0, ',', '.'); ?> ₺</td>
                <td>
                    <a href="ilan_duzenle.php?id=<?php echo $ilan['id']; ?>" class="btn btn-warning btn-sm">Düzenle</a>
                    <a href="islem.php?sil_id=<?php echo $ilan['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Silinsin mi?')">Sil</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>
</body>
</html>