<?php
$host = '127.0.0.1';
$port = 3305;
$dbname = 'yilan_budget';
$username = 'root';
$password = '736108';

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("連線失敗：" . $e->getMessage());
}
?>

