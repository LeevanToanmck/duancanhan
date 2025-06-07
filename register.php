
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/register.css">
    <title>Document</title>
</head>
<body>
    <div class="loginForm">
        <h2>Đăng ký</h2>
        <form action="register.php" method="post">
            <div class="inputField">    
                <input type="text" id="username" name="username" required>  
                <label for="username">Tên đăng nhập:</label>
            </div>
            <div class="inputField">
                <input type="password" id="password" name="password" required>
                <label for="password">Mật khẩu:</label>
            </div>
            <div class="inputField">
                <input type="password" id="password" name="repassword" required>
                <label for="password">Nhập lại mật khẩu:</label>
            </div>
            <div class="inputField">
                <input type="text" id="email" name="email" required>
                <label for="email">Nhập email:</label>
            </div>
            <button type="submit" name ="dangky">Đăng ký</button>
            <div class="link">
                <p><a href="login.php">Bạn đã có tài khoản? Đăng nhập</a></p>
            </div>
        </form>
    </div>
    <?php
    include "connect.php";
    if(isset($_POST["dangky"])){
        $email= $_POST['email'];
        $username = $_POST['username'];
        // Kiểm tra định dạng email
        if (empty($_POST['email'])) {
            echo 'Vui lòng nhập địa chỉ email.';
            exit();
        }
        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) // Kiểm tra định dạng email
         {
            echo 'Địa chỉ email không hợp lệ. Vui lòng nhập lại.';
            exit();
        }
        $password = $_POST['password'];

        $level = 2;
        // Kiểm tra xem tên đăng nhập đã tồn tại chưa
        $checkUser = "SELECT * FROM thanhvien WHERE username='$username'";
        if(isset($_POST["dangky"])){
            $result = mysqli_query($conn, $checkUser);
            if (mysqli_num_rows($result) > 0) {
                ?>
               <p> <?php echo 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên khác.';?></p>
                <?php
                exit();
            }
        }
        // Kiểm tra xem mật khẩu có trùng nhau hợp lệ không
        if(isset($_POST['repassword'])){
            $repassword = $_POST['repassword'];
            if ($password !== $repassword) {
                ?>
               <p> <?php echo 'Mật khẩu và Nhập lại mật khẩu không giống nhau. Vui lòng thử lại.';?></p>
                <?php
                exit();
            }
        }
        // Kiểm tra thông tin đăng ký
        $sql = "INSERT INTO thanhvien (username, password, level, email ) VALUES ('$username', '$password', '$level', '$email')";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('Đăng ký thành công!');</script>";
            header("Location: login.php");
            exit();
        } else {
            echo 'Đăng ký thất bại. Vui lòng thử lại.';
        }
    }
    ?>
</body>
</html>