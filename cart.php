<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

require_once 'connect.php';

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Vui lòng đăng nhập để xem giỏ hàng!'); window.location.href='login.php';</script>";
    exit();
}

$makh = $_SESSION['id'];

// Xử lý cập nhật số lượng
if (isset($_POST['add_to_cart'])) {
    $masp = $_POST['product_id'];
    $soluong = $_POST['quantity'];
    
    // Kiểm tra sản phẩm đã có trong giỏ hàng chưa
    $sql = "SELECT * FROM giohang WHERE makh = '$makh' AND masp = '$masp'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Cập nhật số lượng
        $sql = "UPDATE giohang SET soluong = '$soluong' WHERE makh = '$makh' AND masp = '$masp'";
    } else {
        // Thêm mới vào giỏ hàng
        $sql = "INSERT INTO giohang (makh, masp, soluong) VALUES ('$makh', '$masp', '$soluong')";
    }
    
    mysqli_query($conn, $sql);
    header('Location: cart.php');
    exit();
}

// Xử lý xóa sản phẩm khỏi giỏ hàng
if (isset($_GET['remove'])) {
    $masp = $_GET['remove'];
    $sql = "DELETE FROM giohang WHERE makh = '$makh' AND masp = '$masp'";
    mysqli_query($conn, $sql);
    header('Location: cart.php');
    exit();
}

// Lấy thông tin sản phẩm trong giỏ hàng
$cart_items = array();
$total = 0;

$sql = "SELECT g.*, s.* FROM giohang g
        JOIN sanpham s ON g.masp = s.masp 
        WHERE g.makh = '$makh'";
$result = mysqli_query($conn, $sql);

while ($row = mysqli_fetch_assoc($result)) {

    $row['subtotal'] = $row['giasp'] * $row['soluong'];
    $total += $row['subtotal'];
    $cart_items[] = $row;
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giỏ hàng</title>
    <link rel="stylesheet" href="css/cart.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

    <div class="container">
      
    <div class="cart-container">
         <a href="all.php" style="text-decoration: none; color: #000; font-size: 20px; font-weight: bold; margin-left: 20px; margin-top: 20px;"><i class="fas fa-arrow-left"></i></a>
        <h1><i class="fas fa-shopping-cart"></i> Giỏ hàng của bạn</h1>
        
        <?php if (empty($cart_items)): ?>
            <div class="empty-cart">
                <p>Giỏ hàng của bạn đang trống.</p>
                <a href="all.php">Tiếp tục mua sắm</a>
            </div>
        <?php else: ?>
            <?php foreach ($cart_items as $item): ?>
                <div class="cart-item">
                    <img src="./img/WAo/<?php echo $item['hinhanhsp']; ?>" alt="<?php echo $item['tensp']; ?>">
                    <div class="cart-item-details">
                        <h3><?php echo $item['tensp']; ?></h3>
                        <p class="cart-item-price"><?php echo number_format($item['giasp']); ?> VNĐ</p>
                        <div class="cart-item-quantity">
                            <form action="cart.php" method="post">
                                <input type="hidden" name="product_id" value="<?php echo $item['masp']; ?>">
                                <label>Số lượng:</label>
                                <input type="number" name="quantity" value="<?php echo $item['soluong']; ?>" min="1">
                                <button type="submit" name="add_to_cart"><i class="fas fa-sync-alt"></i> Cập nhật</button>
                            </form>
                            <a href="cart.php?remove=<?php echo $item['masp']; ?>" class="remove-btn" onclick="return confirm('Bạn có chắc muốn xóa sản phẩm này?')">
                                <i class="fas fa-trash-alt"></i> Xóa
                            </a>
                        </div>
                        <p class="subtotal">Tổng: <?php echo number_format($item['subtotal']); ?> VNĐ</p>
                    </div>
                </div>
            <?php endforeach; ?>
            
            <div class="cart-total">
                <p>Tổng cộng: <strong><?php echo number_format($total); ?> VNĐ</strong></p>
                    <a class="checkout-btn" href="checkout.php"><i class="fas fa-credit-card"></i> Thanh toán</a>
            </div>
        <?php endif; ?>
    </div>
    <?php
    include 'footer.php';
    ?>
    </div>
</body>
</html>
