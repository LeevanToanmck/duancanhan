<?php
session_start();
include "../connect.php";

// kiểm tra đăng nhập
if (!isset($_SESSION['username']) || $_SESSION['level'] != 1) {
    echo "<script>alert('Bạn không có quyền truy cập trang này!'); window.location.href='../index.php';</script>";
    exit();
}

// xử lý cập nhật trạng thái
if (isset($_POST['update_status'])) {
    $order_id = $_POST['order_id'];
    $new_status = $_POST['new_status'];
    
    $update_sql = "UPDATE donhang SET trangthai = ? WHERE madh = ?";
    $stmt = $conn->prepare($update_sql);
    $stmt->bind_param("si", $new_status, $order_id);
    
    if ($stmt->execute()) {
        $success_message = "Cập nhật trạng thái đơn hàng thành công!";
    } else {
        $error_message = "Lỗi khi cập nhật trạng thái đơn hàng!";
    }
}


$sql = "SELECT 
    d.madh, t.hoten, d.ngaydat, d.tongtien, d.diachigiaohang, d.sdtgiaohang, d.trangthai,
    GROUP_CONCAT(CONCAT(s.tensp, ' (', c.soluong, ')') SEPARATOR ', ') AS sanpham_soluong
FROM donhang d
JOIN thanhvien t ON d.makh = t.id
JOIN chitietdonhang c ON d.madh = c.madh
JOIN sanpham s ON c.masp = s.masp
GROUP BY d.madh ORDER BY d.ngaydat DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Lỗi chuẩn bị câu lệnh SQL: " . $conn->error);
}

if (!$stmt->execute()) {
    die("Lỗi thực thi câu lệnh SQL: " . $stmt->error);
}

$result = $stmt->get_result();
if (!$result) {
    die("Lỗi lấy kết quả: " . $stmt->error);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/manage.css">
    <title>Quản lý đơn hàng</title>
    
</head>
<body>  
    <div class="container">
    <div class="header">
        <a href="admin.php">← Quay lại trang Admin</a>
        <center><h1>Quản lý đơn hàng</h1></center>

        <?php if (isset($success_message)): ?>
            <div class="alert alert-success"><?php echo $success_message; ?></div>
        <?php endif; ?>
        
        <?php if (isset($error_message)): ?>
            <div class="alert alert-danger"><?php echo $error_message; ?></div>
        <?php endif; ?>

        <table class="order-table">
            <thead>
                <tr>
                    <th>Mã đơn hàng</th>
                    <th>Khách hàng</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Sản phẩm (Số lượng)</th>
                    <th>Ngày đặt</th>
                    <th>Tổng tiền</th>
                    <th>Trạng thái</th>
                    <th>Thao tác</th>
                </tr>
            </thead>
            <tbody>
                <?php while ( $order = mysqli_fetch_assoc($result) ): ?>
                    <tr>
                        <td>#<?php echo $order['madh']; ?></td>
                        <td><?php echo htmlspecialchars($order['hoten']); ?></td>
                        <td><?php echo htmlspecialchars($order['diachigiaohang']); ?></td>
                        <td><?php echo htmlspecialchars($order['sdtgiaohang']); ?></td>
                        <td><?php echo htmlspecialchars($order['sanpham_soluong']); ?></td>
                        <td><?php echo date('d/m/Y', strtotime($order['ngaydat'])); ?></td>
                        <td><?php echo number_format($order['tongtien'], 0, ',', '.'); ?> đ</td>
                        <td>
                            <span class="status-badge status-<?php echo strtolower(str_replace(' ', '-', $order['trangthai'])); ?>">
                                <?php echo $order['trangthai']; ?>
                            </span>
                        </td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="order_id" value="<?php echo $order['madh']; ?>">
                                <select name="new_status" onchange="this.form.submit()">
                                    <option value="">Cập nhật trạng thái</option>
                                    <option value="Chờ xử lý">Chờ xử lý</option>
                                    <option value="Đang xử lý">Đang xử lý</option>
                                    <option value="Đang giao">Đang giao</option>
                                    <option value="Hoàn thành">Hoàn thành</option>
                                    <option value="Đã hủy">Đã hủy</option>
                                </select>
                                <input type="hidden" name="update_status" value="1">
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>    
        </div>
        <div class="fooer">
         
       <?php include "../public/footer.php"; ?>
    </div>    </div>

   
</body>
</html> 