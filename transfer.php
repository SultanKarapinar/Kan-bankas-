<?php
include 'db_config.php';

// Donorler ve hastaları veritabanından al
$sqlDonor = "SELECT * FROM donor";
$sqlHasta = "SELECT * FROM hasta";

try {
    $stmtDonor = $conn->query($sqlDonor);
    $stmtHasta = $conn->query($sqlHasta);
    $hastalar = $stmtHasta->fetchAll(PDO::FETCH_ASSOC);

    // Donorler ve hastalar arasında kan grubu eşleştirmesi yap
    $eslesmeler = [];
    while ($donor = $stmtDonor->fetch(PDO::FETCH_ASSOC)) {
        foreach ($hastalar as $hasta) {
            if ($donor['kan_grubu'] === $hasta['kan_grubu']) {
                $eslesmeler[] = [
                    'donor' => $donor['ad'],
                    'hasta' => $hasta['ad'],
                    'kan_grubu' => $donor['kan_grubu']
                ];
                break; // Eşleşme bulundu, iç döngüyü kır
            }
        }
    }
} catch (PDOException $e) {
    echo "Veritabanı hatası: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eşleşen Hasta-Donor Çiftleri</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #c0c0c0;
        }

        .container {
            padding: 20px;
        }

        .matching-list {
            list-style-type: none;
            padding: 0;
        }

        .matching-item {
            margin-bottom: 20px;
            padding: 20px;
            border-radius: 8px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .donor {
            font-weight: bold;
            color: #007bff;
        }

        .hasta {
            font-weight: bold;
            color: #dc3545;
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
<!-- Buton ve form burada yer alacak -->
<a href="index.php" class="btn" style="position: absolute; top: 10px; right: 10px;">Anasayfa</a>

<div class="container">
    <h2>Eşleşen Hasta-Donor Çiftleri</h2>
    <ul class="matching-list">
        <?php foreach ($eslesmeler as $eslesme): ?>
            <li class="matching-item">
                <span class="donor"><?php echo $eslesme['donor']; ?></span> donörü ile
                <span class="hasta"><?php echo $eslesme['hasta']; ?></span> hastası eşleşti.<br> Kan Grubu: <?php echo $eslesme['kan_grubu']; ?>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
</body>
</html>
