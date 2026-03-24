<?php
session_start();
$usuarioLogado = isset($_SESSION['usuario_id']);
include("../auth/conexao.php");

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    $_SESSION['ultima_pagina'] = $_SERVER['REQUEST_URI'];
    header("Location: ../auth/login.html");
    exit;
}

// Dados do usuário
$usuario_id = $_SESSION['usuario_id'];
$nome = $_SESSION['nome'];
$email = $_SESSION['email'];
$tipo = $_SESSION['tipo'];
$fotoPerfil = $_SESSION['foto_perfil'] ?? "../uploads/default.png";

// Cria pasta uploads se não existir
$diretorio = "../uploads/";
if (!is_dir($diretorio))
    mkdir($diretorio, 0777, true);

// Upload de foto
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['foto'])) {
    $arquivo = $_FILES['foto'];
    if ($arquivo['error'] == 0) {
        $extensao = strtolower(pathinfo($arquivo['name'], PATHINFO_EXTENSION));
        $novoNome = $usuario_id . "." . $extensao;
        $caminho = $diretorio . $novoNome;

        if (move_uploaded_file($arquivo['tmp_name'], $caminho)) {
            $sql = "UPDATE usuarios SET foto_perfil = ? WHERE usuario_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("si", $caminho, $usuario_id);
            $stmt->execute();
            $stmt->close();

            $_SESSION['foto_perfil'] = $caminho;
            $fotoPerfil = $caminho;
            $mensagem = "Foto de perfil atualizada!";
        } else {
            $mensagem = "Erro ao mover o arquivo.";
        }
    } else {
        $mensagem = "Erro no upload.";
    }
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/perfil.css">

    <title>Perfil | Rim Por Rim</title>
</head>

<body>
    <div class="container">
        <h1>Bem-vindo, <?= htmlspecialchars($nome) ?>!</h1>
        <div class="info">Email: <?= htmlspecialchars($email) ?></div>

        <form method="POST" enctype="multipart/form-data">
            <div class="profile-pic">
                <img src="<?= htmlspecialchars($fotoPerfil) ?>" alt="Foto de Perfil">
            </div>
            <label class="custom-file-upload">
                Escolher Foto
                <input type="file" name="foto" accept="image/*" required>
            </label>
            <br>
            <button type="submit">Atualizar Foto</button>
        </form>

        <?php if (isset($mensagem))
            echo "<p class='mensagem'>$mensagem</p>"; ?>

        <div class="links">
            <a href="../public/index.php">Voltar</a> |
            <a href="../auth/logout.php">Sair</a>
        </div>
    </div>

</body>

</html>