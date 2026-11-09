<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>main-series</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@picocss/pico@2/css/pico.min.css">
</head>
<body>
    <div class="container">
        <article style="text-align: center; padding: 2.5rem;">
            <hgroup>
                <h2>資料庫管理系統</h2>
                <p>請選擇要進入的功能模組</p>
            </hgroup>

            <!-- class="grid" 會自動把裡面的元素平均並排 -->
            <div class="grid" style="margin-top: 2rem;">
                <a href="series.php" role="button">Series 系列</a>
                <a href="manage.php" role="button" class="contrast">Manage 管理</a>
            </div>
        </article>
    </div>
</body>
</html>