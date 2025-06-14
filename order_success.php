<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "connect.php";

if (!isset($_GET['order_id'])) {
    header("Location: index.php");
    exit();
}

$order_id = $_GET['order_id'];
$sql = "SELECT * FROM donhang WHERE madh= '$order_id'";
$result = mysqli_query($conn, $sql);
$order = mysqli_fetch_assoc($result);

// Lấy chi tiết đơn hàng
$sql = "SELECT c.*, s.tensp, s.hinhanhsp 
        FROM chitietdonhang c 
        JOIN sanpham s ON c.masp = s.masp 
        WHERE c.madh = '$order_id'";
$result = mysqli_query($conn, $sql);
$order_items = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đặt hàng thành công - Dripped Stonie</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
            min-height: 100vh;
        }
        .success-container {
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        }
        .success-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .success-icon {
            color: #28a745;
            font-size: 64px;
            margin-bottom: 20px;
        }
        .success-title {
            color: #28a745;
            font-size: 24px;
            margin-bottom: 10px;
        }
        .order-info {
            margin-bottom: 30px;
        }
        .order-info h3 {
            color: #333;
            margin-bottom: 15px;
        }
        .info-item {
            margin-bottom: 10px;
        }
        .info-label {
            font-weight: 500;
            color: #555;
        }
        .order-items {
            margin-bottom: 30px;
        }
        .order-item {
            display: flex;
            align-items: center;
            padding: 15px;
            border-bottom: 1px solid #eee;
        }
        .item-image {
            width: 80px;
            height: 80px;
            margin-right: 15px;
        }
        .item-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 6px;
        }
        .item-details {
            flex-grow: 1;
        }
        .item-name {
            font-weight: 500;
            margin-bottom: 5px;
        }
        .item-price {
            color: #666;
        }
        .item-quantity {
            color: #666;
            margin-left: 10px;
        }
        .total-amount {
            text-align: right;
            font-size: 20px;
            font-weight: 500;
            color: #333;
            margin-top: 20px;
        }
        .back-button {
            display: inline-block;
            padding: 12px 24px;
            background-color: #4a90e2;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: background-color 0.3s ease;
        }
        .back-button:hover {
            background-color: #357abd;
        }
        .button-container {
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>
<body>

    
    <div class="success-container">
        <div class="success-header">
            <i class="fas fa-check-circle success-icon"></i>
            <h1 class="success-title">Đặt hàng thành công!</h1>
            <p>Cảm ơn bạn đã đặt hàng. Chúng tôi sẽ xử lý đơn hàng của bạn sớm nhất có thể.</p>
        </div>

        <div class="order-info">
            <h3>Thông tin đơn hàng</h3>
            <div class="info-item">
                <span class="info-label">Mã đơn hàng:</span>
                #<?php echo $order['madh']; ?>
            </div>
            <div class="info-item">
                <span class="info-label">Ngày đặt:</span>
                <?php echo date('d/m/Y ', strtotime($order['ngaydat'])); ?>
            </div>
            <div class="info-item">
                <span class="info-label">Trạng thái:</span>
                <?php echo $order['trangthai']; ?>
            </div>
            <div class="info-item">
                <span class="info-label">Phương thức thanh toán:</span>
                <?php echo $order['phuongthuctt']; ?>
            </div>
        </div>

        <div class="order-items">
            <h3>Chi tiết đơn hàng</h3>
            <?php 
            $total = 0;
            foreach ($order_items as $item): 
                $item['subtotal'] = $item['soluong'] * $item['dongia'];
            ?>
            <div class="order-item">
                <div class="item-image">
                    <img src="./img/WAo/<?php echo $item['hinhanhsp']; ?>" alt="<?php echo $item['tensp']; ?>">
                </div>
                <div class="item-details">
                    <div class="item-name"><?php echo $item['tensp']; ?></div>
                    <div class="item-price">
                        <?php echo number_format($item['dongia']); ?>đ
                        <span class="item-quantity">x <?php echo $item['soluong']; ?></span>
                    </div>
                </div>
                <div class="item-total">
                    <?php echo number_format($item['subtotal']); ?>đ
                </div>
            </div>      

            <?php endforeach; ?>
            
            <div class="total-amount">
                Tổng cộng: <?php echo number_format($order['tongtien']); ?>đ
            </div>
        </div>

        <div class="button-container">
            <a href="index.php" class="back-button">Tiếp tục mua sắm</a>
        </div>
    </div>

</body>
</html> 