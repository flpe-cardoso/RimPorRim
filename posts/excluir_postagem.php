<?php
session_start();
include('../auth/conexao.php');

header('Content-Type: application/json');

if (!isset($_SESSION['usuario_id'])) {
    echo json_encode(['erro' => 'Usuário não logado']);
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = strtolower($_SESSION['tipo']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['postagem_id'])) {
    $postagem_id = (int)$_POST['postagem_id'];

    // Verifica se usuário pode excluir
    $sql = "SELECT usuario_id FROM postagens WHERE postagem_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $postagem_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $post = $resultado->fetch_assoc();
        if ($post['usuario_id'] == $usuario_id || $tipo_usuario === 'profissional') {
            $sql_delete = "UPDATE postagens SET excluida = 1 WHERE postagem_id = ?";
            $stmt_del = $conn->prepare($sql_delete);
            $stmt_del->bind_param("i", $postagem_id);
            $stmt_del->execute();
            $stmt_del->close();

            echo json_encode(['sucesso' => true]);
        } else {
            echo json_encode(['erro' => 'Você não pode excluir este post']);
        }
    } else {
        echo json_encode(['erro' => 'Post não encontrado']);
    }

    $stmt->close();
} else {
    echo json_encode(['erro' => 'Postagem inválida']);
}

$conn->close();
