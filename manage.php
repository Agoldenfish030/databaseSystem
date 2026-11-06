<?php
    // 1. 資料庫連線設定
    $host = 'localhost';
    $dbname = 'testDB'; // 👈 請換成您的資料庫名稱
    $username = 'testUser';     // 👈 請換成您的帳號
    $password = 'weHaveToTest';     // 👈 請換成您的密碼

    $errorMsg = '';
    $categoryList = [];
    $genreList = [];

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        // 2. 分別查詢 category 與 genre 兩張資料表
        $stmtCat = $pdo->query("SELECT * FROM category");
        $categoryList = $stmtCat->fetchAll();

        $stmtGen = $pdo->query("SELECT * FROM genre");
        $genreList = $stmtGen->fetchAll();

    } catch (PDOException $e) {
        $errorMsg = "資料庫連線或查詢失敗：" . $e->getMessage();
    }

    // 3. 用來畫表格的共用函式（自動抓取那 2 個 attribute 欄位）
    function renderTable($dataList) {
        if (count($dataList) > 0) {
            echo '<table class="striped">';

            // 印出表頭 (2 個 attribute 名稱)
            echo '<thead><tr>';
            foreach (array_keys($dataList[0]) as $colName) {
                echo '<th scope="col">' . htmlspecialchars((string)$colName) . '</th>';
            }
            echo '</tr></thead>';

            // 印出每一列資料
            echo '<tbody>';
            foreach ($dataList as $row) {
                echo '<tr>';
                foreach ($row as $value) {
                    echo '<td>' . htmlspecialchars((string)$value) . '</td>';
                }
                echo '</tr>';
            }
            echo '</tbody>';

            echo '</table>';
        } else {
            echo '<p>目前此表格沒有任何資料。</p>';
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>manage</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <main class="container">
            <!-- 頂部導覽列：對應架構圖 main.php -> manage.php -> manage_save.php -->
            <nav>
                <ul>
                    <li><strong>分類與類型管理 (Manage)</strong></li>
    		</ul>
                <ul>
                    <li><a href="main.php" class="secondary">← 返回主頁 (main.php)</a></li>
                    <li><a role="button">編輯類型與風格</a></li>
    		</ul>
            </nav>

            <?php
            if (!empty($errorMsg)) {
                echo '<p style="color: red; font-weight: bold;">' . htmlspecialchars($errorMsg) . '</p>';
            }
            ?>

            <!-- 使用 Pico CSS 的 grid 讓兩個表格左右並排（手機螢幕會自動變上下排列） -->
            <div class="grid">
                <!-- 第一個表格：Category -->
    		<article>
                    <header>
                        <h3 style="margin-bottom: 0;">Category 資料表</h3>
                    </header>
                    <div class="overflow-auto">
    			<?php renderTable($categoryList); ?>
                    </div>
                </article>

                <!-- 第二個表格：Genre -->
                <article>
                    <header>
                        <h3 style="margin-bottom: 0;">Genre 資料表</h3>
                    </header>
                    <div class="overflow-auto">
    			<?php renderTable($genreList); ?>
                    </div>
                </article>
            </div>
        </main>
</body>
</html>