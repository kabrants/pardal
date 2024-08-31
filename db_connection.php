<?php
$servername = "localhost";
$username = "root";  // altere se necessário
$password = "";  // altere se necessário
$dbname = "twitter_prototipo";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>