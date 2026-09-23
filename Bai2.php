<?php
$host = "localhost";
$user = "root";
$pass = "";
$dbname = "quanly_hocsinh";

try {
    $pdo = new PDO("mysql:host=$host", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `$dbname`");

    $sql = "CREATE TABLE IF NOT EXISTS hoc_sinh (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        age INT NOT NULL,
        grade FLOAT NOT NULL
    )";
    $pdo->exec($sql);

    $stmt = $pdo->query("SELECT COUNT(*) FROM hoc_sinh");
    if ($stmt->fetchColumn() == 0) {
        $insertSql = "INSERT INTO hoc_sinh (name, age, grade) VALUES
            ('Nguyễn Văn A', 18, 8.5),
            ('Trần Thị B', 18, 9.2),
            ('Lê Văn C', 19, 7.8),
            ('Phạm Thị D', 18, 9.5)";
        $pdo->exec($insertSql);
    }

    echo "<h3>Danh sách học sinh (lấy từ Database):</h3>";
    $stmt = $pdo->query("SELECT * FROM hoc_sinh");
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($students as $student) {
        echo "ID: " . $student['id'] . " - Tên: " . $student['name'] . " - Tuổi: " . $student['age'] . " - Điểm: " . $student['grade'] . "<br>";
    }

    $topStmt = $pdo->query("SELECT * FROM hoc_sinh ORDER BY grade DESC LIMIT 1");
    $topStudent = $topStmt->fetch(PDO::FETCH_ASSOC);

    echo "<h3>Học sinh có điểm cao nhất:</h3>";
    if ($topStudent) {
        echo "Tên: " . $topStudent['name'] . " - Điểm: " . $topStudent['grade'];
    }

} catch (PDOException $e) {
    echo "Lỗi CSDL: " . $e->getMessage();
}
?>