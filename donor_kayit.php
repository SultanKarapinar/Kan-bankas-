<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $ad = $_POST['ad'];
    $yas = $_POST['yas'];
    $cinsiyet = $_POST['cinsiyet'];
    $iletisim = $_POST['iletisim'];
    $kan_grubu = $_POST['kan_grubu'];
    $adres = $_POST['adres'];
    $email = $_POST['email'];

    try {
        // Veritabanı işlemleri için PDO'nun hata modunu ayarla
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Veritabanına kayıt ekleme
        $sql = "INSERT INTO donor (ad, yas, cinsiyet, iletisim, kan_grubu, adres, email) VALUES (:ad, :yas, :cinsiyet, :iletisim, :kan_grubu, :adres, :email)";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':ad', $ad);
        $stmt->bindParam(':yas', $yas);
        $stmt->bindParam(':cinsiyet', $cinsiyet);
        $stmt->bindParam(':iletisim', $iletisim);
        $stmt->bindParam(':kan_grubu', $kan_grubu);
        $stmt->bindParam(':adres', $adres);
        $stmt->bindParam(':email', $email);

        if ($stmt->execute()) {
            // Donör başarıyla kaydedildikten sonra kan stoklarını güncelle
            $updateSql = "UPDATE kan_stok SET miktar = miktar + 1 WHERE kan_grubu = :kan_grubu";
            $updateStmt = $conn->prepare($updateSql);
            $updateStmt->bindParam(':kan_grubu', $kan_grubu);
            $updateStmt->execute();

            // Donör başarıyla kaydedildi ve kan stoku güncellendi
            header("Location: donor_listesi.php");
            exit;
        } else {
            echo "Donör kaydedilirken bir hata oluştu.";
        }
    } catch (PDOException $e) {
        echo "Veritabanı hatası: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donör Kayıt</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('liste.webp'); 
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 500px;
            margin: 50px auto;
            background-color: #999999;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            border: none;
            border-radius: 5px;
            background-color: #007bff;
            color: #fff;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #0056b3;
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
    <a href="index.php"class="btn" style="position: absolute; top: 10px; right: 10px;">Anasayfa</a>

    <div class="container">
        <h2>Donör Kayıt</h2>
        <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
            <label for="name">Ad Soyad:</label>
            <input type="text" id="name" name="ad" required>

            <label for="age">Yaş:</label>
            <input type="number" id="age" name="yas" required>

            <label for="gender">Cinsiyet:</label>
            <select id="gender" name="cinsiyet" required>
                <option value="">Seçiniz</option>
                <option value="Erkek">Erkek</option>
                <option value="Kadın">Kadın</option>
            </select>

            <label for="phone">Telefon Numarası:</label>
            <input type="tel" id="phone" name="iletisim" class="form-control" required pattern="\d{11}" maxlength="11" title="Telefon numarası 11 basamaklı olmalıdır.">

            <label for="blood_group">Kan Grubu:</label>
            <select id="blood_group" name="kan_grubu" required>
                <option value="">Seçiniz</option>
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>

            <label for="address">Adres:</label>
            <textarea id="address" name="adres" rows="4" required></textarea>

            <label for="email">E-posta:</label>
            <input type="email" id="email" name="email" required>

            <input type="submit" name="submit" value="Kaydet">
        </form>
    </div>
</body>
</html>
