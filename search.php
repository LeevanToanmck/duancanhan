<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/product.css">
    <title>Document</title>
</head>
<body>


<?php
    // search.php
    include "connect.php";
    include "menu.php"; // Bao gồm menu?>
    <div class="muahang">
        <br>
    <?php
    $keyword = "";
    if (isset($_GET['keyword'])) {
        $keyword = mysqli_real_escape_string($conn, $_GET['keyword']);
        $sql = "SELECT * FROM sanpham WHERE tensp LIKE '%$keyword%'";
    } else {
        $sql = "SELECT * FROM sanpham";
    }
    ?>
    <?php

    echo "<h2 style =' width :1500px; height:30px; margin-top:12px;'>Kết quả tìm kiếm cho: <span>$keyword</span></h2> <br>";
    ?>

    <br>
    <?php
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) > 0) {
        
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="mua" width="300px">
                    <div class="anh2"><img src="./img/WAo/<?php echo $row['hinhanhsp']; ?>" alt=""></div>
                    <p><?php echo $row['tensp']; ?>
                        <br>
                    <div>
                        <p><?php echo $row['giasp']; ?>đ</p>
                    </div>
                    <input type="button" value="Thêm vào giỏ" class="btn">
                </div>

            <?php
        }
    } else {
        echo " <center><h2 style='text-align: center;'>Không tìm thấy sản phẩm nào phù hợp.</h2></center>";
    }
    include "footer.php";
    echo "</div>"; 
    ?>

    </body>
</html>