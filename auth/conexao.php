<?php
include_once(__DIR__ . '/../config.php');

// Criar conexão
$conn = new mysqli($db_servidor, $db_usuario, $db_senha, $db_nome);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
