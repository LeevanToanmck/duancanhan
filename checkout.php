<?php
if (session_status() == PHP_SESSION_NONE) session_start();

// Giả sử giỏ hàng lưu trong $_SESSION['cart'] dạng: [masp => soluong]
include "connect.php";

// Lấy thông tin sản phẩm trong giỏ hàng
$cart_items = [];
$total = 0;
if (!empty($_SESSION['cart'])) {
    $ids = implode(',', array_keys($_SESSION['cart']));
    $sql = "SELECT * FROM sanpham WHERE masp IN ($ids)";
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $row['soluong'] = $_SESSION['cart'][$row['masp']];
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
    <title>Đặt hàng</title>
    <style>
        body { font-family: Arial, sans-serif; background: #fafafa; }
        .checkout-container { max-width: 1200px; margin: 30px auto; display: flex; gap: 40px; }
        .checkout-form { 
        
        flex: 2; background: #fff; padding: 30px; border-radius: 8px; }
        .container{margin-top: 80px;}.order-summary { flex: 1; background: #fff; padding: 30px; border-radius: 8px; }
        .order-product { display: flex; align-items: center; margin-bottom: 20px; }
        .order-product img { width: 80px; height: 80px; object-fit: cover; margin-right: 15px; }
        .order-product-info { flex: 1; }
        .order-total { font-weight: bold; font-size: 1.2em; }
        .order-label { color: #888; }
        .bank-logos img { height: 30px; margin-right: 10px; }
        .checkout-form input, .checkout-form textarea { width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc; border-radius: 4px; }
        .checkout-form label { font-weight: bold; }
        .checkout-form .row { display: flex; gap: 20px; }
        .checkout-form .row > div { flex: 1; }
        .checkout-form button { background: #222; color: #fff; padding: 12px 30px; border: none; border-radius: 4px; font-size: 1em; cursor: pointer; }
        .order-summary h3 { margin-top: 0; }
        .order-summary .order-total { color: #222; }
        .order-summary .order-label { font-size: 0.95em; }
    </style>
</head>
<body>
    <?php include "menu.php"; ?>
    <div class="container">
    <div style="background:#000;color:#fff;padding:16px 0;text-align:center;margin-bottom:30px;">
        Bạn có mã ưu đãi? Ấn vào đây để nhập mã
    </div>
    <form class="checkout-container" method="post" action="process_checkout.php">
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
            <label>Thị trấn / Thành phố *</label>
            <input type="text" name="thanhpho" required>
            <label>Địa chỉ email *</label>
            <input type="email" name="email" required>
            <div>
                
                <label for="gift">Mua làm quà tặng</label><input type="checkbox" name="gift" id="gift">
            </div>
            <label>Nội dung thiệp (tuỳ chọn)</label>
            <textarea name="note" placeholder="Ghi chú về đơn hàng, ví dụ: thời gian hay chỉ dẫn địa điểm giao hàng chi tiết hơn."></textarea>
            <button type="submit">Đặt hàng</button>
        </div>
        <div class="order-summary">
            <h3>Đơn hàng của bạn</h3>
            <?php if (empty($cart_items)): ?>
                <p>Giỏ hàng trống.</p>
            <?php else: ?>
                <?php foreach ($cart_items as $item): ?>
                    <div class="order-product">
                        <img src="./img/WAo/<?php echo $item['hinhanhsp']; ?>" alt="">
                        <div class="order-product-info">
                            <div><b><?php echo $item['tensp']; ?></b></div>
                            <div class="order-label">Số lượng: <?php echo $item['soluong']; ?></div>
                        </div>
                        <div><?php echo number_format($item['giasp']); ?> đ</div>
                    </div>
                <?php endforeach; ?>
                <hr>
                <div class="order-label">Tạm tính</div>
                <div><?php echo number_format($total); ?> đ</div>
                <div class="order-label">Giao hàng</div>
                <div>Giao hàng miễn phí</div>
                <div class="order-total">Tổng: <?php echo number_format($total); ?> đ</div>
                <hr>
                <div class="order-label">Chuyển khoản ngân hàng (Quét mã QR)</div>
                <div class="bank-logos">
                    <img src="img/vietinbank.png" alt="VietinBank">
                    <img src="img/vietcombank.png" alt="Vietcombank">
                    <img src="img/bidv.png" alt="BIDV">
                    <img src="img/agribank.png" alt="Agribank">
                    <img src="img/ocb.png" alt="OCB">
                </div>
                <div style="font-size:0.95em;color:#666;margin-top:10px;">
                    Sau khi đặt hàng, vui lòng chuyển khoản bằng cách quét mã QR dưới đây
                </div>
            <?php endif; ?>
        </div>
    </form></div>
    <?php include "footer.php"; ?>
</body>
</html>