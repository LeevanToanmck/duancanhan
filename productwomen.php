
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/product.css">
    <title>Women-Dripped Stonie</title>
</head>
<body>
    
    <div class="muahang">
        <?php
        // Kết nối đến cơ sở dữ liệ
        include "connect.php";
        include "menu.php"; // Bao gồm menu
        // Lấy danh sách sản phẩm của nữ từ cơ sở dữ liệu
        $sql = "SELECT * FROM sanpham WHERE loaisp ='Nữ'";
        $result = mysqli_query($conn, $sql);
        ?>
        <div class="muahang">
        <?php
        while ($row = mysqli_fetch_assoc($result)) {
            ?>
                <div class="mua" width="300px">
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
        include "footer.php";
        ?>
    </div>
</body>
</html>