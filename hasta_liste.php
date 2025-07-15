<html>
    <style>
        /* Stil dosyası (style.css gibi) */
.styled-table {
    width: 100%;
    border-collapse: collapse;
    border: 1px solid #ddd;
}

.styled-table th, .styled-table td {
    padding: 8px;
    border: 1px solid #ddd;
    background-color:	#FFFFFF; 
}

.styled-table th {
    background-color: #f2f2f2;
}

.styled-table tbody tr:nth-child(even) {
    background-color:	#FFFFFF;
}

.styled-table tbody tr:hover {
    background-color: 	#708090;
}
h2{
    color:#ffff;
}
.table-container {
    overflow-x: auto;
}
body {
            font-family: Arial, sans-serif;
            background-image: url('kan.jpg');
            margin: 0;
            padding: 0;
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
         <body>
    <!-- Buton ve form burada yer alacak -->
    <a href="index.php" class="btn" style="position: absolute; top: 10px; right: 10px;">Anasayfa</a>
</body>
</html>

<?php
include 'db_config.php';

// Veritabanından donörleri seçme
$sql = "SELECT * FROM hasta";
$result = $conn->query($sql);

// Donörleri ekrana yazdırma
if ($result->rowCount() > 0) {
    echo "<h2>HASTA LİSTESİ</h2>";
    echo "<div class='table-container'>";
    echo "<table class='styled-table'>";
    echo "<thead><tr><th>Ad Soyad</th><th>Yaş</th><th>Cinsiyet</th><th>İletişim</th><th>Kan Grubu</th></thead>";
    echo "<tbody>";
    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr>";
        echo "<td>" . $row['ad'] . "</td>";
        echo "<td>" . $row['yas'] . "</td>";
        echo "<td>" . $row['cinsiyet'] . "</td>";
        echo "<td>" . $row['iletisim'] . "</td>";
        echo "<td>" . $row['kan_grubu'] . "</td>";
       
        echo "</tr>";
    }
    echo "</tbody>";
    echo "</table>";
    echo "</div>";
} else {
    echo "<p>Kayıtlı hasta  bulunamadı.</p>";
}

// Veritabanı bağlantısını kapat
$conn = null;
?>
