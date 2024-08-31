<?php
include 'db_connection.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Excluir tweet se o ID do tweet for passado via POST
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['delete_tweet_id'])) {
    $tweet_id = $_POST['delete_tweet_id'];
    
    // Verificar se o tweet pertence ao usuário logado
    $sql = "SELECT * FROM tweets WHERE id = ? AND user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$tweet_id, $_SESSION['user_id']]);
    $tweet = $stmt->fetch();

    if ($tweet) {
        // Excluir o tweet
        $sql = "DELETE FROM tweets WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->execute([$tweet_id]);

        // Remover imagem associada, se houver
        if ($tweet['image_path'] && file_exists($tweet['image_path'])) {
            unlink($tweet['image_path']);
        }

        echo "Tweet excluído com sucesso!";
    } else {
        echo "Você não tem permissão para excluir este tweet.";
    }
}

// Fetch tweets from the database
$sql = "SELECT tweets.id, tweets.content, tweets.image_path, tweets.created_at, users.username 
        FROM tweets 
        INNER JOIN users ON tweets.user_id = users.id 
        ORDER BY tweets.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tweets = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Timeline</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <h2>Bem-vindo, <?php echo $_SESSION['username']; ?>!</h2>
    <a href="tweet.php" class="btn">Postar um Tweet</a> | 
    <a href="logout.php" class="btn">Sair</a>

    <h3>Timeline</h3>
    <?php foreach ($tweets as $tweet): ?>
        <div class="tweet">
            <p><strong><?php echo $tweet['username']; ?>:</strong> <?php echo $tweet['content']; ?></p>
            <?php if ($tweet['image_path']): ?>
                <img src="<?php echo $tweet['image_path']; ?>" alt="Imagem do tweet" style="max-width: 300px;">
            <?php endif; ?>
            <p><small><?php echo $tweet['created_at']; ?></small></p>
            <?php if ($tweet['username'] == $_SESSION['username']): ?>
                <form method="post" action="index.php" style="display:inline;">
                    <input type="hidden" name="delete_tweet_id" value="<?php echo $tweet['id']; ?>">
                    <button type="submit">Excluir</button>
                </form>
            <?php endif; ?>
            <hr>
        </div>
    <?php endforeach; ?>
</body>
</html>
