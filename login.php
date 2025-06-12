<?php
session_start();
include "connect.php";

// Kiểm tra nếu người dùng đã đăng nhập thì chuyển hướng

// Xử lý đăng nhập
if (isset($_POST["dangnhap"])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Nên dùng prepared statement để bảo mật hơn (nếu muốn)
    $sql = "SELECT * FROM thanhvien WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $_SESSION['username'] = $username;
        $_SESSION['level'] = $row['level'];
        $_SESSION['id'] = $row['id'];
        if ($row['level'] == 1) {
            header("Location: admin.php");
        } else {
            header("Location: index.php");
        }
        exit();

    } else {
        echo '<script>alert("Tên đăng nhập hoặc mật khẩu không đúng. Vui lòng thử lại.");</script>';
    }

}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Đăng nhập</title>
</head>

<body>
    <div class="loginForm">
        <h2>Đăng nhập</h2>
        <form action="login.php" method="post">
            <div class="inputField">
                <input type="text" id="username" name="username" required>
                <label for="username">Tên đăng nhập:</label>
            </div>
            <div class="inputField">
                <input type="password" id="password" name="password" required>
                <label for="password">Mật khẩu:</label>
            </div>

            <button type="submit" name="dangnhap">Đăng nhập</button>
            <div class="link">
                <p><a href="login.php">Bạn đã quên mật khẩu đăng nhập?</a></p>

                <p><a href="register.php">Chưa có tài khoản? Đăng ký</a></p>
            </div>
        </form>
    </div>
</body>

</html>