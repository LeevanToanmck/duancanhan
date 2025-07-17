
<?php
include '../connect.php'; // Gọi file kết nối

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
// Truy vấn dữ liệu sản phẩm
$sql = "SELECT * FROM sanpham";
$result = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh sách sản phẩm bảo hành</title>
</head>
<body>

<h2>Danh sách sản phẩm</h2>

<table>
    <thead>
        <tr>
            <th>STT</th>
            <th>Mã SP</th><th>Ảnh sản phẩm</th>
            <th>Tên sản phẩm</th>
            <th>Loại sản phẩm</th>
            <th>Giá sản phẩm</th>
            <th>Số lượng</th>
            <th>Sửa / Xóa</th>
        </tr>
    </thead>
    <tbody>
        <?php
            // Chuyển đổi giá sản phẩm từ chuỗi có dấu phẩy sang số nguyên

        
        $stt = 1;
        foreach (mysqli_fetch_all($result, MYSQLI_ASSOC) as $product) {// Lấy tất cả dữ liệu sản phẩm dưới dạng mảng kết hợp
            echo "<tr>
            
                <td>{$stt}</td>
                <td>{$product['masp']}</td>
                <td><img src='../img/WAo/{$product['hinhanhsp']}' alt='Ảnh sản phẩm' style='width: 100px; height: auto;'></td>
                <td>{$product['tensp']}</td>
                <td>{$product['loaisp']}</td>
                <td>{$product['giasp']} VNĐ</td>
                <td>{$product['soluongsp']}</td>
                <td>
                        <a href='edit_product.php?this_id={$product['masp']}' class='btn edit'>Sửa</a>
                        <a href='delete.php?this_id={$product['masp']}'class='btn delete'>Xóa</a> 
                </td>
            </tr>";
            $stt++;
        } 
        ?>
    </tbody>
</table>
</body>
</html>