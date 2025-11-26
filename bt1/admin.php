<?php


session_start();
$flowers = [
    [
        "name" => "DoQuyen",
        "description" => "Hoa dep",
        "image" => "hoadep/doquyen.jpg"
    ],
    [
        "name" => "HaiDuong",
        "description" => "Hoa dep",
        "image" => "hoadep/haiduong.jpg"
    ],
    [
        "name" => "HoaMai",
        "description" => "Hoa dep",
        "image" => "hoadep/mai.jpg"
    ],
    [
        "name" => "HoaTuongVy",
        "description" => "Hoa dep",
        "image" => "hoadep/tuongvy.jpg"
    ],
];
?>



<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Admin - Danh sách hoa</title>
</head>

<body>

    <h2>Danh sách hoa (Admin)</h2>

    <table border="1" cellpadding="10">
        <tr>
            <th>STT</th>
            <th>Tên hoa</th>
            <th>Mô tả</th>
            <th>Hình ảnh</th>
            <th>Hành động</th>
        </tr>

        <?php foreach ($flowers as $i => $flower): ?>
            <tr>
                <td><?= $i + 1 ?></td>
                <td><?= $flower['name'] ?></td>
                <td><?= $flower['description'] ?></td>
                <td><img src="<?= $flower['image'] ?>" width="80"></td>
                <td> <button>Sửa</button> | <button>Xóa</button></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <a href="ex1.html">← Quay lại chọn chế độ</a>

</body>

</html>