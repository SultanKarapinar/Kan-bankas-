<!-- login.php -->

<?php
session_start();


if(isset($_SESSION["login"])) {
    header("location: index.php");
    exit;
}

if($_SERVER["REQUEST_METHOD"] == "POST") {
    // Veritabanı bağlantısı
    include 'db_config.php';

    // Gelen kullanıcı adı ve şifre
    $input_username = $_POST["username"];
    $input_password = $_POST["password"];

    // Kullanıcıyı veritabanından sorgula
    $query = "SELECT * FROM users WHERE username = :username";
    $statement = $conn->prepare($query);
    $statement->bindParam(':username', $input_username);
    $statement->execute();
    $user = $statement->fetch(PDO::FETCH_ASSOC);

    // Kullanıcı bulundu mu?
    if($user) {
        // Şifre doğrulaması
        if($input_password === $user['password']) {
            // Giriş başarılı, oturum başlat
            $_SESSION["login"] = true;
            header("location: index.php");
            exit;
        } else {
            $error_message = "Kullanıcı adı veya şifre hatalı!";
        }
    } else {
        $error_message = "Kullanıcı bulunamadı!";
    }
}
?>

<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
    <style>
        body {
            background-image: url('images.jpg'); /* Arka plan resmi */
            background-size: cover;
            background-position: center;
            font-family: Arial, sans-serif;
            color: #999999;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
       
        .container {
           
            width: 300px;
            margin: 0 auto;
            padding: 20px;
            background-color: #999999;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        button[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: none;
            border-radius: 5px;
            background-color: #1F91DC;
            color: #fff;
            cursor: pointer;
        }
       
        
       
      
    </style>
</head>
<body>
    <div class="container">
        <h2>Giriş Yap</h2>
        <?php if(isset($error_message)) { ?>
            <div class="error"><?php echo $error_message; ?></div>
        <?php } ?>
        <form method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
            <input type="text" name="username" placeholder="Kullanıcı Adı" required><br>
            <input type="password" name="password" placeholder="Şifre" required><br>
            <button type="submit">Giriş Yap</button>
        </form>
    </div>
</body>
</html>
