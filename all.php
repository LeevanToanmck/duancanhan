<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="css/product.css">
    <title>Document</title>
</head>

<body>
    <div class="muahang">
        <?php

        include "connect.php";
        $sql = "SELECT * FROM sanpham";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="mua">
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

        ?>
    </div>

</body>

</html>