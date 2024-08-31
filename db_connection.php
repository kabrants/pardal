<?php
// Conexão usando PDO
$servername = "autorack.proxy.rlwy.net";
$username = "root";
$password = "kznStRpAmQTFvMYcDVOJjShaCaACMptD";
$dbname = "railway";
$port = 10905;

try {
    $conn = new PDO("mysql:host=$servername;port=$port;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
