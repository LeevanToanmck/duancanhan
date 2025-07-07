<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../connect.php";

// Kiểm tra đăng nhập
if (!isset($_SESSION['username'])) {
    echo "<script>alert('Vui lòng đăng nhập để xem đơn hàng!'); window.location.href='login.php';</script>";
    exit();
}

$makh = $_SESSION['id'];

// Lấy thông tin đơn hàng và chi tiết sản phẩm
$sql = "SELECT d.*, c.soluong, c.dongia, s.tensp, s.hinhanhsp 
        FROM donhang d 
        JOIN chitietdonhang c ON d.madh = c.madh 
        JOIN sanpham s ON c.masp = s.masp 
        WHERE d.makh = '$makh' 
        ORDER BY d.ngaydat DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chi tiết đơn hàng - Dripped Stonie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="../css/order_details.css">
</head>
<body>
<?php
        include 'menu.php';
        include 'product.php';
        ?>
    
  
            
       <center><h1>Đơn hàng của tôi</h1></center>       
        <?php if (mysqli_num_rows($result) > 0): ?>
            <div class="order-list">
                <?php 
                $current_order = null;
                $order_total = 0;
                
                while ($row = mysqli_fetch_assoc($result)): 
                    if ($current_order !== $row['madh']):
                        if ($current_order !== null):
                ?>
                            <div class="order-total">
                                Tổng cộng: <?php echo number_format($order_total); ?> VNĐ
                            </div>
                        </div>
                        <?php 
                        endif;
                        $current_order = $row['madh'];
                        $order_total = 0;
                ?>
                        <div class="order-item">    
                            <div class="order-header">
                                <div class="order-info">
                                    <div class="order-number">Mã đơn hàng #<?php echo $row['madh']; ?></div>
                                    <div class="order-date">Ngày đặt: <?php echo date('d/m/Y', strtotime($row['ngaydat'])); ?></div>
                                </div>
                                <div class="order-status <?php echo 'status-' . strtolower(str_replace(' ', '-', $row['trangthai'])); ?>">
                                    <?php echo $row['trangthai']; ?>
                                </div>
                            </div>
                            <div class="product-list">
                <?php 
                    endif;
                    $order_total += $row['soluong'] * $row['dongia'];
                ?>
                            <div class="product-item">
                                <img src="../img/WAo/<?php echo $row['hinhanhsp']; ?>" alt="<?php echo $row['tensp']; ?>" class="product-image">
                                <div class="product-details">
                                    <div class="product-name"><?php echo $row['tensp']; ?></div>
                                    <div class="product-price"><?php echo number_format($row['dongia']); ?> VNĐ</div>
                                    <div class="product-quantity">Số lượng: <?php echo $row['soluong']; ?></div>
                                </div>
                            </div>
                <?php 
                endwhile;
                if ($current_order !== null):
                ?>
                            <div class="order-total">
                                Tổng cộng: <?php echo number_format($order_total); ?> VNĐ
                            </div>
                        </div>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <div class="no-orders">
                <i class="fas fa-shopping-bag"></i>
                <p>Bạn chưa có đơn hàng nào</p>
                <a href="index.php" class="continue-shopping">Tiếp tục mua sắm</a>
            </div>

        <?php endif; ?>
        
    </div>
</body>
</html> 