<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['ultima_pagina'] = $_SERVER['REQUEST_URI'];
    header("Location: ../auth/login.html");
    exit();
}

if(strtolower($_SESSION['tipo']) !== 'profissional') {
    die("Apenas profissionais podem responder postagens.");
}

include('../auth/conexao.php');

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $postagem_id = intval($_POST['postagem_id'] ?? 0);
    $mensagem = $_POST['mensagem'] ?? '';

    if ($postagem_id > 0 && !empty(trim($mensagem))) {
        $sql = "INSERT INTO respostas_postagem (postagem_id, usuario_id, mensagem) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("iis", $postagem_id, $usuario_id, $mensagem);
        $stmt->execute();
        $stmt->close();
    }
}
header("Location: ../posts/forum.php");
exit();
