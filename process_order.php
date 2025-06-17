<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
include "connect.php";

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $makh = $_SESSION['id'];
    $hoten = $_POST['hoten'];
    $diachigiaohang = $_POST['diachi'];
    $sdtgiaohang = $_POST['sdt'];
    $note = $_POST['note'];
    $phuongthuctt = $_POST['phuongthuctt'];
    $ngaydat = date('Y-m-d H:i:s');
    $trangthai = 'Chờ xác nhận';

    // Tính tổng tiền từ giỏ hàng
    $tongtien = 0;
    $sql = "SELECT g.*, s.giasp FROM giohang g JOIN sanpham s ON g.masp = s.masp WHERE g.makh = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $makh);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $cart_items = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $tongtien += $row['soluong'] * $row['giasp'];
        $cart_items[] = $row;
    }
    mysqli_stmt_close($stmt);

    // Thêm đơn hàng vào bảng donhang
    $sql = "INSERT INTO donhang (makh, hoten, ngaydat, tongtien, trangthai, diachigiaohang, sdtgiaohang, ghichu, phuongthuctt) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "issssssss", $makh, $hoten, $ngaydat, $tongtien, $trangthai, $diachigiaohang, $sdtgiaohang, $note, $phuongthuctt);
    if (mysqli_stmt_execute($stmt)) {
        $madonhang = mysqli_insert_id($conn);
        mysqli_stmt_close($stmt);

        // Thêm chi tiết đơn hàng
        foreach ($cart_items as $row) {
            $masp = $row['masp'];
            $soluong = $row['soluong'];
            $dongia = $row['giasp'];
            $sql = "INSERT INTO chitietdonhang (madh, masp, soluong, dongia ) VALUES (?, ?, ?, ?)";
            $stmt2 = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt2, "iiid", $madonhang, $masp, $soluong, $dongia);
            mysqli_stmt_execute($stmt2);
            mysqli_stmt_close($stmt2);
        }

        // Xóa giỏ hàng sau khi đặt hàng thành công
        $sql = "DELETE FROM giohang WHERE makh = ?";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $makh);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);

        // Chuyển đến trang thông báo thành công
        header("Location: order_success.php?order_id=" . $madonhang);
        exit();
    } else {
        echo "Có lỗi xảy ra khi thêm đơn hàng: " . mysqli_stmt_error($stmt);
        mysqli_stmt_close($stmt);
    }
}
?>