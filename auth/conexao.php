<?php
$servidor = "localhost";
$usuario = "root";
$senha = ""; 
$dbname = "chat_drc"; 

// Criar conexão
$conn = new mysqli($servidor, $usuario, $senha, $dbname);

// Verificar conexão
if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
