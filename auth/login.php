<?php
session_start();
$usuarioLogado = isset($_SESSION['usuario_id']);
include('conexao.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';

    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows === 1) {
        $usuario = $resultado->fetch_assoc();

        if (password_verify($senha, $usuario['senha'])) {
            // 🔹 Salva dados do usuário em variáveis individuais na sessão
            $_SESSION['usuario_id']  = $usuario['usuario_id'];
            $_SESSION['nome']        = $usuario['nome'];
            $_SESSION['email']       = $usuario['email'];
            $_SESSION['tipo']        = $usuario['tipo'];
            $_SESSION['foto_perfil'] = $usuario['foto_perfil']; // pode ser NULL

            // Corrige o caminho de redirecionamento
            $destino = $_SESSION['ultima_pagina'] ?? $_SERVER['HTTP_REFERER'] ?? '/tcc/rimporrim/index.php';
            if (preg_match('/login\.php|login\.html/i', $destino)) {
                $destino = '/tcc/public/index.php';
            }
            unset($_SESSION['ultima_pagina']);
            
            header("Location: $destino");
            exit();
        } else {
            echo "<script>alert('❌ Senha incorreta.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('❌ Usuário não encontrado.'); window.history.back();</script>";
    }

    $stmt->close();
    $conn->close();
}
?>
