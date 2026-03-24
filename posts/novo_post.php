<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['ultima_pagina'] = $_SERVER['REQUEST_URI'];
    header("Location: ../auth/login.html");
    exit();
}

include('../auth/conexao.php');

$usuario_id = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mensagem = $_POST['mensagem'] ?? '';
    if (!empty(trim($mensagem))) {
        $sql = "INSERT INTO postagens (usuario_id, mensagem) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("is", $usuario_id, $mensagem);
        $stmt->execute();
        $stmt->close();
        header("Location: ../posts/forum.php");
        exit();
    } else {
        $erro = "Digite uma mensagem válida.";
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/novo_post.css">

    <title>Nova Pergunta | Rim Por Rim</title>
</head>

<body>
    <div class="container">
        <h2>Fazer uma pergunta</h2>
        <?php if (isset($erro))
            echo "<p class='erro'>$erro</p>"; ?>
        <form method="POST">
            <textarea name="mensagem" rows="5" cols="50" placeholder="Digite sua pergunta..." required></textarea><br>
            <button type="submit">Postar</button>
        </form>
        <p><a href="../posts/forum.php">Voltar</a></p>
    </div>
</body>

</html>