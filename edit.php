<?php

include 'connect.php'; // Gọi file kết nối
// Lấy mã sản phẩm từ URL
$this_id = $_GET['this_id'];
// Truy vấn để lấy thông tin sản phẩm
$sql = "SELECT * FROM sanpham WHERE masp='$this_id'";
$result = mysqli_query($conn, $sql);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
} else {
    echo "Không tìm thấy sản phẩm.";
    exit();
}
// Xử lý khi người dùng gửi form
if (isset($_POST['btn'])) {
    $tensp = $_POST['tensp'];
    $loaisp = $_POST['loaisp'];
    $hinhanhsp = $_FILES['hinhanhsp']['name'];;
    $giasp = $_POST['giasp'];
    $baohanh = $_POST['baohanh'];
        // lấy đường dẫn tạm thời của ảnh
        $img_tmp_name = $_FILES['hinhanhsp']['tmp_name'];
  move_uploaded_file($img_tmp_name, 'img/WAo/' . $hinhanhsp);
      

            
    $update_sql = "UPDATE sanpham SET tensp='$tensp', loaisp='$loaisp', hinhanhsp='$hinhanhsp', giasp='$giasp', baohanh='$baohanh' WHERE masp='$this_id'";
    
    if (mysqli_query($conn, $update_sql)) {
        header("Location: product__details.php");
        exit();
    } else {
        echo "Lỗi khi cập nhật sản phẩm: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Sửa sản phẩm</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        form {
            max-width: 600px;
            margin: auto;
        }
        label {
            display: block;
            margin-bottom: 10px;
        }
        input[type="text"], input[type="number"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 10px;
        }
        input[type="submit"] {
            padding: 10px 15px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
<h2>Sửa sản phẩm</h2>
<form method="POST" enctype="multipart/form-data">
    <label for="tensp">Tên sản phẩm:</label>
    <input type="text" id="tensp" name="tensp" value="<?php echo ($row['tensp']); ?>" required>

    <label for="loaisp">Loại sản phẩm:</label>
    <input type="text" id="loaisp" name="loaisp" value="<?php echo ($row['loaisp']); ?>" required>

    <label for="hinhanhsp">Ảnh sản phẩm:</label>
    <img src="./img/WAo/<?php echo $row['hinhanhsp']; ?>" alt="Ảnh sản phẩm" style="width: 100px; height: auto;"><br>
    <input type="file" id="hinhanhsp" name="hinhanhsp" value="<?php echo ($row['hinhanhsp']); ?>" required>

    <label for="giasp">Giá sản phẩm:</label>
    <input type="text" id="giasp" name="giasp" value="<?php echo ($row['giasp']); ?>" required>
   <br>
    <label for="baohanh">Thời gian bảo hành:</label>
    <input type="text" id="baohanh" name="baohanh" value="<?php echo ($row['baohanh']); ?>" required>
    <input type="submit" name="btn"value="Cập nhật">
</body>
</html>