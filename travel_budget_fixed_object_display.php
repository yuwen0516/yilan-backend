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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>宜蘭旅遊網站</title>
      <!-- Bootstrap -->

  <style>
    #map {
      height: 400px;
      width: 100%;
      border: 2px solid #ff9800;
      border-radius: 8px;
      margin-top: 10px;
    }
  </style>
</head>
<body class="p-4 bg-light">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: "Microsoft JhengHei", Arial, sans-serif;
            background-color: #f8f9fa;
            color: #333;
        }

        .header-banner {
            background-color: #ffe8cc;
            padding: 20px 0;
            border-bottom: 3px solid #ff9800;
            margin-bottom: 30px;
        }

        .header-title {
            color: #e65100;
            font-weight: bold;
        }

        .nav-tabs .nav-link {
            color: #ff9800;
            border: 1px solid transparent;
        }

        .nav-tabs .nav-link.active {
            color: #e65100;
            background-color: #fff3e0;
            border-color: #ffcc80;
            border-bottom-color: transparent;
            font-weight: bold;
        }

        .tab-content {
            background-color: #fff;
            padding: 20px;
            border: 1px solid #dee2e6;
            border-top: 0;
            border-radius: 0 0 5px 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        .attraction-card {
            transition: transform 0.3s;
            margin-bottom: 20px;
            border: none;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .attraction-card:hover {
            transform: translateY(-5px);
        }

        .attraction-card .card-img-top {
            height: 200px;
            object-fit: cover;
        }

        .attraction-card .card-title {
            color: #e65100;
            font-weight: bold;
        }

        .budget-section {
            background-color: #fff3e0;
            border-radius: 10px;
            padding: 20px;
            margin-top: 30px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .budget-section h3 {
            color: #e65100;
            border-bottom: 2px solid #ffcc80;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .form-label {
            color: #333;
            font-weight: 500;
        }

        .form-control, .form-select {
            border-color: #ffcc80;
            border-radius: 5px;
        }

        .form-control:focus, .form-select:focus {
            border-color: #ff9800;
            box-shadow: 0 0 0 0.25rem rgba(255, 152, 0, 0.25);
        }

        .btn-warning {
            background-color: #ff9800;
            border-color: #ff9800;
        }

        .btn-warning:hover {
            background-color: #e65100;
            border-color: #e65100;
        }

        .budget-item {
            background-color: #fff;
            border-radius: 5px;
            margin-bottom: 10px;
            padding: 10px 15px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-left: 3px solid #ff9800;
        }

        .remove-btn {
            background-color: #ff5722;
            color: white;
            border: none;
            border-radius: 4px;
            padding: 2px 10px;
            cursor: pointer;
        }

        .remove-btn:hover {
            background-color: #e64a19;
        }

        .budget-total {
            background-color: #ffcc80;
            color: #e65100;
            border-radius: 5px;
            padding: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }

        .save-btn {
            background-color: #ff9800;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            font-weight: bold;
            margin-top: 10px;
        }

        .save-btn:hover {
            background-color: #e65100;
        }

        .budget-history {
            margin-top: 30px;
        }

        .budget-history-item {
            background-color: #fff;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            border-left: 3px solid #ff9800;
        }

        .budget-history-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #ffcc80;
            padding-bottom: 8px;
            margin-bottom: 12px;
            color: #e65100;
            font-weight: bold;
        }

        .budget-history-list {
            list-style-type: none;
            padding-left: 0;
        }

        .budget-history-list li {
            padding: 5px 0;
            border-bottom: 1px dashed #eee;
        }

        .budget-history-total {
            text-align: right;
            font-weight: bold;
            color: #e65100;
            margin-top: 10px;
        }

        #loading-spinner {
            display: none;
            text-align: center;
            margin: 20px 0;
        }

        .alert {
            margin-top: 15px;
        }

        .footer {
            background-color: #ffe8cc;
            padding: 20px 0;
            text-align: center;
            border-top: 3px solid #ff9800;
            margin-top: 50px;
        }

        .footer p {
            margin-bottom: 0;
            color: #e65100;
        }

        @media (max-width: 768px) {
            .attraction-card .card-img-top {
                height: 150px;
            }
        }

        <style>
  #map {
    height: 400px;
    border: 2px solid orange;
    border-radius: 8px;
    margin-top: 1rem;
  }

  .leaflet-container {
    width: 100%;
    height: 100%;
  }
</style>


    </style>

<script>

// 儲存景點資料的陣列
var scheduleData = [];

// 地圖點擊時呼叫，加入景點到行程資料
function addPlaceToSchedule(placeName) {
    // 建立一筆行程資料（僅包含名稱）
    const place = { name: placeName };

    // 加入陣列
    scheduleData.push(place);

    // 同步更新畫面
    const itineraryList = document.getElementById('itinerary-list');
    const li = document.createElement('li');
    li.textContent = placeName;
    itineraryList.appendChild(li);
}


function addToItinerary(locationName) {
    var itineraryList = document.getElementById('itinerary-list');
    var li = document.createElement('li');
    li.textContent = locationName;
    itineraryList.appendChild(li);
}

// 切換顯示區塊用
function showTab(tabId) {
    const sections = document.querySelectorAll('.tab-content-section');
    sections.forEach(sec => sec.style.display = 'none');
    const target = document.getElementById(tabId);
    if (target) target.style.display = 'block';

    const tabs = document.querySelectorAll('#mainTabs .nav-link');
    tabs.forEach(tab => tab.classList.remove('active'));
    const clicked = Array.from(tabs).find(btn => btn.getAttribute('onclick')?.includes(`showTab('${tabId}')`));
    if (clicked) clicked.classList.add('active');

    // ✅ 加入這段：切換到行程規劃或任一含地圖的頁面時，強制重繪 Leaflet 地圖
    if ((tabId === 'planner' || tabId === 'attractions') && typeof map !== 'undefined') {
        setTimeout(() => {
            map.invalidateSize();
        }, 300);
    }
}

document.addEventListener('DOMContentLoaded', function () {
    showTab('attractions');
    loadBudgetHistory();
});

</script>

    <!-- 這裡是地圖的基本CSS與JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <!-- Make sure you put this AFTER Leaflet's CSS -->
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        #map { height: 180px; }
    </style>

</head>


<script>
    if (localStorage.getItem('loggedIn') !== 'true') {
        window.location.href = 'login.html';
    }
</script>

<body>

    <!-- 頁面頭部 -->
    <div class="header-banner">
        <div class="container">
            <h1 class="header-title text-center">宜蘭旅遊網站</h1>
            <p class="text-center mb-0">探索宜蘭的美景與美食，規劃您的完美旅程</p>
        </div>
    </div>

    <div class="container mt-4">
    <ul class="nav nav-tabs" id="mainTabs">
        <li class="nav-item">
            <button class="nav-link active" onclick="showTab('attractions')">熱門景點</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" onclick="showTab('foods')">美食推薦</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" onclick="showTab('planner')">行程規劃</button>
        </li>
        <li class="nav-item">
            <button class="nav-link" onclick="showTab('budget')">預算計算</button>
        </li>
        <!-- <li class="nav-item">
            <button class="btn btn-outline-dark" data-bs-toggle="modal" data-bs-target="#historyModal">
    歷史紀錄-->
</button>
</li>
</ul>
    
        <!-- 選項卡內容 -->
        <div id="attractions" class="tab-content-section">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/蘭陽博物館uFF0F攝影者黃長富 (1).jpg" class="card-img-top" alt="蘭陽博物館">
                            <div class="card-body">
                                <h5 class="card-title">蘭陽博物館</h5>
                                <p class="card-text">位於頭城的蘭陽博物館是宜蘭的地標性建築，展示宜蘭的自然環境與人文歷史。</p>
                                <p class="text-muted">門票: 成人 NT$100</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/下載.jpg" class="card-img-top" alt="羅東夜市">
                            <div class="card-body">
                                <h5 class="card-title">羅東夜市</h5>
                                <p class="card-text">羅東夜市是宜蘭最熱鬧的夜市之一，有許多當地特色小吃和商品。</p>
                                <p class="text-muted">營業時間: 17:00 - 00:00</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/下載 (1).jpg" class="card-img-top" alt="礁溪溫泉">
                            <div class="card-body">
                                <h5 class="card-title">礁溪溫泉</h5>
                                <p class="card-text">礁溪以其優質的碳酸氫鈉泉聞名，是台灣最著名的溫泉區之一。</p>
                                <p class="text-muted">價格: 從 NT$300 起</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/龜龜下載 (2).jpg" class="card-img-top" alt="龜山島">
                            <div class="card-body">
                                <h5 class="card-title">龜山島</h5>
                                <p class="card-text">形狀像浮龜的火山島嶼，提供賞鯨、登島等豐富的生態旅遊體驗。</p>
                                <p class="text-muted">賞鯨船票: NT$1,000 起</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/傳藝下載 (2).jpg" class="card-img-top" alt="傳統藝術中心">
                            <div class="card-body">
                                <h5 class="card-title">國立傳統藝術中心</h5>
                                <p class="card-text">保存和展示台灣傳統藝術和民俗文化的場所，有精彩的表演和工藝展示。</p>
                                <p class="text-muted">門票: 成人 NT$150</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/五峰旗下載 (2).jpg" class="card-img-top" alt="五峰旗瀑布">
                            <div class="card-body">
                                <h5 class="card-title">五峰旗瀑布</h5>
                                <p class="card-text">位於礁溪的知名瀑布，有三層不同高度的瀑布和清澈的水池。</p>
                                <p class="text-muted">入場費: 免費</p>
                            </div>
                        </div>
                    </div>
                    <div>
                        <h4 class="mt-4">景點地圖</h4>
                        <div id="map" style="height: 400px; border: 2px solid #ff9800; border-radius: 8px;"></div>
                    </div>
                </div>
            </div>


        
            <!-- 美食推薦 -->
            <div id="foods" class="tab-content-section" style="display:none;">
                <div class="row">
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/鴨賞下載 (2).jpg" class="card-img-top" alt="鴨賞">
                            <div class="card-body">
                                <h5 class="card-title">宜蘭鴨賞</h5>
                                <p class="card-text">宜蘭特產，鴨肉經過特殊醃製與烹調而成，香氣四溢，口感豐富。</p>
                                <p class="text-muted">價格: NT$200-300/份</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/東門蚵仔煎下載 (2).jpg" class="card-img-top" alt="蚵仔煎">
                            <div class="card-body">
                                <h5 class="card-title">東門蚵仔煎</h5>
                                <p class="card-text">外皮酥脆，內餡多汁的蚵仔煎，搭配特製甜辣醬汁，風味絕佳。</p>
                                <p class="text-muted">價格: NT$80/份</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/三星蔥油餅下載 (2).jpg" class="card-img-top" alt="蔥油餅">
                            <div class="card-body">
                                <h5 class="card-title">三星蔥油餅</h5>
                                <p class="card-text">使用宜蘭三星蔥製作的蔥油餅，香氣濃郁，外酥內軟，是必嚐美食。</p>
                                <p class="text-muted">價格: NT$50/片</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/奶凍捲0101041.jpg" class="card-img-top" alt="奶凍捲">
                            <div class="card-body">
                                <h5 class="card-title">奶凍捲</h5>
                                <p class="card-text">宜蘭羅東知名甜點，柔軟的蛋糕捲中包裹著滑嫩的牛奶凍，口感獨特。</p>
                                <p class="text-muted">價格: NT$200-300/捲</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/東門雞排下載 (2).jpg" class="card-img-top" alt="炸雞排">
                            <div class="card-body">
                                <h5 class="card-title">東門雞排</h5>
                                <p class="card-text">香脆多汁的炸雞排，灑上特調香料，是夜市中最受歡迎的小吃之一。</p>
                                <p class="text-muted">價格: NT$70/份</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card attraction-card">
                            <img src="images/包心粉圓下載 (2).jpg" class="card-img-top" alt="包心粉圓">
                            <div class="card-body">
                                <h5 class="card-title">包心粉圓</h5>
                                <p class="card-text">宜蘭特色甜品，QQ的粉圓裡包著花生或芝麻餡，口感豐富層次分明。</p>
                                <p class="text-muted">價格: NT$40-60/碗</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

    <!-- 行程規劃 -->
<a href="yilan_trip_map_itinerary_saved.html" class="btn btn-outline-primary">
  使用地圖進一步規劃 ➤
</a>


</body>
</html>


    <!-- 歷史記錄彈窗 
<div class="modal fade" id="historyModal" tabindex="-1" aria-labelledby="historyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #ff9800; color: white;">
                <h5 class="modal-title" id="historyModalLabel">
                    <i class="bi bi-clock-history me-2"></i>行程歷史記錄
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="no-history-message" class="text-center py-4 text-muted" style="display: none;">
                    <i class="bi bi-inbox fs-1 mb-3 d-block"></i>
                    <p>尚無保存的行程記錄</p>
                </div>
                <div id="history-list"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">關閉</button>
            </div>
        </div>
    </div>
</div>


    <div class="modal fade" id="saveSuccessModal" tabindex="-1" aria-labelledby="saveSuccessModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header" style="background-color: #28a745; color: white;">
                <h5 class="modal-title" id="saveSuccessModalLabel">
                    <i class="bi bi-check-circle me-2"></i>保存成功
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>您的行程已成功保存！</p>
                <p>您可以在「查看歷史記錄」中找到此行程。</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success" data-bs-dismiss="modal">確定</button>
            </div>
        </div>
    </div>
</div>  -->

    <!-- 預算計算 -->
            <div id="budget" class="tab-content-section">
            <div class="tab-pane fade show active" role="tabpanel" aria-labelledby="budget-tab">
                <div class="budget-section">
                    <h3>旅遊預算計算器</h3>
                    <div class="row mb-3">
                        <div class="col-md-6 mb-3">
                            <label for="trip-name" class="form-label">旅遊名稱</label>
                            <input type="text" class="form-control" id="trip-name" placeholder="例如：宜蘭三日遊">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="trip-days" class="form-label">旅遊天數</label>
                            <input type="number" class="form-control" id="trip-days" min="1" value="1">
                        </div>
                        <div class="col-md-3 mb-3">
                            <label for="trip-people" class="form-label">人數</label>
                            <input type="number" class="form-control" id="trip-people" min="1" value="1">
                        </div>
                    </div>
                </div>
              </div>
            </div>
                    
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="budget-category" class="form-label">費用類別</label>
                            <select class="form-select" id="budget-category">
                                <option value="" disabled selected>選擇類別</option>
                                <option value="交通">交通</option>
                                <option value="住宿">住宿</option>
                                <option value="餐飲">餐飲</option>
                                <option value="景點門票">景點門票</option>
                                <option value="購物">購物</option>
                                <option value="其他">其他</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <label for="budget-item" class="form-label">項目名稱</label>
                            <select class="form-select" id="budget-item">
                                <option value="" disabled selected>選擇項目</option>
                                <!-- 交通類別 -->
                                <optgroup label="交通" class="category-交通" style="display:none;">
                                    <option value="火車票">火車票</option>
                                    <option value="公車">公車</option>
                                    <option value="計程車">計程車</option>
                                    <option value="租車">租車</option>
                                    <option value="腳踏車租借">腳踏車租借</option>
                                </optgroup>
                                <!-- 住宿類別 -->
                                <optgroup label="住宿" class="category-住宿" style="display:none;">
                                    <option value="飯店">飯店</option>
                                    <option value="民宿">民宿</option>
                                    <option value="溫泉旅館">溫泉旅館</option>
                                </optgroup>
                                <!-- 餐飲類別 -->
                                <optgroup label="餐飲" class="category-餐飲" style="display:none;">
                                    <option value="早餐">早餐</option>
                                    <option value="午餐">午餐</option>
                                    <option value="晚餐">晚餐</option>
                                    <option value="小吃">小吃</option>
                                    <option value="飲料">飲料</option>
                                </optgroup>
                                <!-- 景點門票類別 -->
                                <optgroup label="景點門票" class="category-景點門票" style="display:none;">
                                    <option value="蘭陽博物館">蘭陽博物館</option>
                                    <option value="傳統藝術中心">傳統藝術中心</option>
                                    <option value="龜山島登島">龜山島登島</option>
                                    <option value="賞鯨船票">賞鯨船票</option>
                                </optgroup>
                                <!-- 購物類別 -->
                                <optgroup label="購物" class="category-購物" style="display:none;">
                                    <option value="伴手禮">伴手禮</option>
                                    <option value="特產">特產</option>
                                    <option value="紀念品">紀念品</option>
                                </optgroup>
                                <!-- 其他類別 -->
                                <optgroup label="其他" class="category-其他" style="display:none;">
                                    <option value="旅遊保險">旅遊保險</option>
                                    <option value="醫療用品">醫療用品</option>
                                    <option value="活動費用">活動費用</option>
                                </optgroup>
                            </select>
                        </div>
                    </div>
                    

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="budget-amount" class="form-label">金額 (NT$)</label>
                            <input type="number" class="form-control" id="budget-amount" min="0" placeholder="輸入金額">
                        </div>
                        <div class="col-md-6">
                            <label for="budget-description" class="form-label">備註 (選填)</label>
                            <input type="text" class="form-control" id="budget-description" placeholder="例如：每人NT$150">
                        </div>
                    </div>
                    
                    <div class="d-grid mb-4">
                        <button id="add-budget" class="btn btn-warning">添加預算項目</button>
                    </div>
                    
                    <div id="budget-list" class="mb-3">
                        <p class="text-center text-muted">尚未添加預算項目</p>
                    </div>
                    
                    <div id="budget-total" class="budget-total">
                        總預算: NT$0
                    </div>
                    
                    <div class="d-grid mt-4">
                        <button class="btn save-btn" id="save-budget" onclick="saveBudget()">保存此預算</button>
                    </div>
                </div>
            </div>
            <hr/>
            <h5>📜 歷史預算紀錄</h5>
            <div id="budget-history-list" class="mt-3">
            </div>


            <!-- 歷史紀錄 -->
            <div id="budget-history-tab" class="tab-pane fade">
                <h3 class="mb-4">預算歷史紀錄</h3>
                <div id="budget-history" class="budget-history">
                    <p class="text-center text-muted">尚無預算歷史記錄</p>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- 載入 Bootstrap JS 和相關依賴 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


    <!-- 行程規劃相關JS -->
    <script>
        // 宜蘭景點資料
        var attractions = [
            { name: "蘭陽博物館", category: "博物館" },
            { name: "龜山島", category: "自然景點" },
            { name: "五峰旗瀑布", category: "自然景點" },
            { name: "太平山", category: "自然景點" },
            { name: "傳統藝術中心", category: "博物館" },
            { name: "礁溪溫泉", category: "溫泉" },
            { name: "羅東夜市", category: "夜市美食" },
            { name: "東門夜市", category: "夜市美食" },
            { name: "冬山河親水公園", category: "自然景點" },
            { name: "梅花湖", category: "自然景點" },
            { name: "頭城老街", category: "其他" },
            { name: "宜蘭酒廠", category: "其他" },
            { name: "清水地熱", category: "自然景點" },
            { name: "南方澳觀景台", category: "自然景點" },
            { name: "蘇澳冷泉", category: "溫泉" },
            { name: "佛光大學", category: "其他" },
            { name: "兔子迷宮", category: "其他" }
        ];
        
        // 行程資料儲存 - 使用var確保全局變數
        var scheduleData = {
            1: [], // 第1天行程
            2: [], // 第2天行程
            3: []  // 第3天行程
        };
        
        var itemCounter = 1;

        // 確保頁面加載完成後執行初始化
        window.onload = function () {
            initMap();
            renderItinerary();
            loadTripHistory();
            loadBudgetHistory(); // ← 加這行！
        };

        
        // 搜尋景點
        function searchPlaces() {
            var searchText = document.getElementById('place-search').value.trim();
            if (searchText.length > 0) {
                showSearchResults(searchText);
            }
        }
        
        // 選擇熱門景點
        function selectPopularPlace() {
            var popularSelect = document.getElementById('popular-places');
            var value = popularSelect.value;
            if (value) {
                document.getElementById('place-search').value = value;
                // 尋找對應的景點類別
                for (var i = 0; i < attractions.length; i++) {
                    if (attractions[i].name === value) {
                        document.getElementById('place-category').value = attractions[i].category;
                        break;
                    }
                }
                hideSearchResults();
            }
        }
        
        // 顯示搜尋結果
        function showSearchResults(searchText) {
            var searchResults = document.getElementById('search-results');
            searchResults.innerHTML = '';
            
            // 過濾符合的景點
            var filteredAttractions = [];
            for (var i = 0; i < attractions.length; i++) {
                if (attractions[i].name.includes(searchText)) {
                    filteredAttractions.push(attractions[i]);
                }
            }
            
            if (filteredAttractions.length > 0) {
                for (var i = 0; i < filteredAttractions.length; i++) {
                    var attraction = filteredAttractions[i];
                    var resultItem = document.createElement('div');
                    resultItem.className = 'search-item';
                    resultItem.textContent = attraction.name;
                    resultItem.onclick = (function(name, category) {
                        return function() {
                            document.getElementById('place-search').value = name;
                            document.getElementById('place-category').value = category;
                            hideSearchResults();
                        };
                    })(attraction.name, attraction.category);
                    searchResults.appendChild(resultItem);
                }
            } else {
                var noResult = document.createElement('div');
                noResult.className = 'search-item';
                noResult.textContent = '沒有找到相關景點';
                searchResults.appendChild(noResult);
            }
            
            searchResults.style.display = 'block';
        }
        
        // 隱藏搜尋結果
        function hideSearchResults() {
            var searchResults = document.getElementById('search-results');
            if (searchResults) {
                searchResults.style.display = 'none';
            }
        }
        
        // 切換天數標籤
        function switchDay(day) {
            console.log('切換到第' + day + '天');
            // 移除所有活動狀態
            var dayTabs = document.querySelectorAll('.day-tab');
            var daySchedules = document.querySelectorAll('.day-schedule');
            
            for (var i = 0; i < dayTabs.length; i++) {
                dayTabs[i].classList.remove('active');
            }
            
            for (var i = 0; i < daySchedules.length; i++) {
                daySchedules[i].classList.remove('active');
            }
            
            // 設定當前標籤為活動狀態
            var activeTab = document.querySelector('.day-tab[data-day="' + day + '"]');
            if (activeTab) {
                activeTab.classList.add('active');
            }
            
            var activeSchedule = document.getElementById('day' + day + '-schedule');
            if (activeSchedule) {
                activeSchedule.classList.add('active');
            }
        }
        
        // 添加景點到行程
        function addPlaceToSchedule(loc) {
    const selectedDay = parseInt(document.getElementById('day-selector').value);
    const place = {
        name: loc.name,
        day: selectedDay,
        category: loc.category || "未分類",
        note: ""
    };
    scheduleData.push(place);

    // 👇 正確顯示行程項目
    const itineraryList = document.getElementById('itinerary-list');
    const li = document.createElement('li');
    li.textContent = `📍 Day ${place.day} - ${place.name} (${place.category})`;
    itineraryList.appendChild(li);
}

        
        // 更新行程顯示
        function updateScheduleDisplay(day) {
            var scheduleContainer = document.getElementById('day' + day + '-schedule');
            var items = scheduleData[day];
            
            if (items.length === 0) {
                scheduleContainer.innerHTML = `
                <div class="empty-state">
                <i class="bi bi-calendar-plus"></i>
                <p>尚未添加行程項目</p>
                <p class="small">請添加景點</p>
                </div>
                 `;
                 return;
                }

            
            var html = '';
for (var i = 0; i < items.length; i++) {
    var item = items[i];
    html += `
        <div class="schedule-item" data-id="${item.id}">
            <button class="remove-btn" onclick="removeScheduleItem(${item.id}, ${day})">
                <i class="bi bi-x-circle"></i>
            </button>
            <div class="category-tag">${item.category}</div>
            <div class="place-name">${item.name}</div>
            ${item.note ? `<div class="note">${item.note}</div>` : ''}
        </div>
    `;
}

scheduleContainer.innerHTML = html;
        
        // 移除行程項目
        function removeScheduleItem(itemId, day) {
            console.log('移除項目：', itemId, '天數：', day);
            // 從數據中移除項目
            var newItems = [];
            for (var i = 0; i < scheduleData[day].length; i++) {
                if (scheduleData[day][i].id !== itemId) {
                    newItems.push(scheduleData[day][i]);
                }
            }
            scheduleData[day] = newItems;
            
            // 更新顯示
            updateScheduleDisplay(day);
            
            // 顯示提示
            showToast('已移除行程項目');
            
            // 自動保存行程
            autoSaveSchedule();
        }
        
        // 清空行程
        function clearSchedule() {
            if (confirm('確定要清空所有行程嗎？')) {
                // 重置所有行程數據
                for (var day = 1; day <= 3; day++) {
                    scheduleData[day] = [];
                    updateScheduleDisplay(day);
                }
                
                // 清除臨時保存的行程
                localStorage.removeItem('tempTourSchedule');
                
                // 顯示提示
                showToast('已清空所有行程');
            }
        }
        
        // 保存行程功能
        function saveSchedule() {
            // 檢查是否有行程項目
            var hasItems = false;
            var totalPlaces = 0;
            
            for (var day in scheduleData) {
                if (scheduleData[day].length > 0) {
                    hasItems = true;
                    totalPlaces += scheduleData[day].length;
                    break;
                }
            }
            
            if (!hasItems) {
                alert('請先添加景點到行程中');
                return;
            }
            
            // 取得行程名稱，如果沒有設定就自動生成一個
            var tourName = document.getElementById('tour-name').value.trim();
            if (!tourName) {
                tourName = '宜蘭' + totalPlaces + '景點遊';
                document.getElementById('tour-name').value = tourName;
            }
            
            // 取得行程天數和人數
            var tourDays = document.getElementById('tour-days').value;
            var tourPeople = document.getElementById('tour-people').value;
            
            // 創建行程記錄
            var tourRecord = {
                id: Date.now(),
                name: tourName,
                days: tourDays,
                people: tourPeople,
                date: new Date().toISOString(),
                schedule: JSON.parse(JSON.stringify(scheduleData)) // 深拷貝
            };
            
            // 從 localStorage 讀取已有的行程記錄
            var historyRecords = [];
            var savedRecords = localStorage.getItem('tourHistory');
            if (savedRecords) {
                try {
                    historyRecords = JSON.parse(savedRecords);
                    if (!Array.isArray(historyRecords)) {
                        historyRecords = [];
                    }
                } catch (e) {
                    console.error('讀取歷史記錄失敗:', e);
                    historyRecords = [];
                }
            }
            
            // 添加新行程記錄到歷史記錄中
            historyRecords.unshift(tourRecord); // 添加到開頭
            
            // 保存回 localStorage
            localStorage.setItem('tourHistory', JSON.stringify(historyRecords));
            
            // 保存臨時行程（這樣在重新載入頁面時還能看到當前行程）
            localStorage.setItem('tempTourSchedule', JSON.stringify(tourRecord));
            
            // 顯示成功提示
            try {
                var successModal = new bootstrap.Modal(document.getElementById('saveSuccessModal'));
                successModal.show();
            } catch (e) {
                console.error('顯示成功提示失敗:', e);
                showToast('行程已成功保存');
            }
        }

        function showHistoryModal() {
    try {
        var historyModal = new bootstrap.Modal(document.getElementById('historyModal'));
        loadTripHistory(); // 這個會去抓資料
        historyModal.show();
    } catch (e) {
        console.error("無法開啟歷史紀錄彈窗：", e);
        showToast("❌ 開啟歷史紀錄失敗！");
    }
}

        
    // 顯示歷史記錄彈窗
        function loadHistoryRecords() {
    var historyList = document.getElementById('history-list');
    var noHistoryMessage = document.getElementById('no-history-message');

    // 預設先隱藏「尚無記錄」訊息
    if (noHistoryMessage) {
        noHistoryMessage.style.display = 'none';
    }

// 從 localStorage 讀取歷史記錄
var historyRecords = localStorage.getItem('tourHistory');
if (historyRecords) {
    try {
        var records = JSON.parse(historyRecords);
        if (records && records.length > 0) {
            var html = '';
            for (var i = 0; i < records.length; i++) {
                var record = records[i];
                var date = new Date(record.date);
                var formattedDate = date.getFullYear() + '/' + 
                                   (date.getMonth() + 1).toString().padStart(2, '0') + '/' + 
                                   date.getDate().toString().padStart(2, '0') + ' ' + 
                                   date.getHours().toString().padStart(2, '0') + ':' + 
                                   date.getMinutes().toString().padStart(2, '0');

                var totalPlaces = 0;
                var placesHtml = '';

                for (var day = 1; day <= 3; day++) {
                    if (record.schedule[day] && record.schedule[day].length > 0) {
                        totalPlaces += record.schedule[day].length;

                        placesHtml += `<div class="day-summary mb-2">`;
                        placesHtml += `<div class="day-title">第${day}天：</div>`;

                        for (var j = 0; j < record.schedule[day].length; j++) {
                            var place = record.schedule[day][j];
                            placesHtml += `
                                <div class="history-place">
                                    <div>
                                        <span class="history-place-category">${place.category}</span>
                                        ${place.name}
                                    </div>
                                    ${place.note ? `<small class="text-muted">${place.note}</small>` : ''}
                                </div>
                            `;
                        }

                        placesHtml += `</div>`;
                    }
                }

                html += `
                    <div class="history-item">
                        <div class="history-header">
                            <div class="history-title">${record.name} (${totalPlaces}個景點)</div>
                            <div class="history-date">${formattedDate}</div>
                        </div>
                        <div class="history-content">
                            <div class="history-places">
                                ${placesHtml}
                            </div>
                            <div class="history-actions">
                                <button class="btn btn-sm btn-outline-orange me-2" onclick="loadHistorySchedule(${record.id})">載入行程</button>
                                <button class="btn btn-sm btn-outline-danger" onclick="deleteHistorySchedule(${record.id})">刪除</button>
                            </div>
                        </div>
                    </div>
                `;
            }

            historyList.innerHTML = html;
            return;
        }
    } catch (e) {
        console.error('解析歷史記錄錯誤:', e);
    }
}


    // 如果沒有記錄或讀取失敗，顯示「尚無記錄」訊息
    if (noHistoryMessage) {
        noHistoryMessage.style.display = 'block';
    }
}

        
        // 載入歷史行程
        function loadHistorySchedule(id) {
            var historyRecords = localStorage.getItem('tourHistory');
            if (historyRecords) {
                try {
                    var records = JSON.parse(historyRecords);
                    if (records && records.length > 0) {
                        // 尋找對應 ID 的記錄
                        var record = records.find(function(r) { return r.id === id; });
                        
                        if (record) {
                            // 設置行程名稱
                            document.getElementById('tour-name').value = record.name;
                            
                            // 設置天數和人數
                            if (record.days) {
                                document.getElementById('tour-days').value = record.days;
                            }
                            
                            if (record.people) {
                                document.getElementById('tour-people').value = record.people;
                            }
                            
                            // 載入行程數據
                            if (record.schedule) {
                                // 重置 itemCounter
                                itemCounter = 1;
                                
                                // 清空當前行程
                                for (var day = 1; day <= 3; day++) {
                                    scheduleData[day] = [];
                                }
                                
                                // 載入歷史行程
                                for (var day = 1; day <= 3; day++) {
                                    if (record.schedule[day]) {
                                        scheduleData[day] = record.schedule[day];
                                        
                                        // 確保 itemCounter 比已有項目的最大 ID 更大
                                        for (var i = 0; i < record.schedule[day].length; i++) {
                                            var item = record.schedule[day][i];
                                            if (item.id >= itemCounter) {
                                                itemCounter = item.id + 1;
                                            }
                                        }
                                        
                                        // 更新顯示
                                        updateScheduleDisplay(day);
                                    }
                                }
                                
                                // 關閉模態框
                                var historyModal = bootstrap.Modal.getInstance(document.getElementById('historyModal'));
                                if (historyModal) {
                                    historyModal.hide();
                                }
                                
                                // 切換到第1天標籤
                                switchDay(1);
                                
                                // 顯示提示
                                showToast('已載入歷史行程');
                                
                                // 自動保存到臨時行程
                                autoSaveSchedule();
                                
                                return true;
                            }
                        }
                    }
                } catch (e) {
                    console.error('載入歷史行程錯誤:', e);
                }
            }
            
            showToast('載入行程失敗');
            return false;
        }
        
        // 刪除歷史行程
        function deleteHistorySchedule(id) {
            if (!confirm('確定要刪除這個行程嗎？')) {
                return;
            }
            
            var historyRecords = localStorage.getItem('tourHistory');
            if (historyRecords) {
                try {
                    var records = JSON.parse(historyRecords);
                    if (records && records.length > 0) {
                        // 過濾掉要刪除的記錄
                        var newRecords = records.filter(function(r) { return r.id !== id; });
                        
                        // 保存更新後的記錄
                        localStorage.setItem('tourHistory', JSON.stringify(newRecords));
                        
                        // 重新載入歷史記錄列表
                        loadHistoryRecords();
                        
                        // 顯示提示
                        showToast('行程已刪除');
                        
                        return true;
                    }
                } catch (e) {
                    console.error('刪除歷史行程錯誤:', e);
                }
            }
            
            showToast('刪除行程失敗');
            return false;
        }
        
        // 自動保存行程
        function autoSaveSchedule() {
            // 檢查是否有行程項目
            var hasItems = false;
            var totalPlaces = 0;
            
            for (var day in scheduleData) {
                if (scheduleData[day].length > 0) {
                    hasItems = true;
                    totalPlaces += scheduleData[day].length;
                }
            }
            
            if (!hasItems) {
                return; // 沒有行程時不保存
            }
            
            // 創建行程記錄
            var tourRecord = {
                id: Date.now(),
                name: document.getElementById('tour-name').value || '宜蘭' + totalPlaces + '景點遊',
                date: new Date().toISOString(),
                schedule: JSON.parse(JSON.stringify(scheduleData)) // 深拷貝
            };
            
            // 保存到臨時記錄中
            localStorage.setItem('tempTourSchedule', JSON.stringify(tourRecord));
        }
        
        // 加載臨時保存的行程
        function loadTempSchedule() {
            var tempSchedule = localStorage.getItem('tempTourSchedule');
            if (tempSchedule) {
                try {
                    var parsedSchedule = JSON.parse(tempSchedule);
                    
                    // 設置行程名稱
                    if (parsedSchedule.name) {
                        document.getElementById('tour-name').value = parsedSchedule.name;
                    }
                    
                    // 載入行程數據
                    if (parsedSchedule.schedule) {
                        // 更新全局的 scheduleData
                        for (var day = 1; day <= 3; day++) {
                            if (parsedSchedule.schedule[day]) {
                                scheduleData[day] = parsedSchedule.schedule[day];
                                
                                // 確保 itemCounter 比已有項目的最大 ID 更大
                                for (var i = 0; i < parsedSchedule.schedule[day].length; i++) {
                                    var item = parsedSchedule.schedule[day][i];
                                    if (item.id >= itemCounter) {
                                        itemCounter = item.id + 1;
                                    }
                                }
                                
                                // 更新顯示
                                updateScheduleDisplay(day);
                            }
                        }
                        
                        // 顯示提示
                        showToast('已載入先前的行程');
                    }
                    
                    return true;
                } catch (error) {
                    console.error('載入行程時發生錯誤:', error);
                    localStorage.removeItem('tempTourSchedule');
                    return false;
                }
            }
            return false;
        }
        
        // 顯示提示訊息
        function showToast(message) {
            // 檢查是否已有提示訊息
            var existingToast = document.querySelector('.toast-message');
            if (existingToast) {
                document.body.removeChild(existingToast);
            }
            
            var toast = document.createElement('div');
            toast.className = 'toast-message';
            toast.textContent = message;
            document.body.appendChild(toast);
            
            // 顯示提示訊息
            setTimeout(function() {
                toast.classList.add('show');
            }, 10);
            
            // 3秒後隱藏
            setTimeout(function() {
                toast.classList.remove('show');
                setTimeout(function() {
                    if (document.body.contains(toast)) {
                        document.body.removeChild(toast);
                    }
                }, 300);
            }, 3000);
        }
        function saveSchedule() {
    const tourName = document.getElementById('tour-name').value.trim();
    const tourDays = document.getElementById('tour-days').value;
    const tourPeople = document.getElementById('tour-people').value;

    // 確認至少有一個行程
    let hasItems = Object.values(scheduleData).some(dayList => dayList.length > 0);
    if (!tourName || !hasItems) {
        alert('請輸入行程名稱並添加景點');
        return;
    }

    const payload = {
        tour_name: tourName,
        days: parseInt(tourDays),
        people: parseInt(tourPeople),
        schedule: scheduleData
    };

    fetch('save_trip.php', {
  method: 'POST',
  headers: { 'Content-Type': 'application/json' },
  body: JSON.stringify(payload)
})
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            showToast('✅ 行程已成功儲存！');
            loadTripHistory(); // <-- 重新載入歷史
        } else {
            showToast('❌ 儲存失敗：' + data.error);
        }
    })
    .catch(err => {
        showToast('❌ 發生錯誤：' + err.message);
    });
}
function loadTripHistory() {
  fetch('get_trips.php')
    .then(response => response.json())
    .then(data => {
      const historyList = document.getElementById('history-list');
      historyList.innerHTML = '';

      if (data.success && data.trips.length > 0) {
        data.trips.forEach(trip => {
          const div = document.createElement('div');
          div.className = 'budget-history-item';

          let daysHTML = '';
          for (const day in trip.schedule) {
            const items = trip.schedule[day]
              .map(item => `<li>${item.name || ''} (${item.category || ''}) - ${item.note || ''}</li>`)
              .join('');
            daysHTML += `<strong>第${day}天：</strong><ul>${items}</ul>`;
          }

          div.innerHTML = `
            <div class="budget-history-header">
              <span>${trip.tour_name}</span>
              <span>${trip.create_date}</span>
            </div>
            ${daysHTML}
          `;
          console.log("📦 渲染 div", div.innerHTML);
          historyList.appendChild(div);
        });
      } else {
        historyList.innerHTML = '<p class="text-muted text-center">尚無行程紀錄</p>';
      }
    })
    .catch(error => {
      console.error('載入歷史錯誤:', error);
    });
}

// 等 DOM 載入後綁定按鈕事件
document.addEventListener('DOMContentLoaded', function () {
  const historyBtn = document.querySelector('[data-bs-target="#historyModal"]');
  if (historyBtn) {
    historyBtn.addEventListener('click', loadTripHistory);
  }
});



<!-- 預算計算器 JavaScript -->
<script>
    // 預算項目列表
    // Updated budget script: uses PHP instead of localStorage for saving budgets

    let budgetItems = [];
    let budgetTotal = 0;

    const itemPrices = {
        "火車票": 200,
        "公車": 50,
        "計程車": 300,
        "租車": 1500,
        "腳踏車租借": 100,
        "飯店": 3000,
        "民宿": 2000,
        "溫泉旅館": 2500,
        "早餐": 100,
        "午餐": 200,
        "晚餐": 300,
        "小吃": 150,
        "飲料": 50,
        "蘭陽博物館": 100,
        "傳統藝術中心": 150,
        "龜山島登島": 500,
        "賞鯨船票": 1000,
        "伴手禮": 300,
        "特產": 500,
        "紀念品": 250,
        "旅遊保險": 200,
        "醫療用品": 100,
        "活動費用": 800
    };
</script>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<ul id="itinerary-list" class="list-group mt-3"></ul>
</body>
</html>


<script>
// 自動帶入金額
document.addEventListener('DOMContentLoaded', function () {
    const categorySelect = document.getElementById('budget-category');
    const itemSelect = document.getElementById('budget-item');
    const amountInput = document.getElementById('budget-amount');

    const itemPrices = {
        "火車票": 200, "公車": 50, "計程車": 300, "租車": 1500, "腳踏車租借": 100,
        "飯店": 3000, "民宿": 2000, "溫泉旅館": 2500,
        "早餐": 100, "午餐": 200, "晚餐": 300, "小吃": 150, "飲料": 50,
        "蘭陽博物館": 100, "傳統藝術中心": 150, "龜山島登島": 500, "賞鯨船票": 1000,
        "伴手禮": 300, "特產": 500, "紀念品": 250,
        "旅遊保險": 200, "醫療用品": 100, "活動費用": 800
    };

    let budgetItems = [];
    let budgetTotal = 0;

    itemSelect.addEventListener('change', function () {
        const selectedItem = this.value;
        if (itemPrices[selectedItem] !== undefined) {
            amountInput.value = itemPrices[selectedItem];
            amountInput.readOnly = true;
        } else {
            amountInput.value = '';
            amountInput.readOnly = false;
        }
    });

    categorySelect.addEventListener('change', function () {
        document.querySelectorAll('#budget-item optgroup').forEach(group => group.style.display = 'none');
        const selectedGroup = document.querySelector(`.category-${this.value}`);
        if (selectedGroup) selectedGroup.style.display = 'block';
        itemSelect.selectedIndex = 0;
    });

    document.getElementById('add-budget').addEventListener('click', addBudgetItem);
    document.getElementById('save-budget').addEventListener('click', saveBudget);

    loadBudgetHistory(); // ✅ 正確的函式


    function addBudgetItem() {
        const category = categorySelect.value;
        const itemName = itemSelect.value;
        const amount = parseFloat(amountInput.value);
        const description = document.getElementById('budget-description').value || '';

        if (!category || !itemName || isNaN(amount) || amount <= 0) {
            showAlert('請填寫完整的預算項目資訊，金額必須大於零', 'danger');
            return;
        }

        budgetItems.push({ category, name: itemName, amount, description });
        budgetTotal += amount;
        updateBudgetList();
        resetBudgetForm();
        showAlert('已成功添加預算項目', 'success');
    }

    function updateBudgetList() {
        const budgetListEl = document.getElementById('budget-list');
        const budgetTotalEl = document.getElementById('budget-total');

        budgetListEl.innerHTML = '';
        budgetItems.forEach((item, index) => {
            const itemRow = document.createElement('div');
            itemRow.className = 'budget-item';
            itemRow.innerHTML = `
                <div><strong>${item.category} - ${item.name}</strong>${item.description ? `<br><small>${item.description}</small>` : ''}</div>
                <div class="d-flex align-items-center">
                    <span class="me-3">NT$${item.amount.toLocaleString()}</span>
                    <button class="remove-btn" onclick="removeBudgetItem(${index})">刪除</button>
                </div>
            `;
            budgetListEl.appendChild(itemRow);
        });

        if (budgetItems.length === 0) {
            budgetListEl.innerHTML = '<p class="text-center text-muted">尚未添加預算項目</p>';
            budgetTotalEl.textContent = '總預算: NT$0';
        } else {
            budgetTotalEl.textContent = `總預算: NT$${budgetTotal.toLocaleString()}`;
        }
    }

    window.removeBudgetItem = function (index) {
        budgetTotal -= budgetItems[index].amount;
        budgetItems.splice(index, 1);
        updateBudgetList();
        showAlert('已刪除預算項目', 'warning');
    };

    function resetBudgetForm() {
        categorySelect.selectedIndex = 0;
        itemSelect.selectedIndex = 0;
        amountInput.value = '';
        amountInput.readOnly = false;
        document.getElementById('budget-description').value = '';
        document.querySelectorAll('#budget-item optgroup').forEach(group => group.style.display = 'none');
    }

    function saveBudget() {
        const tripName = document.getElementById('trip-name').value;
        const tripDays = parseInt(document.getElementById('trip-days').value);
        const tripPeople = parseInt(document.getElementById('trip-people').value);

        if (!tripName || isNaN(tripDays) || tripDays <= 0 || isNaN(tripPeople) || tripPeople <= 0) {
            showAlert('請填寫完整的旅遊資訊', 'danger');
            return;
        }

        if (budgetItems.length === 0) {
            showAlert('請至少添加一個預算項目', 'danger');
            return;
        }

        const payload = {
            trip_name: tripName,
            trip_days: tripDays,
            trip_people: tripPeople,
            items: budgetItems,
            total: budgetTotal
        };

        console.log('送出的 payload:', payload);

        fetch('save_budget.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if (!data.success) {
                showAlert('❌ 儲存失敗: ' + data.error, 'danger');
                return;
            }

            resetBudgetForm();
            budgetItems = [];
            budgetTotal = 0;
            updateBudgetList();
            loadBudgetHistoryFromPHP();
            showAlert('✅ 預算已成功儲存！', 'success');
            document.getElementById('history-tab').click();
        })
        .catch(error => {
            showAlert('❌ 發生錯誤: ' + error.message, 'danger');
        });
    }

function loadBudgetHistory() {
  fetch("get_budgets.php")
    .then(res => res.json())
    .then(data => {
      const container = document.getElementById("budget-history-list");
      container.innerHTML = "";

      if (data.success && data.budgets.length > 0) {
        data.budgets.forEach(budget => {
          const div = document.createElement("div");
          div.className = "border p-3 mb-2";
          let itemsHTML = budget.items.map(i =>
             `<li>${i.category} - ${i.name}：NT$${i.amount}${i.description ? `（${i.description}）` : ""}</li>`
            ).join("");


          div.innerHTML = `
            <h5>${budget.trip_name}</h5>
            <ul>${itemsHTML}</ul>
            <strong>總預算：NT$${budget.total_budget}</strong>
          `;
          container.appendChild(div);
        });
      } else {
        container.innerHTML = "<p class='text-muted'>尚無歷史預算紀錄</p>";
      }
    })
    .catch(err => {
      alert("❌ 載入預算紀錄失敗：" + err.message);
    });
}


    function showAlert(message, type) {
        const alertEl = document.createElement('div');
        alertEl.className = `alert alert-${type} alert-dismissible fade show`;
        alertEl.role = 'alert';
        alertEl.innerHTML = `
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;

        const container = document.querySelector('.container');
        container.prepend(alertEl);

        setTimeout(() => {
            alertEl.classList.remove('show');
            setTimeout(() => alertEl.remove(), 150);
        }, 3000);
    }
});
</script>

<script>
    // 這裡是地圖的程式碼
    var map = L.map('map').setView([24.715782, 121.771709], 11); //設定地圖中心點

    // 地圖圖層
    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    // 多個地點資料
    var locations = [
    { name: '佛光大學', lat: 24.8188749, lng: 121.7189284 },
    { name: '羅東夜市', lat: 24.676766, lng: 121.766595 },
    { name: '冬山河親水公園', lat: 24.667682, lng: 121.791210 },
    { name: '國立傳統藝術中心', lat: 24.685347, lng: 121.832245 },
    { name: '蘭陽博物館', lat: 24.8694296, lng: 121.8311921 },
    { name: '五峰旗瀑布', lat: 24.827753, lng: 121.772799 },
    { name: '梅花湖', lat: 24.632239, lng: 121.742627 },
    { name: '宜蘭設治紀念館', lat: 24.754061, lng: 121.756107 },
    { name: '幾米公園', lat: 24.750692, lng: 121.757958 },
    { name: '清水地熱公園', lat: 24.503964, lng: 121.659506 }
];

    // 加上所有地點的標記
    
locations.forEach(loc => {
  var marker = L.marker([loc.lat, loc.lng]).addTo(map).bindPopup(loc.name);
  marker.on('click', function () {
    addPlaceToSchedule(loc);
    updateScheduleDisplay(); // ✅ 每次加入新行程就更新顯示區塊
  });
});


</script>