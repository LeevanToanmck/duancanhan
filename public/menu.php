<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <link rel="stylesheet" href="../css/menu.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>monkey man</title>
</head>
<body>
    <form action="search.php" methor="get"> 
        <div id="khung">
            <div id="dau">
                <div class="anh"><a href="index.php"><img src="../img/banner (2).png " alt=""></a></div>
                <div class="menu">
                    <ul class="menu-ul">
                        <li class="menu-li"><a href="all.php">ALL</a> </li>
                        <li class="menu-li"><a href="productmen.php">MEN</a> </li>
                        <li class="menu-li"><a href="productwomen.php">WOMEN</a> </li>
                        <li class="menu-li"><a href="productunisex.php">UNISEX</a> </li>
                        <li class="menu-li"><a href="productaccessories.php">ACCESSORIES</a></li>
                        <li class="menu-li"><a href="productsale.php">SALE</a> </li>
                        <li class="menu-li"><input type="text" name="keyword" placeholder="Nhập tên sản phẩm..."
                                value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>"><button
                                type="submit">search</button></li>
                        <li class="menu-li"><a href="cart.php"><i class="fas fa-shopping-cart"></i>Cart</a> </li>
                        <!-- khi đăng nhập thành công thì login sẽ thành logout -->
                        <?php
                          if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        ?>
                        <?php

                        if (isset($_SESSION['username'])) {
                            echo '<li class="menu-li"><a href="logout.php">👤   Logout</a> </li>';
                        } else {
                            echo '<li class="menu-li"><a href="login.php"> Login</a> </li>';
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        </div>
    </form>

</body>

</html>