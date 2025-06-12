<?php
session_start();
include 'connect.php';

// Kiểm tra đăng nhập và quyền admin
if (!isset($_SESSION['username']) || $_SESSION['level'] != 1) {
    echo "<script>alert('Bạn không có quyền truy cập trang này!'); window.location.href='index.php';</script>";
    exit();
}

// Lấy thông tin sản phẩm cần sửa
if (isset($_GET['id'])) {
    $masp = $_GET['id'];
    $sql = "SELECT * FROM sanpham WHERE masp = '$masp'";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
} else {
    header('Location: admin.php');
    exit();
}

// Xử lý cập nhật sản phẩm
if (isset($_POST['update'])) {
    $tensp = $_POST['tensp'];
    $loaisp = $_POST['loaisp'];
    $giasp = $_POST['giasp'];
    $baohanh = $_POST['baohanh'];
    
    // Xử lý upload hình ảnh
    if (isset($_FILES['hinhanhsp']) && $_FILES['hinhanhsp']['error'] == 0) {
        $target_dir = "./img/WAo/";
        $target_file = $target_dir . basename($_FILES["hinhanhsp"]["name"]);
        move_uploaded_file($_FILES["hinhanhsp"]["tmp_name"], $target_file);
        $hinhanhsp = $_FILES["hinhanhsp"]["name"];
        
        $sql = "UPDATE sanpham SET tensp='$tensp', loaisp='$loaisp', giasp='$giasp', baohanh='$baohanh', hinhanhsp='$hinhanhsp' WHERE masp='$masp'";
    } else {
        $sql = "UPDATE sanpham SET tensp='$tensp', loaisp='$loaisp', giasp='$giasp', baohanh='$baohanh' WHERE masp='$masp'";
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
    
    <title>Sửa sản phẩm</title>
    <style>
        .edit-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .current-image {
            max-width: 200px;
            margin: 10px 0;
        }
        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            color: white;
        }
        .btn-primary {
            background-color: #007bff;
        }
        .btn-secondary {
            background-color: #6c757d;
        }
    </style>
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
                <img src="./img/WAo/<?php echo $product['hinhanhsp']; ?>" class="current-image">
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