<?php
include 'db_connection.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$username]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        header("Location: index.php");
        exit();
    } else {
        echo "Nome de usuário ou senha incorretos.";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="style/style.css">
</head>
<body>
    <h2>Login</h2>
    <form method="post" action="login.php">
        <input type="text" name="username" placeholder="Nome de usuário" required><br>
        <input type="password" name="password" placeholder="Senha" required><br>
        <button type="submit">Login</button>

        <p>Não tem uma conta? <a href="register.php">Registre-se aqui</a></p> <!-- Link para a página de registro -->

    </form>
</body>
</html>
