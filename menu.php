<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <link rel="stylesheet" href="./css/in.css">
    <title>monkey man</title>
</head>

<body>
    <form action="search.php" methor="get">
        <div id="khung">
            <div id="dau">
                <div class="anh"><a href="#"><img src="./img/banner (2).png " alt=""></a></div>
                <div class="menu">
                    <ul class="menu-ul">
                        <li class="menu-li"><a href="#">ALL</a> </li>
                        <li class="menu-li"><a href="#">MEN</a> </li>
                        <li class="menu-li"><a href="#">WOMEN</a> </li>
                        <li class="menu-li"><a href="#">UNISEX</a> </li>
                        <li class="menu-li"><a href="#">ACCESSORIES</a></li>
                        <li class="menu-li"><a href="#">SALE</a> </li>
                        <li class="menu-li"><input type="text" name="keyword" placeholder="Nhập tên sản phẩm..."
                                value="<?= isset($_GET['keyword']) ? htmlspecialchars($_GET['keyword']) : '' ?>"><button
                                type="submit">search</button></li>
                        <li class="menu-li"><a href="#">Cart</a> </li>
                        <li class="menu-li"><a href="login.php">Login</a> </li>
                    </ul>
                </div>

            </div>

        </div>
        </div>
    </form>
</body>

</html>