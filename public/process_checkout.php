<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
    
}
// Kiểm tra xem có sản phẩm trong giỏ hàng không
if (empty($_SESSION['cart'])) {
    // Nếu giỏ hàng trống, chuyển về trang chủ
    header("Location: ../index.php");
    exit();
}
// Nếu có sản phẩm trong giỏ hàng, chuyển đến trang checkout
header("Location: ../checkout.php");
exit();
?>