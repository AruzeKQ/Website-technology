<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Điểm Danh</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 20px;
            min-height: 100vh;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }

        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 30px 20px;
            text-align: center;
        }

        .header h1 {
            font-size: 32px;
            margin-bottom: 10px;
        }

        .header p {
            font-size: 14px;
            opacity: 0.9;
        }

        .content {
            padding: 20px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        thead {
            background-color: #f8f9fa;
            border-bottom: 2px solid #667eea;
        }

        th {
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #333;
            background-color: #f8f9fa;
            border-right: 1px solid #ddd;
        }

        th:last-child {
            border-right: none;
        }

        td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
            color: #555;
        }

        tbody tr:hover {
            background-color: #f5f5f5;
            transition: background-color 0.2s ease;
        }

        tbody tr:nth-child(even) {
            background-color: #fafafa;
        }

        .row-number {
            background-color: #e8eef7;
            font-weight: 600;
            color: #667eea;
            width: 50px;
            text-align: center;
        }

        .stats {
            padding: 20px;
            background-color: #f8f9fa;
            border-top: 1px solid #ddd;
            text-align: right;
            color: #666;
            font-size: 14px;
        }

        .error {
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            color: #856404;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
            <h1>📋 Danh Sách Điểm Danh</h1>
            <p>Lớp CSE485.202401 - 65HTTT</p>
        </div>

        <div class="content">
            <?php
            // Đường dẫn tệp CSV
            $csvFile = __DIR__ . '/65HTTT_Danh_sach_diem_danh.csv';

            // Kiểm tra tệp tồn tại
            if (!file_exists($csvFile)) {
                echo '<div class="error">❌ Lỗi: Không tìm thấy tệp CSV!</div>';
            } else {
                // Mở tệp CSV
                $file = fopen($csvFile, 'r');

                if ($file) {
                    // Đọc hàng đầu tiên (tiêu đề)
                    $headers = fgetcsv($file);

                    echo '<table>';
                    echo '<thead><tr>';
                    echo '<th class="row-number">#</th>';

                    // In tiêu đề
                    if ($headers) {
                        foreach ($headers as $header) {
                            echo '<th>' . htmlspecialchars($header) . '</th>';
                        }
                    }
                    echo '</tr></thead>';
                    echo '<tbody>';

                    // Đọc và in các hàng dữ liệu
                    $rowNumber = 1;
                    while (($row = fgetcsv($file)) !== FALSE) {
                        echo '<tr>';
                        echo '<td class="row-number">' . $rowNumber . '</td>';
                        foreach ($row as $cell) {
                            echo '<td>' . htmlspecialchars($cell) . '</td>';
                        }
                        echo '</tr>';
                        $rowNumber++;
                    }

                    echo '</tbody>';
                    echo '</table>';

                    fclose($file);

                    // Hiển thị thống kê
                    echo '<div class="stats">';
                    echo '✓ Tổng số sinh viên: <strong>' . ($rowNumber - 1) . '</strong>';
                    echo '</div>';
                } else {
                    echo '<div class="error">❌ Lỗi: Không thể mở tệp CSV!</div>';
                }
            }
            ?>
        </div>
    </div>
</body>

</html>