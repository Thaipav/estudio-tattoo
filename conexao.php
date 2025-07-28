<?php
$host = 'localhost';
$dbname = 'estudio';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexao realizada com sucesso!";
} catch (PDOException $e) {
    echo "Erro na conexao: " . $e->getMessage();
}
?>
