<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tìm kiếm sản phẩm</title>
    <link rel="stylesheet" href="css/product.css">
    <style>

        .search-container {
            text-align: center;
            margin: 20px;
            position: relative;
        }

        .search-box {
            display: none;
            margin-top: 10px;
        }

        .search-icon {
            font-size: 24px;
            cursor: pointer;
        }

        .search-form input[type="text"] {
            padding: 6px;
            width: 250px;
        }

        .search-form button {
            padding: 6px 10px;
        }
    </style>
</head>
<body>


<div class="search-container">
    <!-- Biểu tượng tìm kiếm -->
    <span class="search-icon" onclick="toggleSearch()">Tìm kiếm</span>

    <!-- Form tìm kiếm ẩn/hiện -->
    <div class="search-box" id="searchBox">
        <form class="search-form" method="GET" action="">
            <input type="text" name="keyword" placeholder="Nhập tên sản phẩm..." 
                   value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>">
            <button type="submit">Tìm</button>
        </form>
    </div>
</div>

<div class="muahang">
    <?php
    include "connect.php";

    $keyword = "";
    if (isset($_GET['keyword'])) {
        $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
        $sql = "SELECT * FROM sanpham WHERE tensp LIKE '%$keyword%'";
    } else {
        $sql = "SELECT * FROM sanpham";
    }

    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
            <a href="">
                <div class="mua" style="width: 300px; border: 1px solid #ccc; padding: 10px; margin: 10px; display: inline-block;">
                    <div class="anh2">
                        <img src="./img/WAo/<?php echo $row['hinhanhsp']; ?>" alt="" style="width: 100%;">
                    </div>
                    <p><strong><?php echo $row['tensp']; ?></strong></p>
                    <p><?php echo $row['giasp']; ?> đ</p>
                    <input type="button" value="Xem chi tiết" class="btn">
                </div>
            </a>
            <?php
        }
    } else {
        echo "<p style='text-align: center;'>Không tìm thấy sản phẩm nào phù hợp.</p>";
    }
    ?>
</div>

</body>
</html>
