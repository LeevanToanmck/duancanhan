<?php
session_start();
include "../connect.php";

// Kiểm tra đăng nhập và level
 if(isset($_SESSION['user_id']) && $_SESSION['level'] == 1){
    header("Location: admin.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/add_product.css">
    <title>Thêm sản phẩm mới</title>
</head>

<body>
    <?php
    if (isset($_POST['btn'])) {
        
        $sql = "select max(masp) from sanpham";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        $masp = $row['max(masp)'] + 1;
        $name = $_POST['product_name'];
        $img = $_FILES['product_image']['name'];
        $soluongsp = $_POST['soluong'];
        // lấy đường dẫn tạm thời của ảnh
        $img_tmp_name = $_FILES['product_image']['tmp_name'];
        $laoisp = $_POST['product_type'];
        $giasp = $_POST['product_price'];
        $baobanh = $_POST['product_warranty'];
        $sql = "insert into sanpham (masp,tensp, hinhanhsp, loaisp,giasp, baohanh, soluongsp) values ('$masp', '$name', '$img', '$laoisp', '$giasp', '$baobanh', '$soluongsp')";
        mysqli_query($conn, $sql);

        move_uploaded_file($img_tmp_name, '../img/WAo/' . $img);
        header("Location: admin.php");
    }
    ?>

    <form action="add_product.php" method="post" enctype="multipart/form-data">
        <div class="add_product">
            <h2>Thêm sản phẩm mới</h2>
            <div class="inputField">
                <P>Tên sản phẩm:</P>
                <input type="text" name="product_name" required>
            </div>
            <div class="inputField">
                <p>Số lượng sản phẩm:</p>
                <input type="text" name="soluongsp" required>
            </div><div class="inputField">
                <p>Hình ảnh sản phẩm:</p>
            
                <input type="file" name="product_image" required>
                
            </div>
            
            
            <div class="inputField">
                <p>Giá sản phẩm:</p>
                <input type="text" id="product_price" name="product_price" required>
            </div>
            <div class="inputField">
                <p>Bảo hành:</p>
                <input type="text" name="product_warranty" required>
            </div><div class="inputField">
                <p>loại sản phẩm:</p>
                <select name="product_type" required>
                    <option value="Nam" name="Nam">Nam</option>
                    <option value="Nữ" name="Nữ">Nữ</option>
                    <option value="Cả Nam Cả Nữ" name="Cả Nam Cả Nữ">Cả Nam Cả Nữ</option>
                    <option value="Phụ kiện" name="Phụ kiện">Phụ kiện</option>
                </select>
            </div>
            <input type="submit" name="btn" value="Thêm sản phẩm">
            <a href="admin.php" class="btn btn-secondary">Quay lại</a>
        </div>
    </form>
</body>

</html>