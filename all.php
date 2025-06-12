<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="css/product.css">
    <title>ALL - Dripped Stonie</title>
</head>

<body>
    <?php include "menu.php"; ?>
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
                    <p><?php echo number_format($row['giasp']); ?><u>đ</u></p>
                    </div>
                    <form action="product.php" method="post">
                    <input type="hidden" name="product_id" value="<?php echo $row['masp']; ?>">
                    <input type="submit" name="add_to_cart" value="Thêm vào giỏ" class="btn">
                </form>
                </div>
            <?php
        }

        ?>
    </div>
    <?php include "footer.php"; ?>
</body>

</html>