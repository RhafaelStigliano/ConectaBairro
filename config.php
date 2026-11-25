<?php
// Ajuste os dados conforme seu MySQL local.
$host = 'localhost';
$db   = 'conectabairro';
$user = 'root';
$pass = ''; // XAMPP normalmente usa senha vazia no MySQL local.

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$db;charset=utf8mb4",
        $user,
        $pass,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
         PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC]
    );
} catch (PDOException $e) {
    die("Não foi possível conectar ao banco. Confira o config.php e importe database.sql. Detalhe: " . htmlspecialchars($e->getMessage()));
}
