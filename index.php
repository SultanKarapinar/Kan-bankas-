

<?php include "header.php"; ?>

<?php
include 'db_config.php';

// Veritabanından kan stoku bilgilerini al
$sql = "SELECT * FROM kan_stok";
$result = $conn->query($sql);

$kanStoku = array(); // Kan stoku bilgilerini saklamak için bir dizi oluştur

// Veritabanı sorgusu başarılıysa
if ($result) {
    // Tüm satırları dizi olarak al
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    // Her bir satır için kan grubu ve miktarı diziye ekle
    foreach ($rows as $row) {
        $kanGrubu = $row['kan_grubu'];
        $miktar = $row['miktar'];
        $kanStoku[$kanGrubu] = $miktar;
    }
}

// Veritabanı bağlantısını kapat
$conn = null;
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kan Bankası Yönetim Sistemi</title>
    <!-- Bootstrap CSS dosyası -->
    <link rel="stylesheet" href="/kan_bankasi/content/css/bootstrap.min.css" />
    <link rel="stylesheet" href="/kan_bankasi/content/css/style.css" />
    <style>
        body {
            background-color: #6f0000;
            
            background-size: cover;
        }
        h3, h2, h5 {
            color: #fff;
            text-align: center;
        }
        .list-group-item {
            transition: background-color 0.3s ease;
            list-style-type: none;
            border-bottom: none; /* Alt çizgiyi kaldırır */
            margin-bottom: 50px; /* İstenilen boşluğu ayarlar */
            color: #ffff;
        }
        
        .list-group-item:hover {
            background-color: #FFFF;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
        }

        .col-md-3 {
            max-width: 300px;
            background-color: #CFDEF3;
            padding: 20px;
            border-radius: 5px;
            margin-right: 20px;
        }

        .col-md-9 {
            flex: 1;
            max-width: 800px;
            margin-right: 20px;
        }

        /* Dairesel ilerleme çubuğu stilleri */
        .progress-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            background: conic-gradient(#1E90FF calc(var(--value) * 1%), #D3D3D3 0%);
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            margin: 30px; /* Kartlar arasında boşluk */
            background-color: red; /* Dairenin arka rengini kırmızı yap */
            color: #000;
        }
        .progress-circle::before {
            content: attr(data-value) '%';
            position: absolute;
            bottom: -20px; /* Yüzdelik değeri dairenin altına taşı */
            font-size: 16px;
            color: #ffff;
        }

        .progress-container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <!-- Yan Menü -->
        <div class="col-md-3">
            <h3>İşlemler</h3>
            <ul class="list-group">
                <li class="list-group-item"><a href="donor_kayit.php">DONOR KAYIT</a></li>
                <li class="list-group-item"><a href="donor_listesi.php">DONORLERİ LİSTELE</a></li>
                <li class="list-group-item"><a href="hasta_kayit.php">HASTA KAYIT</a></li>
                <li class="list-group-item"><a href="hasta_liste.php">HASTALARI LİSTELE</a></li>
                <li class="list-group-item"><a href="transfer.php">KAN TRANSFERİ</a></li>
                <li class="list-group-item"><a href="kan_stogu.php">KAN STOĞU</a></li>
                <li class="list-group-item"><a href="cikis.php">ÇIKIŞ</a></li>
                <!-- Diğer sayfalar buraya eklenebilir -->
            </ul>
        </div>
        <!-- Kan Stoku ve Butonlar -->
        <div class="col-md-9">
            <h3>Kan Stoku</h3>
            <div class="progress-container">
                <?php
                // Kan stoku bilgilerini dairesel ilerleme çubuğu olarak göster
                foreach ($kanStoku as $kanGrubu => $miktar) {
                    $maxMiktar = 100; // Maksimum stok miktarı (örnek olarak 100 alındı)
                    $percent = ($miktar / $maxMiktar) * 100;
                    echo "<div class='progress-circle' style='--value:$percent' data-value='".round($percent)."'>";
                    echo "<span>$kanGrubu</span>";
                    echo "</div>";
                }
                ?>
            </div>
        </div>
    </div>
    <!-- Bootstrap JS dosyaları -->
    <script src="/kan_bankasi/content/js/bootstrap.bundle.min.js"></script>
</body>
</html>
