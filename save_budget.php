<?php
header('Content-Type: application/json');

// 資料庫設定
$host = '127.0.0.1';
$dbname = 'yilan_budget';
$username = 'root';
$password = '736108';
$port = 3305;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password); // ✅ 加上 port
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 接收前端 JSON 資料
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // 驗證欄位是否存在
    if (!isset($data['trip_name'], $data['items'], $data['total'])) {
        echo json_encode(['success' => false, 'error' => '資料格式錯誤']);
        exit;
    }

    // 插入主表 budgets
    $stmt = $pdo->prepare("INSERT INTO budgets (trip_name, total_budget, create_date) VALUES (?, ?, NOW())");
    $stmt->execute([$data['trip_name'], $data['total']]);
    $budget_id = $pdo->lastInsertId();

    // 插入所有預算項目到 budget_items
    $stmt_item = $pdo->prepare("INSERT INTO budget_items (budget_id, category, name, amount, description) VALUES (?, ?, ?, ?, ?)");
    foreach ($data['items'] as $item) {
        $stmt_item->execute([
            $budget_id,
            $item['category'],
            $item['name'],
            $item['amount'],
            $item['description'] ?? ''
        ]);
    }

    // 成功回傳
    echo json_encode(['success' => true]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
