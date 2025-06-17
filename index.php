<?php
// 儲存使用者預算資料

header("Content-Type: application/json");

// 建立資料庫連線
$host = "localhost";
$dbname = "yilan_budget";
$user = "root";
$password = "736108";

$conn = new mysqli($host, $user, $password, $dbname);

// 檢查連線
if ($conn->connect_error) {
    die(json_encode(["success" => false, "message" => "連線失敗: " . $conn->connect_error]));
}

// 讀取 JSON 資料
$input = json_decode(file_get_contents("php://input"), true);

$items = json_encode($input["user_data"]["items"]);
$total = intval($input["total_budget"]);

// 寫入資料
$stmt = $conn->prepare("INSERT INTO budgets (items, total) VALUES (?, ?)");
$stmt->bind_param("si", $items, $total);

if ($stmt->execute()) {
    echo json_encode(["success" => true, "message" => "預算已儲存"]);
} else {
    echo json_encode(["success" => false, "message" => "儲存失敗: " . $stmt->error]);
}

$stmt->close();
$conn->close();
?>
