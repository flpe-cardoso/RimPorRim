<?php
session_start();
$usuarioLogado = isset($_SESSION['usuario_id']);

$foto_perfil = "../uploads/default.png"; // foto padrão
$ofensiva = 0;

if ($usuarioLogado) {
    include_once(__DIR__ . "/../auth/conexao.php");

    $usuario_id = $_SESSION['usuario_id'];
    $sql = "SELECT foto_perfil, ofensiva, ultima_atividade FROM usuarios WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $foto_perfil = $row["foto_perfil"] ?? "../uploads/default.png";
        $ofensiva = (int)($row["ofensiva"] ?? 0);
        $ultima_atividade = $row["ultima_atividade"];
        
        $hoje = date('Y-m-d');
        $ontem = date('Y-m-d', strtotime('-1 day'));
        
        // Verifica se a ofensiva foi perdida
        // Se a última atividade não foi hoje e não foi ontem, ele perdeu a ofensiva (mais de 1 dia sem atividade)
        if ($ultima_atividade !== $hoje && $ultima_atividade !== $ontem && $ultima_atividade !== null) {
            $ofensiva = 0; // zera a ofensiva, mas não altera a última atividade ainda (só vai alterar quando concluir jogo/etapa)
            
            $update_sql = "UPDATE usuarios SET ofensiva = 0 WHERE usuario_id = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("i", $usuario_id);
            $update_stmt->execute();
            $update_stmt->close();
        }
    }
    $stmt->close();
}
?>