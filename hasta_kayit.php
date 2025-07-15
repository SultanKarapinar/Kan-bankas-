<?php
include 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Formdan gelen verileri al
    $ad = $_POST['ad'];
    $yas = $_POST['yas'];
    $cinsiyet = $_POST['cinsiyet'];
    $iletisim = $_POST['iletisim'];
    $kan_grubu = $_POST['kan_grubu'];
   
    // Veritabanına kayıt ekleme
    $sql = "INSERT INTO hasta (ad, yas, cinsiyet, iletisim, kan_grubu) VALUES (:ad, :yas, :cinsiyet, :iletisim, :kan_grubu)";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':ad', $ad);
    $stmt->bindParam(':yas', $yas);
    $stmt->bindParam(':cinsiyet', $cinsiyet);
    $stmt->bindParam(':iletisim', $iletisim);
    $stmt->bindParam(':kan_grubu', $kan_grubu);
   

    if ($stmt->execute()) {
        echo "Hasta başarıyla kaydedildi.";
         // Başarıyla kaydedildikten sonra, kullanıcıyı başka bir sayfaya yönlendirin
    header("Location: hasta_liste.php");
    exit;
    } else {
        echo "Hata: " . $stmt->errorInfo()[2];
    }
} 
  
 // SQL sorgusunun hazırlanması
 $sql = "INSERT INTO kan_stok (kan_grubu, miktar) VALUES (:kan_grubu, :miktar)";

 // SQL sorgusunun çalıştırılması
 $stmt = $conn->prepare($sql);
 $miktar = 1; // Donör kaydı yapıldığında miktar 1 olarak belirlenebilir.
 $stmt->bindParam(':kan_grubu', $kan_grubu);
 $stmt->bindParam(':miktar', $miktar);

 /*if ($stmt->execute()) {
     echo "Kan stoğuna başarıyla eklendi.";
 } else {
     echo "Hata: " . $stmt->errorInfo()[2]; // Hata bilgisini almak için errorInfo() yöntemini kullanın
 }
*/
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HASTA KAYIT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('kayit.jpg'); 
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
        <h2>HASTA KAYIT</h2>
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

           

            <input type="submit" name="submit" value="Kaydet">
        </form>
    </div>
</body>
</html>
