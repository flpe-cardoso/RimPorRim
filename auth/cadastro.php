<?php

include_once('conexao.php');

if (isset($_POST['cadastro'])) {
    $nome = $_POST['nome'] ?? '';
    $email = $_POST['email'] ?? '';
    $senha = $_POST['senha'] ?? '';
    $tipo = $_POST['tipo'] ?? '';

    // Verificar se o e-mail já existe
    $checkEmailSql = "SELECT usuario_id FROM usuarios WHERE email = ?";
    $checkStmt = $conn->prepare($checkEmailSql);
    $checkStmt->bind_param("s", $email);
    $checkStmt->execute();
    $checkStmt->store_result();

    if ($checkStmt->num_rows > 0) {
        echo "<script>
            alert('Este e-mail já está cadastrado. Tente outro.');
            window.history.back();
        </script>";
        $checkStmt->close();
        $conn->close();
        exit();
    }
    $checkStmt->close();

    // Criptografar a senha
    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    // Inserir novo usuário
    $sql = "INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);

    if ($stmt) {
        $stmt->bind_param("ssss", $nome, $email, $senhaHash, $tipo);
        if ($stmt->execute()) {
            echo "<script>
                alert('Cadastro realizado com sucesso!');
                window.location.href = 'Login.html';
            </script>";
        } else {
            echo "<script>
                alert('Erro ao cadastrar: " . $stmt->error . "');
                window.history.back();
            </script>";
        }
        $stmt->close();
    } else {
        echo "<script>
            alert('Erro ao preparar a consulta: " . $conn->error . "');
            window.history.back();
        </script>";
    }

    $conn->close();
}
?>
