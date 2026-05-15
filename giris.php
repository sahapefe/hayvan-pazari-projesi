<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurban Pazarı - Giriş Yap</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Arka plan ayarları */
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow: hidden; /* Kayma çubuğunu engellemek için */
        }

        .bg-image {
            background-image: url('https://st5.depositphotos.com/2570463/68981/i/450/depositphotos_689813344-stock-photo-brown-cow-grazing-field-jersey.jpg'); 
            filter: blur(8px); 
            -webkit-filter: blur(8px);
            height: 100%;
            background-position: center;
            background-repeat: no-repeat;
            background-size: cover;
            position: fixed;
            width: 100%;
            z-index: -1;
            transform: scale(1.1); 
        }

        .login-container {
            display: flex;
            justify-content: flex-start; /* Kartı sola yaslamak için center yerine flex-start */
            align-items: center;
            height: 100vh;
            padding-left: 10%; /* Sol taraftan boşluk bırakarak ineğin yüzünü açtık */
        }

        .login-card {
            background: rgba(255, 255, 255, 0.15); 
            backdrop-filter: blur(10px); 
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 30px; /* Paddingi %10 azalttık (40px -> 30px) */
            width: 90%; /* Genişliği %10 azalttık */
            max-width: 360px; /* Max genişliği %10 azalttık (400px -> 360px) */
            box-shadow: 0 15px 35px rgba(0,0,0,0.2);
            color: white;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 10px; /* Input iç boşluğunu hafif daralttık */
            margin-bottom: 15px;
            color: #333;
        }

        .form-control:focus {
            background: #fff;
            box-shadow: 0 0 10px rgba(40, 167, 69, 0.5);
        }

        .btn-custom {
            background-color: #28a745; 
            border: none;
            border-radius: 10px;
            padding: 10px;
            font-weight: bold;
            color: white;
            transition: 0.3s;
        }

        .btn-custom:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .login-header {
            font-size: 1.5rem; /* Başlığı biraz küçülttük */
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            margin-bottom: 25px;
            text-align: center;
        }

        a { color: #fff; text-decoration: none; font-size: 0.85rem; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="bg-image"></div>

<div class="container-fluid login-container">
    <div class="login-card">
        <h2 class="login-header">KURBAN PAZARI</h2>
        
        <?php if(isset($_GET['durum'])): ?>
    <div style="text-align: center; margin-bottom: 20px;">
        <?php if($_GET['durum'] == 'hata'): ?>
            <div style="background: rgba(220, 53, 69, 0.9); color: white; padding: 12px; border-radius: 10px; font-size: 0.9rem;">
                ❌ E-posta veya şifre hatalı!
            </div>
        <?php elseif($_GET['durum'] == 'ok'): ?>
            <div style="background: rgba(40, 167, 69, 0.9); color: white; padding: 12px; border-radius: 10px; font-size: 0.9rem;">
                ✅ Kayıt başarılı! Giriş yapabilirsiniz.
            </div>
        <?php endif; ?>
    </div>
<?php endif; ?>
        <form action="islem.php" method="POST">
            <div class="mb-3">
                <label class="form-label" style="font-size: 0.9rem;">E-posta</label>
                <input type="email" name="eposta" class="form-control" placeholder="E-posta girin" required>
            </div>
            <div class="mb-3">
                <label class="form-label" style="font-size: 0.9rem;">Şifre</label>
                <input type="password" name="sifre" class="form-control" placeholder="Şifre girin" required>
            </div>
            
            <button type="submit" name="giris_yap" class="btn btn-custom w-100 mt-2">GİRİŞ YAP</button>
            
            <div class="mt-4 text-center">
                <p class="mb-1" style="font-size: 0.85rem;">Hesabın yok mu?</p>
                <a href="kayit.php" style="font-weight: 600;">Hemen Satıcı veya Alıcı Ol</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>