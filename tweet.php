<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $content = $_POST['content'];
    $image_path = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $image_name = time() . '_' . $_FILES['image']['name'];
        $image_path = 'uploads/' . $image_name;
        move_uploaded_file($_FILES['image']['tmp_name'], $image_path);
    }

    if (strlen($content) <= 280) {
        $sql = "INSERT INTO tweets (user_id, content, image_path) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$_SESSION['user_id'], $content, $image_path]);
        echo "Tweet postado com sucesso!";
    } else {
        echo "O tweet excede o limite de 280 caracteres.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Postar Tweet</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <h2>Postar um novo Tweet</h2>
    <form method="post" action="tweet.php" enctype="multipart/form-data">
        <textarea name="content" placeholder="O que está acontecendo?" maxlength="280" required></textarea><br>
        <input type="file" name="image" accept="image/*"><br>
        <button type="submit">Tweetar</button>
    </form>
    <a href="index.php">Voltar para a página principal</a>
</body>
</html>
