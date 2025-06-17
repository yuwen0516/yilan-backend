<?php
session_start();
require_once 'db.php';

$email = $_POST['email'] ?? '';
$password = $_POST['password'] ?? '';

$stmt = $pdo->prepare("SELECT * FROM user WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch();

if ($user && $user['password'] === $password) {
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['email'] = $user['email'];
    
    header("Location: travel_budget_fixed_object_display.php");
    exit;
} else {
    echo "<script>alert('登入失敗，請檢查帳號或密碼'); window.location.href='login.html';</script>";
}
?>
