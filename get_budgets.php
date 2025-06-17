<?php
header('Content-Type: application/json');

// 資料庫設定
$host = '127.0.0.1';
$dbname = 'yilan_budget';
$username = 'root';
$password = '736108';
$port = 3305;

try {
    $conn = new PDO("mysql:host=$host;port=$port;dbname=$dbname;charset=utf8mb4", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // 先抓出所有 budgets
    $stmt = $conn->prepare("SELECT * FROM budgets ORDER BY create_date DESC");
    $stmt->execute();
    $budgets = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $result = [];

    foreach ($budgets as $budget) {
        $budget_id = $budget['id'];

        $stmt_items = $conn->prepare("SELECT category, name, amount, description FROM budget_items WHERE budget_id = ?");
        $stmt_items->execute([$budget_id]);
        $items = $stmt_items->fetchAll(PDO::FETCH_ASSOC);

        $result[] = [
            'id' => $budget_id,
            'trip_name' => $budget['trip_name'],
            'total_budget' => $budget['total_budget'],
            'create_date' => $budget['create_date'],
            'items' => $items
        ];
    }

    echo json_encode(['success' => true, 'budgets' => $result]);

} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>
