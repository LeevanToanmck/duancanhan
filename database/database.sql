-- Tạo database
CREATE DATABASE IF NOT EXISTS duancanha;
USE duancanha;

-- Bảng thành viên (users)
CREATE TABLE thanhvien (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    hoten VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    sdt VARCHAR(15),
    diachi TEXT,
    level INT DEFAULT 2, -- 1: admin, 2: user thường
    ngaytao TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng sản phẩm
CREATE TABLE sanpham (
    masp VARCHAR(20) PRIMARY KEY,
    tensp VARCHAR(255) NOT NULL,
    loaisp VARCHAR(50) NOT NULL,
    giasp DECIMAL(15,2) NOT NULL,
    baohanh VARCHAR(50),
    hinhanhsp VARCHAR(255),
    mota TEXT,
    soluong INT DEFAULT 0,
    ngaythem TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Bảng đơn hàng
CREATE TABLE donhang (
    madh INT AUTO_INCREMENT PRIMARY KEY,
    makh INT NOT NULL,
    ngaydat TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    tongtien DECIMAL(15,2) NOT NULL,
    trangthai VARCHAR(50) DEFAULT 'Chờ xử lý',
    diachigiaohang TEXT NOT NULL,
    sdtgiaohang VARCHAR(15) NOT NULL,
    FOREIGN KEY (makh) REFERENCES thanhvien(id)
);

-- Bảng chi tiết đơn hàng
CREATE TABLE chitietdonhang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    madh INT NOT NULL,
    masp VARCHAR(20) NOT NULL,
    soluong INT NOT NULL,
    dongia DECIMAL(15,2) NOT NULL,
    FOREIGN KEY (madh) REFERENCES donhang(madh),
    FOREIGN KEY (masp) REFERENCES sanpham(masp)
);

-- Bảng giỏ hàng
CREATE TABLE giohang (
    id INT AUTO_INCREMENT PRIMARY KEY,
    makh INT NOT NULL,
    masp VARCHAR(20) NOT NULL,
    soluong INT NOT NULL,
    ngaythem TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (makh) REFERENCES thanhvien(id),
    FOREIGN KEY (masp) REFERENCES sanpham(masp)
);

-- Thêm dữ liệu mẫu cho admin
INSERT INTO thanhvien (username, password, hoten, email, level) 
VALUES ('admin', 'admin123', 'Administrator', 'admin@example.com', 1);

-- Thêm dữ liệu mẫu cho sản phẩm
INSERT INTO sanpham (masp, tensp, loaisp, giasp, baohanh, hinhanhsp) VALUES
('SP001', 'Áo thun nam', 'Áo', 150000, '6 tháng', 'aothun.jpg'),
('SP002', 'Quần jean nữ', 'Quần', 350000, '12 tháng', 'quanjean.jpg'),
('SP003', 'Giày thể thao', 'Giày', 500000, '12 tháng', 'giaythethao.jpg'); 