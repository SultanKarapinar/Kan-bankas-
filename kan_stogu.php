<?php
include 'db_config.php';

// Kan stoku bilgilerini veritabanından al
$sql = "SELECT * FROM kan_stok";
$result = $conn->query($sql);

$kanStoku = array(); // Kan stoku bilgilerini saklamak için bir dizi oluştur

// Veritabanı sorgusu başarılıysa
if ($result) {
    // Tüm satırları dizi olarak al
    $rows = $result->fetchAll(PDO::FETCH_ASSOC);

    // Her bir satır için kan grubu ve miktarı diziye ekle
    foreach ($rows as $row) {
        $kanStoku[] = $row;
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
    <title>Kan Stokları</title>
    <link rel="stylesheet" href="/kan_bankasi/content/css/bootstrap.min.css" />
    <style>
        body {
            background-image: url('indir.jpg');
            background-size: cover;
            font-family: Arial, sans-serif;
            color: #333;
        }
        h2 {
            color: #fff;
            text-align: center;
            margin-top: 20px;
        }
        table {
            margin: 20px auto;
            border-collapse: collapse;
            width: 80%;
            background-color: #fff;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
            color: #333;
        }
        .low-stock {
            background-color: #f8d7da;
        }
        .btn {
            background-color: white;
            color: black;
            padding: 10px 20px;
            border: 1px solid black;
            border-radius: 5px;
            text-decoration: none;
        }
        .btn:hover {
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <h2>Kan Stokları</h2>
    <table>
        <thead>
            <tr>
                <th>KAN GRUBU</th>
                <th>MİKTAR (ÜNİTE) </th>
            </tr>
        </thead>
        <tbody>
             <!-- Buton ve form burada yer alacak -->
           <a href="index.php" class="btn" style="position: absolute; top: 10px; right: 10px;">Anasayfa</a>
            <?php
            $uyariMiktari = 5; // Uyarı vermek için belirlenen minimum stok miktarı

            foreach ($kanStoku as $stok) {
                $kanGrubu = $stok['kan_grubu'];
                $miktar = $stok['miktar'];
                $rowClass = ($miktar < $uyariMiktari) ? 'low-stock' : '';
                echo "<tr class='$rowClass'>";
                echo "<td>$kanGrubu</td>";
                echo "<td>$miktar</td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
    <script>
        // uyarı mesajı
        document.addEventListener('DOMContentLoaded', function() {
            const lowStockRows = document.querySelectorAll('.low-stock');
            if (lowStockRows.length > 0) {
                alert('Bazı kan gruplarının stokları kritik seviyenin altında!');
            }
        });
    </script>
</body>
</html>
