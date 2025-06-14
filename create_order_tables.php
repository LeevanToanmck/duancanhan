<?php
include "connect.php";

// Tạo bảng donhang
$sql = "CREATE TABLE IF NOT EXISTS donhang (
    madonhang INT AUTO_INCREMENT PRIMARY KEY,
    makh INT NOT NULL,
    hoten VARCHAR(100) NOT NULL,
    sdt VARCHAR(20) NOT NULL,
    diachi TEXT NOT NULL,
    thanhpho VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    note TEXT,
    phuongthuctt VARCHAR(50) NOT NULL,
    ngaydat DATETIME NOT NULL,
    trangthai VARCHAR(50) NOT NULL,
    FOREIGN KEY (makh) REFERENCES khachhang(id)
)";

if (mysqli_query($conn, $sql)) {
    echo "Bảng donhang đã được tạo thành công<br>";
} else {
    echo "Lỗi khi tạo bảng donhang: " . mysqli_error($conn) . "<br>";
}

// Tạo bảng chitietdonhang
$sql = "CREATE TABLE IF NOT EXISTS chitietdonhang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    madonhang INT NOT NULL,
    masp INT NOT NULL,
    soluong INT NOT NULL,
    dongia DECIMAL(10,2) NOT NULL,
    thanhtien DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (madonhang) REFERENCES donhang(madonhang),
    FOREIGN KEY (masp) REFERENCES sanpham(masp)
)";

if (mysqli_query($conn, $sql)) {
    echo "Bảng chitietdonhang đã được tạo thành công<br>";
} else {
    echo "Lỗi khi tạo bảng chitietdonhang: " . mysqli_error($conn) . "<br>";
}

echo "Đã hoàn thành việc tạo các bảng!";
?> 