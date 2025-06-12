<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trang chủ - Dripped Stonie</title>
</head>

<body>
    <?php
    include "connect.php"; // Kết nối đến cơ sở dữ liệu
    // Kiểm tra nếu người dùng đã đăng nhập
        session_start();

    include "menu.php";
    include "product.php";
    include "footer.php";
    ?>
</body>

</html>