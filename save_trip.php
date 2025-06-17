<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 取得 JSON 請求資料
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// 檢查必要欄位
if (!$data || !isset($data['name']) || !isset($data['schedule'])) {
    echo json_encode(['success' => false, 'error' => '缺少行程資料']);
    exit;
}

// 資料庫連線資訊
$host = '127.0.0.1';
$dbname = 'yilan_budget';
$username = 'root';
$password = '736108';
$port = 3305;

// 建立連線
$conn = new mysqli($host, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => '資料庫連接失敗: ' . $conn->connect_error]);
    exit;
}

$name = $conn->real_escape_string($data['name']);

// 插入 trips 表（主行程資訊）
$trip_sql = "INSERT INTO trips (name, created_at) VALUES ('$name', NOW())";
if (!$conn->query($trip_sql)) {
    echo json_encode(['success' => false, 'error' => '寫入 trips 失敗: ' . $conn->error]);
    exit;
}

// 取得剛新增行程的 trip_id
$trip_id = $conn->insert_id;

// 插入 trip_items（每一天的景點）
$stmt = $conn->prepare("INSERT INTO trip_items (trip_id, day, name, category, note) VALUES (?, ?, ?, ?, ?)");
foreach ($data['schedule'] as $day => $items) {
    foreach ($items as $item) {
        $item_name = $item['name'] ?? '';
        $category = $item['category'] ?? '';
        $note = $item['note'] ?? '';
        $stmt->bind_param("iisss", $trip_id, $day, $item_name, $category, $note);
        $stmt->execute();
    }
}
$stmt->close();

echo json_encode(['success' => true]);
?>


