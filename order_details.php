<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "connect.php";

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
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
        }
        .order-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .order-item {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 20px;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
            margin-bottom: 15px;
        }
        .order-info {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }
        .order-number {
            font-weight: bold;
            font-size: 1.1em;
            color: #333;
        }
        .order-date {
            color: #666;
            font-size: 0.9em;
        }
        .order-status {
            padding: 5px 10px;
            border-radius: 4px;
            font-size: 0.9em;
            font-weight: 500;
        }
        .status-pending {
            background-color: #fff3cd;
            color: #856404;
        }
        .status-confirmed {
            background-color: #d4edda;
            color: #155724;
        }
        .status-shipped {
            background-color: #cce5ff;
            color: #004085;
        }
        .status-delivered {
            background-color: #d1e7dd;
            color: #0f5132;
        }
        .product-list {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }
        .product-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px;
            border-radius: 4px;
            background-color: #f8f9fa;
        }
        .product-image {
            width: 80px;
            height: 80px;
            object-fit: cover;
            border-radius: 4px;
        }
        .product-details {
            flex: 1;
        }
        .product-name {
            font-weight: 500;
            margin-bottom: 5px;
        }
        .product-price {
            color: #666;
            font-size: 0.9em;
        }
        .product-quantity {
            color: #666;
            font-size: 0.9em;
        }
        .order-total {
            text-align: right;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
            font-weight: bold;
            font-size: 1.1em;
        }
        .no-orders {
            text-align: center;
            padding: 40px;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .no-orders i {
            font-size: 48px;
            color: #ccc;
            margin-bottom: 15px;
        }
        .no-orders p {
            color: #666;
            margin-bottom: 20px;
        }
        .continue-shopping {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .continue-shopping:hover {
            background-color: #357abd;
        }
    </style>
</head>
<body>
    
    <div class="container">
        <h1>Đơn hàng của tôi</h1>
        
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
                                    <div class="order-number">Đơn hàng #<?php echo $row['madh']; ?></div>
                                    <div class="order-date">Ngày đặt: <?php echo date('d/m/Y H:i', strtotime($row['ngaydat'])); ?></div>
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
                                <img src="./img/WAo/<?php echo $row['hinhanhsp']; ?>" alt="<?php echo $row['tensp']; ?>" class="product-image">
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