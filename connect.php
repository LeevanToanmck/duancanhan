<?php
    $sever = 'localhost';
    $user ='root';
    $pass = '';
    $database = 'websitebanquanao';

    $conn = new mysqLi($sever, $user, $pass, $database);
    if ($conn ){
       mysqLi_query($conn , "SET NAMES 'utf8'");
    }
    else {
        echo 'Kết nối thất bại';
    }

?>