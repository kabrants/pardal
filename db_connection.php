<?php
// Obter as variáveis de ambiente
$servername = getenv('mysql.railway.internal');
$username = getenv('root');
$password = getenv('kznStRpAmQTFvMYcDVOJjShaCaACMptD');
$dbname = getenv('railway');

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>
