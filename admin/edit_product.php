<?php
session_start();
include '../connect.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['username']) || $_SESSION['level'] != 1) {
    echo "<script>alert('Bạn không có quyền truy cập trang này!'); window.location.href='index.php';</script>";
    exit();
}

// Lấy thông tin sản phẩm cần sửa
if (isset($_GET['this_id'])) {
    $masp = $_GET['this_id'];
    $sql = "SELECT * FROM sanpham WHERE masp = '$masp'";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
} else {
    header('Location: ../admin/admin.php');
    exit();
}

// Xử lý cập nhật sản phẩm
if (isset($_POST['update'])) {
    $tensp = $_POST['tensp'];
    $loaisp = $_POST['loaisp'];
    $giasp = $_POST['giasp'];
    $baohanh = $_POST['baohanh'];
    $soluong = $_POST['soluong'];
    
    // Xử lý upload hình ảnh
    if (isset($_FILES['hinhanhsp']) && $_FILES['hinhanhsp']['error'] == 0) //
    {
        $target_dir = "../img/WAo/";
        $target_file = $target_dir . basename($_FILES["hinhanhsp"]["name"]);
        move_uploaded_file($_FILES["hinhanhsp"]["tmp_name"], $target_file);
        $hinhanhsp = $_FILES["hinhanhsp"]["name"];
        
        $sql = "UPDATE sanpham SET tensp='$tensp', loaisp='$loaisp', giasp='$giasp', baohanh='$baohanh', hinhanhsp='$hinhanhsp', soluong='$soluong' WHERE masp='$masp'";
    } else {
        $sql = "UPDATE sanpham SET tensp='$tensp', loaisp='$loaisp', giasp='$giasp', baohanh='$baohanh', soluong='$soluong' WHERE masp='$masp'";
    }
    
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('Cập nhật sản phẩm thành công!'); window.location.href='admin.php';</script>";
    } else {
        echo "<script>alert('Có lỗi xảy ra khi cập nhật sản phẩm!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/editproduct.css">
    <title>Sửa sản phẩm</title>

</head>
<body>
    <div class="edit-container">

        <h2>Sửa sản phẩm</h2>
        <form action="" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label>Mã sản phẩm:</label>
                <input type="text" value="<?php echo $product['masp']; ?>" disabled>
            </div>
            
            <div class="form-group">
                <label>Tên sản phẩm:</label>
                <input type="text" name="tensp" value="<?php echo $product['tensp']; ?>" required>
            </div>
            <div class="form-group">
                <label>Số lượng:</label>
                <input type="number" name="soluong" value="<?php echo $product['soluong']; ?>" required>
            </div>
            <div class="form-group">
                <label>Loại sản phẩm:</label>
                <input type="text" name="loaisp" value="<?php echo $product['loaisp']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Giá sản phẩm:</label>
                <input type="number" name="giasp" value="<?php echo $product['giasp']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Bảo hành:</label>
                <input type="text" name="baohanh" value="<?php echo $product['baohanh']; ?>" required>
            </div>
            
            <div class="form-group">
                <label>Hình ảnh hiện tại:</label>

                <img src="../img/WAo/<?php echo $product['hinhanhsp']; ?>" class="current-image">
            </div>
            
            <div class="form-group">
                <label>Thay đổi hình ảnh (nếu muốn):</label>
                <input type="file" name="hinhanhsp" accept="image/*">
            </div>
            
            <button type="submit" name="update" class="btn btn-primary">Cập nhật</button>
            <a href="admin.php" class="btn btn-secondary">Quay lại</a>
        </form>
    </div>
</body>
</html>     