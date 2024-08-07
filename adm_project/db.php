<?php
$host = 'localhost';
$db = 'controle_estoque';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}

function getTotals($pdo) {
    $stmt = $pdo->query("SELECT SUM(quantidade) as total_quantidade, SUM(quantidade * preco) as total_valor FROM produtos");
    return $stmt->fetch(PDO::FETCH_ASSOC);
}

?>

