<?php
    // 1. 資料庫連線設定 (MariaDB)
    $host = 'localhost';
    $dbname = 'testDB'; // 請換成您剛創的資料庫名稱
    $username = 'testUser';     // 請換成您的 MariaDB 帳號
    $password = 'weHaveToTest';     // 請換成您的 MariaDB 密碼

    try {
        $dsn = "mysql:host=$host;dbname=$dbname;charset=utf8mb4";
        $pdo = new PDO($dsn, $username, $password, [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ]);

        // 2. 查詢 series 資料表
        $stmt = $pdo->query("SELECT * FROM series ORDER BY SeriesID ASC");
        $seriesList = $stmt->fetchAll();

    } catch (PDOException $e) {
        $errorMsg = "資料庫連線或查詢失敗：" . $e->getMessage();
        $seriesList = [];
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>series</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <main class="container">
        <!-- 頂部導覽列：對應架構圖 main.php -> series.php -> series_edit.php -->
        <nav>
            <ul>
                <li><strong>系列管理系統</strong></li>
    		</ul>
            <ul>
                <li><a href="main.php" class="secondary">← 返回主頁(main.php)</a></li>
                <li><a href="series_edit.php" role="button">管理 / 編輯系列 (series_edit.php)</a></li>
    		</ul>
        </nav>

        <article>
            <header>
                <h2 style="margin-bottom: 0;">Series 資料表一覽</h2>
    		</header>

            <?php if (!empty($errorMsg)): ?>
                <p style="color: var(--pico-del-color);"><?=htmlspecialchars($errorMsg) ?></p>
            <?php endif; ?>

            <!-- Pico CSS 響應式捲動表格 -->
    		<div class="overflow-auto">
                <?php
                    // 如果有連線或 SQL 錯誤，直接印出紅字
                    if (!empty($errorMsg)) {
    			echo '<p style="color: red; font-weight: bold;">' . htmlspecialchars($errorMsg) . '</p>';
                    }

                    // 如果有抓到資料，就畫出表格
                    if (count($seriesList) > 0) {
    			echo '<table>';

                        // 印出表頭 (自動抓取真實欄位名稱)
                        echo '<thead><tr>';
    			foreach (array_keys($seriesList[0]) as $colName) {
                            echo '<th scope="col">' . htmlspecialchars((string)$colName) . '</th>';
    			}
    			echo '</tr></thead>';

                        // 印出每一列資料
    			echo '<tbody>';
    			foreach ($seriesList as $row) {
                            echo '<tr>';
                            foreach ($row as $value) {
    				echo '<td>' . htmlspecialchars((string)$value) . '</td>';
                            }
                            echo '</tr>';
    			}
    			echo '</tbody>';

    			echo '</table>';
                    } else {
                        echo '<p>目前沒有抓到任何資料。（若上方有紅字錯誤訊息，請參考紅字說明）</p>';
                    }
                    ?>
            </div>
        </article>
    </main>
</body>
</html>