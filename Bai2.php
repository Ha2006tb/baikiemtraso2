<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "quanly_hocsinh";


function khoiTaoDatabase($host,$user, $pass,$dbname) {
    try {
        $pdo = new PDO("mysql:host=$host", $user, $pass);$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
        $pdo->exec("USE `$dbname` ");

        $sql = "CREATE TABLE IF NOT EXISTS hoc_sinh (
            id INT AUTO_INCREMENT PRIMARY KEY,
            name VARCHAR(100) NOT NULL,
            age INT NOT NULL,
            grade FLOAT NOT NULL
        )";
        $pdo->exec($sql);

        $stmt =$pdo->query("SELECT COUNT(*) FROM hoc_sinh");
        if ($stmt->fetchColumn() == 0) {$insertSql = "INSERT INTO hoc_sinh (name, age, grade) VALUES
                ('Nguyễn Văn A', 18, 8.5),
                ('Trần Thị B', 18, 9.2),
                ('Lê Văn C', 19, 7.8),
                ('Phạm Thị D', 18, 9.5)";
            $pdo->exec($insertSql);
        }

        return $pdo;
    } catch (PDOException $e) {
        die("Lỗi CSDL: " . $e->getMessage());
    }
}

function layDanhSachHocSinh($pdo) {
    $stmt =$pdo->query("SELECT * FROM hoc_sinh");
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

function hienThiDanhSach($students) {
    echo "<h3>Danh sách học sinh (lấy từ Database):</h3>";
    foreach ($students as$student) {
        echo "ID: " . $student['id'] . " - Tên: " . $student['name'] . " - Tuổi: " . $student['age'] . " - Điểm: " . $student['grade'] . "<br>";
    }
}

function hienThiHocSinhDiemCaoNhat($pdo) {
    $topStmt =$pdo->query("SELECT * FROM hoc_sinh ORDER BY grade DESC LIMIT 1");
    $topStudent =$topStmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Học sinh có điểm cao nhất:</h3>";
    if ($topStudent) {
        echo "Tên: " . $topStudent['name'] . " - Điểm: " . $topStudent['grade'];
    }
}

$pdo = khoiTaoDatabase($host,$user, $pass,$dbname);

$students = layDanhSachHocSinh($pdo);
hienThiDanhSach($students);

hienThiHocSinhDiemCaoNhat($pdo);
?>