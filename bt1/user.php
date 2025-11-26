<?php
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
    <title>User - Danh sách hoa</title>
</head>

<body>

    <h2>Danh sách hoa (Người dùng)</h2>

    <?php foreach ($flowers as $flower): ?>
        <div style="width:250px;border:1px solid #ccc;padding:10px;margin:10px;float:left;">
            <img src="<?= $flower['image'] ?>" width="100%">
            <h3><?= $flower['name'] ?></h3>
            <p><?= $flower['description'] ?></p>
        </div>
    <?php endforeach; ?>

    <div style="clear: both;"></div>
    <br>
    <a href="ex1.html">← Quay lại chọn chế độ</a>

</body>

</html>