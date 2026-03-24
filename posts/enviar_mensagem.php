<?php
session_start();
include('../auth/conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = trim($_POST['mensagem'] ?? '');

    if ($mensagem !== '') {
        // Pega o ID do usuário da sessão (assumindo que ele foi validado no chat.php)
        $usuario_id = $_SESSION['usuario']['id'] ?? null;

        // Se ainda assim vier nulo, impede o envio silenciosamente
        if ($usuario_id !== null) {
            $sql = "INSERT INTO chat (usuario_id, mensagem) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt) {
                $stmt->bind_param("is", $usuario_id, $mensagem);
                $stmt->execute();
                $stmt->close();
            }
        }
    }
}

$conn->close();
header("Location: ../auth/chat.php");
exit();
