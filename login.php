<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/login.css">
    <title>Document</title>
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
        
            <button type="submit" name ="dangnhap">Đăng nhập</button>
            <div class="link">
                <p><a href="login.php">Bạn đã quên mật khẩu đăng nhập?</a></p>
                <p><a href="register.php">Chưa có tài khoản? Đăng ký</a></p>
            </div>
        </form>
    </div>
    <?php
    include "connect.php";
     if(isset($_POST["dangnhap"])){
        $username = $_POST['username'];
        $password = $_POST['password'];

        // Kiểm tra thông tin đăng nhập
        $sql = "SELECT * FROM thanhvien WHERE username='$username' AND password='$password'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result)==1) {
            // Đăng nhập thành công
            $_SESSION['mySession'] = $username; // Lưu tên đăng nhập vào session
            echo "<script>alert('Đăng nhập thành công!');</script>";
            // Chuyển hướng đến trang khác nếu cần
            header("Location: logintrue.php");
            exit();
        } else {
            // Đăng nhập thất bại
             echo 'Tên đăng nhập hoặc mật khẩu không đúng. Vui lòng thử lại.';
        }
     }
    ?>

</body>

</html>