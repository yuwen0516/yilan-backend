<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}
?>
<!DOCTYPE html>
<html lang="zh-TW">
<head>
    <meta charset="UTF-8">
    <title>熱門景點 - 宜蘭旅遊平台</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: "Microsoft JhengHei", sans-serif;
        }
        .header {
            background-color: #ffe8cc;
            padding: 20px 0;
            text-align: center;
            border-bottom: 3px solid #ff9800;
        }
        .card {
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.05);
            transition: transform 0.3s;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
    </style>
</head>
<body>

<div class="header">
    <h1 class="text-orange">宜蘭熱門景點</h1>
    <p>探索必訪地點</p>
</div>

<div class="container mt-4">
    <div class="row">
        <!-- 景點卡片範例 -->
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="images/蘭陽博物館.jpg" class="card-img-top" alt="蘭陽博物館">
                <div class="card-body">
                    <h5 class="card-title">蘭陽博物館</h5>
                    <p class="card-text">展示宜蘭自然與人文的地標性博物館。</p>
                </div>
            </div>
        </div>

        <!-- 更多卡片可以照這個格式繼續加 -->
    </div>
</div>

</body>
</html>
