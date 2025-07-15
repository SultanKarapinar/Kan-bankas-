<?php
// Oturumu başlat
session_start();

// Oturumu sonlandır (oturum değişkenlerini temizle)
session_unset();

// Oturumu sonlandır (oturumu yok et)
session_destroy();

// Kullanıcıyı başka bir sayfaya yönlendir (isteğe bağlı)
header("Location: login.php"); // Kullanıcıyı giriş sayfasına yönlendir
exit; // Kodun burada sonlandığını belirtmek için exit() fonksiyonunu kullanıyoruz
?>
