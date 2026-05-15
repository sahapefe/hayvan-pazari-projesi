<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kurban Pazarı - Kayıt Ol</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        .bg-image {
            background-image: url('https://images.pexels.com/photos/29023699/pexels-photo-29023699.jpeg?_gl=1*1tg3u1t*_ga*MTM0NDgzODkyNi4xNzc4MjQ4MDY3*_ga_8JE65Q40S6*czE3NzgyNDgwNjYkbzEkZzAkdDE3NzgyNDgwNjYkajYwJGwwJGgw'); 
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

        .register-container {
            display: flex;
            justify-content: flex-end; 
            align-items: center;
            height: 100vh;
            padding-right: 10%; 
        }

        .register-card {
            background: rgba(255, 255, 255, 0.15); 
            backdrop-filter: blur(12px); 
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 20px;
            padding: 30px;
            width: 95%;
            max-width: 360px; /* Giriş sayfasındakiyle aynı boyuta çektim */
            box-shadow: 0 15px 35px rgba(0,0,0,0.3);
            color: white;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.9);
            border: none;
            border-radius: 10px;
            padding: 10px;
            margin-bottom: 15px;
            color: #333;
        }

        .btn-custom {
            background-color: #28a745; 
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-weight: bold;
            color: white;
            transition: 0.3s;
            margin-top: 10px;
        }

        .btn-custom:hover {
            background-color: #218838;
            transform: translateY(-2px);
        }

        .register-header {
            font-size: 1.5rem;
            font-weight: 800;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.5);
            margin-bottom: 25px;
            text-align: center;
        }

        label { font-size: 0.9rem; margin-bottom: 5px; display: block; }
        a { color: #fff; text-decoration: none; font-size: 0.85rem; font-weight: 600; }
        a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="bg-image"></div>

<div class="container-fluid register-container">
    <div class="register-card">
        <h2 class="register-header">Hemen Katıl</h2>
        
        <form action="islem.php" method="POST">
            <div class="mb-3">
                <label>Ad Soyad</label>
                <input type="text" name="ad_soyad" class="form-control" placeholder="Adınızı yazın" required>
            </div>
            <div class="mb-3">
                <label>E-posta</label>
                <input type="email" name="eposta" class="form-control" placeholder="E-posta adresiniz" required>
            </div>
            <div class="mb-3">
                <label>Şifre</label>
                <input type="password" name="sifre" class="form-control" placeholder="Şifreniz" required>
            </div>
            
            <input type="hidden" name="rol" value="user">
            
            <button type="submit" name="kayit_ol" class="btn btn-custom w-100">KAYIT OL</button>
            
            <div class="mt-4 text-center">
                <a href="giris.php">Zaten hesabın var mı? Giriş Yap</a>
            </div>
        </form>
    </div>
</div>

</body>
</html>