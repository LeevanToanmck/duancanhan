<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/addproduct.css">
    <title>Document</title>
</head>

    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f4;
    }
    .add_product {
        width: 50%;
        margin: 0 auto;
        background-color: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
    }
    .add_product h2 {
        text-align: center;
        margin-bottom: 20px;
    }
    .inputField, .inputimg {
        margin-bottom: 15px;
    }
    .inputField p, .inputimg p {
        margin-bottom: 5px;
    }
    .inputField input, .inputimg input, .inputField select {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }
    </style>
<body>


    <?php
    include "connect.php";
    if (isset($_POST['btn'])) {
        $name = $_POST['product_name'];
        $img = $_FILES['product_image']['name'];
        // lấy đường dẫn tạm thời của ảnh
        $img_tmp_name = $_FILES['product_image']['tmp_name'];
        $laoisp = $_POST['product_type'];
        $giasp = $_POST['product_price'];
        $baobanh = $_POST['product_warranty'];
        $sql = "insert into sanpham (tensp, hinhanhsp, loaisp,giasp, baohanh) values ('$name', '$img', '$laoisp', '$giasp', '$baobanh')";
        mysqli_query($conn, $sql);

        move_uploaded_file($img_tmp_name, 'img/WAo/' . $img);
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
                <p>loại sản phẩm:</p> <!--  chọn nam ,nữ và cả nam cả nữ, mắt kính -->

                <select name="product_type" required>
                    <option value="nam" name="Nam">Nam</option>
                    <option value="nu" name="Nữ">Nữ</option>
                    <option value="ca_nam_ca_nu" name="Cả Nam Cả Nữ">Cả Nam Cả Nữ</option>
                    <option value="mat_kinh" name="Phụ kiện">Phụ kiện</option>
                </select>
            </div>
            <br>
            <div class="inputimg">
                <p>Hình ảnh sản phẩm:</p>
                <img src="" alt="">
                <input type="file" name="product_image" required>
            </div>
            <div class="inputField">
                <p>Giá sản phẩm:</p>
                <input type="text" id="product_price" name="product_price" required>
            </div>
            <div class="inputField"></div>
            <p>Bảo hành:</p>
            <input type="text" name="product_warranty" required>
            <br>

            <input type="submit" name="btn" value="Thêm sản phẩm">
        </div>
    </form>
</body>

</html>