<?php
if (session_status() == PHP_SESSION_NONE)
    session_start();

// Giả sử giỏ hàng lưu trong $_SESSION['cart'] dạng: [masp => soluong]
include "../connect.php";

// Lấy thông tin sản phẩm trong giỏ hàng
$cart_items = [];
$total = 0;
if (isset($_SESSION['id'])) {
    $makh = $_SESSION['id'];
    $sql = "SELECT g.soluong, s.*
            FROM giohang g
            JOIN sanpham s ON g.masp = s.masp
            WHERE g.makh = '$makh'";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $row['thanhtien'] = $row['giasp'] * $row['soluong'];
        $total += $row['thanhtien'];
        $cart_items[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thanh toán</title>
    <link rel="stylesheet" href="../css/checkout.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>

<body>
    <div class="container">
        <a href="cart.php" class="back-button">
            <i class="fas fa-arrow-left"></i>
        </a>
        <?php if (empty($cart_items)): ?>
            <div class="empty-cart">
                <h2>Giỏ hàng của bạn đang trống</h2>
                <p><a href="index.php">Tiếp tục mua sắm</a></p>
            </div>
        <?php else: ?>
            <form class="checkout-container" method="post" action="process_order.php">
                <div class="checkout-form">
                    <h2>Thông tin thanh toán</h2>
                    <div class="row">
                        <div>
                            <label>Họ và tên *</label>
                            <input type="text" name="hoten" required>
                        </div>
                        <div>
                            <label>Số điện thoại *</label>
                            <input type="text" name="sdt" required>
                        </div>
                    </div>
                    <label>Địa chỉ *</label>
                    <input type="text" name="diachi" required>
                    <label>Địa chỉ email *</label>
                    <input type="email" name="email" required>
                    <div>

                    </div>
                    <label>Ghi chú (tuỳ chọn)</label>
                    <textarea name="note"
                        placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."></textarea>
                    <label>Phương thức thanh toán *</label>
                    <select class="pttt" name="phuongthuctt" required>
                        <option value="Chuyển khoản">Chuyển khoản</option>
                        <option value="Thanh toán khi nhận hàng">Thanh toán khi nhận hàng</option>
                    </select>
                    <button type="submit">Đặt hàng</button>
                </div>
                <div class="order-summary">
                    <h3>Đơn hàng của bạn</h3>
                    <?php foreach ($cart_items as $item): ?>
                        <div class="order-product">
                            <img src="../img/WAo/<?php echo $item['hinhanhsp']; ?>" alt="<?php echo $item['tensp']; ?>">
                            <div class="order-product-info">
                                <b><?php echo $item['tensp']; ?></b>
                                <div class="order-label">Số lượng: <?php echo $item['soluong']; ?></div>
                                <div class="order-label">Đơn giá: <?php echo number_format($item['giasp']); ?> VNĐ</div>
                            </div>
                            <div class="order-total"><?php echo number_format($item['thanhtien']); ?> VNĐ</div>
                        </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="order-label">Tạm tính</div>
                    <div class="order-total"><?php echo number_format($total); ?> VNĐ</div>
                    <div class="order-label">Giao hàng</div>
                    <div>Giao hàng miễn phí</div>
                    <hr>
                    <div class="order-total">Tổng: <?php echo number_format($total); ?> VNĐ</div>
                </div>
            </form>
        <?php endif; ?>
    </div>
    <?php include "footer.php"; ?>
</body>

</html>