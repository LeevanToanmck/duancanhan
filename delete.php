<?php
    include 'connect.php'; // Gọi file kết nối
    // Lấy mã sản phẩm từ URL
    $this_id = $_GET['this_id'];
    // Truy vấn để xóa sản phẩm
    $sql = "DELETE FROM sanpham WHERE masp='$this_id'";
    if (mysqli_query($conn, $sql)) {
        // Nếu xóa thành công, chuyển hướng về trang danh sách sản phẩm
        header("Location: product__details.php");
        exit(); 
    } else {
        // Nếu có lỗi xảy ra, hiển thị thông báo lỗi
        echo "Lỗi khi xóa sản phẩm: " . mysqli_error($conn);
    }
    // Đóng kết nối
    mysqli_close($conn);
    ?>