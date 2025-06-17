<?php
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // 檢查是否重複
    $stmt = $pdo->prepare("SELECT id FROM user WHERE email = ?");
    $stmt->execute([$email]);
    if ($stmt->rowCount() > 0) {
        echo "<script>alert('此帳號已註冊'); history.back();</script>";
        exit;
    }

    // ✅ 直接寫入明碼（僅用於測試環境）
    $stmt = $pdo->prepare("INSERT INTO user (name, email, password) VALUES (?, ?, ?)");
    if ($stmt->execute([$name, $email, $password])) {
        echo "<script>alert('註冊成功！請登入'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('註冊失敗'); history.back();</script>";
    }
}
?>

