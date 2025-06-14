<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "connect.php";

// Xử lý thêm vào giỏ hàng
if (isset($_POST['add_to_cart'])) {
    // Kiểm tra đăng nhập
    if (!isset($_SESSION['username'])) {
        echo "<script>alert('Vui lòng đăng nhập để thêm sản phẩm vào giỏ hàng!'); window.location.href='login.php';</script>";
        exit();
    }

    $masp = $_POST['product_id'];
    $makh = $_SESSION['id'];
    
    // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
    $sql = "SELECT * FROM giohang WHERE makh = '$makh' AND masp = '$masp'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Cập nhật số lượng nếu đã có
        $sql = "UPDATE giohang SET soluong = soluong + 1 WHERE makh = '$makh' AND masp = '$masp'";
    } else {
        // Thêm mới vào giỏ hàng
        $sql = "INSERT INTO giohang (makh, masp, soluong) VALUES ('$makh', '$masp', 1)";
    }
    
    mysqli_query($conn, $sql);
    echo "<script>alert('Đã thêm sản phẩm vào giỏ hàng!');</script>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/product.css">
    <title>Men - Dripped Stonie</title>
</head>
<body>
    <?php include "menu.php"; ?>
    <div class="muahang">
        <?php
        $sql = "SELECT * FROM sanpham WHERE loaisp ='Phụ Kiện'";
        $result = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="mua">
                <div class="anh2"><img src="./img/WAo/<?php echo $row['hinhanhsp']; ?>" alt=""></div>
                <p><?php echo $row['tensp']; ?></p>
                <div>
                    <p><?php echo number_format($row['giasp']); ?><u>đ</u></p>
                </div>
                <form action="" method="post">
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