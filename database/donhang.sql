-- Tạo bảng donhang
CREATE TABLE `donhang` (
  `madonhang` int(11) NOT NULL AUTO_INCREMENT,
  `makh` int(11) NOT NULL,
  `ngaydat` datetime NOT NULL,
  `tongtien` decimal(10,2) NOT NULL,
  `trangthai` varchar(50) NOT NULL DEFAULT 'Chờ xử lý',
  PRIMARY KEY (`madonhang`),
  KEY `makh` (`makh`),
  CONSTRAINT `donhang_ibfk_1` FOREIGN KEY (`makh`) REFERENCES `thanhvien` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 