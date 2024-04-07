<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

// Veritabanı bilgileri
$host = 'localhost';
$db   = 'myDatabase';
$user = 'root';
$pass = '';
$charset = 'utf8mb4';

// PDO bağlantı dizesi
$dsn = "mysql:host=$host;dbname=$db;charset=$charset";

try {
    // PDO nesnesi oluştur
    $pdo = new PDO($dsn, $user, $pass);

    // Hata modunu ayarla
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // SQL sorgusu
    $sql = "INSERT INTO myTable (tc, name, surname, email, phone) VALUES (?, ?, ?, ?, ?)";

    // SQL sorgusunu hazırla
    $stmt = $pdo->prepare($sql);

    // POST ile gelen değerleri al
    $tc = $_POST['tc'];
    $name = $_POST['name'];
    $surname = $_POST['surname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // SQL sorgusunu çalıştır ve POST ile gelen değerleri ekle
    $stmt->execute([$tc, $name, $surname, $email, $phone]);

    echo "Veri başarıyla eklendi.";
} catch (PDOException $e) {
    print_r($_POST);
}
?>

