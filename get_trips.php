<?php
header("Content-Type: application/json");
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 資料庫連線
$host = '127.0.0.1';
$dbname = 'yilan_budget';
$username = 'root';
$password = '736108';
$port = 3305;

$conn = new mysqli($host, $username, $password, $dbname, $port);
if ($conn->connect_error) {
    echo json_encode(['success' => false, 'error' => '連線失敗: ' . $conn->connect_error]);
    exit;
}

// 查詢所有 trips
$trips_sql = "SELECT * FROM trips ORDER BY created_at DESC";
$trips_result = $conn->query($trips_sql);

$trips = [];

while ($trip = $trips_result->fetch_assoc()) {
    $trip_id = $trip['id'];

    // 初始化 trip 資料
    $trip_data = [
        'id' => $trip_id,
        'name' => $trip['name'],
        'created_at' => $trip['created_at'],
        'schedule' => []
    ];

    // 查詢此 trip 的所有景點
    $items_sql = "SELECT day, name, category, note FROM trip_items WHERE trip_id = $trip_id ORDER BY day ASC, id ASC";
    $items_result = $conn->query($items_sql);

    while ($item = $items_result->fetch_assoc()) {
        $day = $item['day'];
        if (!isset($trip_data['schedule'][$day])) {
            $trip_data['schedule'][$day] = [];
        }

        $trip_data['schedule'][$day][] = [
            'name' => $item['name'],
            'category' => $item['category'],
            'note' => $item['note']
        ];
    }

    $trips[] = $trip_data;
}

// 回傳 JSON 結果
echo json_encode(['success' => true, 'trips' => $trips], JSON_UNESCAPED_UNICODE);
?>

