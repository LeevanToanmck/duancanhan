-- Tạo bảng chitietdonhang
CREATE TABLE `chitietdonhang` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `madonhang` int(11) NOT NULL,
  `masp` varchar(10) NOT NULL,
  `soluong` int(11) NOT NULL,
  `dongia` decimal(10,2) NOT NULL,
  PRIMARY KEY (`id`),
  KEY `madonhang` (`madonhang`),
  KEY `masp` (`masp`),
  CONSTRAINT `chitietdonhang_ibfk_1` FOREIGN KEY (`madonhang`) REFERENCES `donhang` (`madonhang`) ON DELETE CASCADE,
  CONSTRAINT `chitietdonhang_ibfk_2` FOREIGN KEY (`masp`) REFERENCES `sanpham` (`masp`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 