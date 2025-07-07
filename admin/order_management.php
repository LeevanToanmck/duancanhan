<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "../connect.php";
// Kiểm tra đăng nhập admin
if (!isset($_SESSION['username']) || $_SESSION['level'] != 1) {
    header("Location: ../login.php");
    exit();
}

// Xử lý cập nhật trạng thái đơn hàng
if (isset($_POST['update_status'])) {
    $madh = $_POST['madh'];
    $trangthai = $_POST['trangthai'];
    
    $sql = "UPDATE donhang SET trangthai = ? WHERE madh = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $trangthai, $madh);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);
}

// Lấy danh sách đơn hàng
$sql = "SELECT d.*, k.hoten, k.sdt, k.email 
        FROM donhang d 
        JOIN thanhvien k ON d.makh = k.makh 
        ORDER BY d.ngaydat DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý đơn hàng - Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        .order-list {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .order-item {
            border-bottom: 1px solid #eee;
            padding: 20px;
        }
        .order-item:last-child {
            border-bottom: none;
        }
        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
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
        .customer-info {
            margin: 15px 0;
            padding: 15px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        .customer-info p {
            margin: 5px 0;
            color: #555;
        }
        .product-list {
            margin: 15px 0;
        }
        .product-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            margin-bottom: 10px;
        }
        .product-image {
            width: 60px;
            height: 60px;
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
        .product-price, .product-quantity {
            color: #666;
            font-size: 0.9em;
        }
        .order-total {
            text-align: right;
            font-weight: bold;
            font-size: 1.1em;
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #eee;
        }
        .status-select {
            padding: 8px;
            border-radius: 4px;
            border: 1px solid #ddd;
            margin-right: 10px;
        }
        .update-btn {
            padding: 8px 15px;
            background-color: #4a90e2;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .update-btn:hover {
            background-color: #357abd;
        }
        .status-badge {
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
        .status-cancelled {
            background-color: #f8d7da;
            color: #721c24;
        }
        .order-actions {
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .view-details {
            padding: 8px 15px;
            background-color: #28a745;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
        }
        .view-details:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <?php include "admin_header.php"; ?>
    
    <div class="container">
        <h1>Quản lý đơn hàng</h1>
        
        <div class="order-list">
            <?php while ($order = mysqli_fetch_assoc($result)): 
                // Lấy chi tiết sản phẩm của đơn hàng
                $sql = "SELECT c.*, s.tensp, s.hinhanhsp 
                        FROM chitietdonhang c 
                        JOIN sanpham s ON c.masp = s.masp 
                        WHERE c.madh = ?";
                $stmt = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt, "i", $order['madh']);
                mysqli_stmt_execute($stmt);
                $products_result = mysqli_stmt_get_result($stmt);
                $order_total = 0;
            ?>
                <div class="order-item">
                    <div class="order-header">
                        <div class="order-info">
                            <div class="order-number">Đơn hàng #<?php echo $order['madh']; ?></div>
                            <div class="order-date">Ngày đặt: <?php echo date('d/m/Y H:i', strtotime($order['ngaydat'])); ?></div>
                        </div>
                        <div class="order-actions">
                            <form method="post" style="display: inline;">
                                <input type="hidden" name="madh" value="<?php echo $order['madh']; ?>">
                                <select name="trangthai" class="status-select">
                                    <option value="Chờ xác nhận" <?php echo $order['trangthai'] == 'Chờ xác nhận' ? 'selected' : ''; ?>>Chờ xác nhận</option>
                                    <option value="Đã xác nhận" <?php echo $order['trangthai'] == 'Đã xác nhận' ? 'selected' : ''; ?>>Đã xác nhận</option>
                                    <option value="Đang giao hàng" <?php echo $order['trangthai'] == 'Đang giao hàng' ? 'selected' : ''; ?>>Đang giao hàng</option>
                                    <option value="Đã giao hàng" <?php echo $order['trangthai'] == 'Đã giao hàng' ? 'selected' : ''; ?>>Đã giao hàng</option>
                                    <option value="Đã hủy" <?php echo $order['trangthai'] == 'Đã hủy' ? 'selected' : ''; ?>>Đã hủy</option>
                                </select>
                                <button type="submit" name="update_status" class="update-btn">Cập nhật</button>
                            </form>
                            <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $order['trangthai'])); ?>">
                                <?php echo $order['trangthai']; ?>
                            </span>
                        </div>
                    </div>

                    <div class="customer-info">
                        <p><strong>Khách hàng:</strong> <?php echo $order['ten']; ?></p>
                        <p><strong>Số điện thoại:</strong> <?php echo $order['sdt']; ?></p>
                        <p><strong>Email:</strong> <?php echo $order['email']; ?></p>
                        <p><strong>Địa chỉ giao hàng:</strong> <?php echo $order['diachigiaohang']; ?></p>
                        <p><strong>Phương thức thanh toán:</strong> <?php echo $order['phuongthuctt']; ?></p>
                        <?php if (!empty($order['ghichu'])): ?>
                            <p><strong>Ghi chú:</strong> <?php echo $order['ghichu']; ?></p>
                        <?php endif; ?>
                    </div>

                    <div class="product-list">
                        <?php while ($product = mysqli_fetch_assoc($products_result)): 
                            $subtotal = $product['soluong'] * $product['dongia'];
                            $order_total += $subtotal;
                        ?>
                            <div class="product-item">
                                <img src="../img/WAo/<?php echo $product['hinhanhsp']; ?>" alt="<?php echo $product['tensp']; ?>" class="product-image">
                                <div class="product-details">
                                    <div class="product-name"><?php echo $product['tensp']; ?></div>
                                    <div class="product-price"><?php echo number_format($product['dongia']); ?> VNĐ</div>
                                    <div class="product-quantity">Số lượng: <?php echo $product['soluong']; ?></div>
                                </div>
                                <div class="product-subtotal">
                                    <?php echo number_format($subtotal); ?> VNĐ
                                </div>
                            </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="order-total">
                        Tổng cộng: <?php echo number_format($order_total); ?> VNĐ
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>
</body>
</html> 