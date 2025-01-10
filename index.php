<?php
// 連接到 MySQL 數據庫
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "comments_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("連接失敗: " . $conn->connect_error);
}

// 如果接收到留言提交請求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $content = $_POST['content'];

    if (!empty($username) && !empty($content)) {
        $sql = "INSERT INTO comments (username, content) VALUES ('$username', '$content')";
        if ($conn->query($sql) === TRUE) {
            echo "留言成功！";
        } else {
            echo "留言失敗: " . $conn->error;
        }
    }
}

// 查詢所有留言
$sql = "SELECT username, content, created_at FROM comments ORDER BY created_at DESC";
$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html lang="zh-Hant">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>留言系統</title>
</head>
<body>

    <h1>留言板</h1>

    <form action="" method="POST">
        <input type="text" name="username" placeholder="您的名字" required><br>
        <textarea name="content" placeholder="請輸入您的留言" required></textarea><br>
        <button type="submit">提交留言</button>
    </form>

    <h2>留言區</h2>
    <?php
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<p><strong>" . $row['username'] . "</strong>: " . $row['content'] . " <em>於 " . $row['created_at'] . "</em></p>";
        }
    } else {
        echo "還沒有留言，趕快來留言吧！";
    }
    ?>

</body>
</html>

<?php
$conn->close();
?>
