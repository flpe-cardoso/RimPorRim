<?php
session_start();
$usuarioLogado = isset($_SESSION['usuario_id']);

$foto_perfil = "../uploads/default.png"; // foto padrão

if ($usuarioLogado) {
    include("../auth/conexao.php");

    $usuario_id = $_SESSION['usuario_id'];
    $sql = "SELECT foto_perfil FROM usuarios WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()) {
        $foto_perfil = $row["foto_perfil"] ?? "../uploads/default.png";
    }
    $stmt->close();
}
?>