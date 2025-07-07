<?php
    $sever = 'localhost';
    $user ='root';
    $pass = '';
    $database = 'websitebanhang';

    $conn = new mysqLi($sever, $user, $pass, $database);
    if ($conn ){
        // echo 'ket noi thanh cong';   
       mysqLi_query($conn , "SET NAMES 'utf8'");
    }
    else {
        echo 'Kết nối thất bại';
    }
?>