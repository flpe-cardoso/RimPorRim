<?php
session_start();

header("Content-Type: application/json");

// Verifica login
if (!isset($_SESSION["usuario_id"])) {
    echo json_encode(["status" => "erro", "msg" => "não autorizado"]);
    exit;
}

// Conexão BD
$conn = new mysqli("localhost", "root", "", "jogo");

// Receber pontos
$pontuacao = isset($_GET["pontuacao"]) ? (int)$_GET["pontuacao"] : 0;

// Validação básica
if ($pontuacao <= 0 || $pontuacao > 2000) {
    echo json_encode(["status" => "erro", "msg" => "pontuação inválida"]);
    exit;
}

// Rate limit (anti spam)
if (isset($_SESSION["ultimo_envio"])) {
    if (time() - $_SESSION["ultimo_envio"] < 3) {
        echo json_encode(["status" => "erro", "msg" => "muito rápido"]);
        exit;
    }
}
$_SESSION["ultimo_envio"] = time();

// Usuário da sessão
$usuario_id = $_SESSION["usuario_id"];

// Verifica se já existe
$stmt = $conn->prepare("SELECT pontuacao FROM jogadores WHERE usuario_id = ?");
$stmt->bind_param("i", $usuario_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();
    $pontuacaoAtual = (int)$row["pontuacao"];

    // Só atualiza se for maior
    if ($pontuacao > $pontuacaoAtual) {

        $update = $conn->prepare("UPDATE jogadores SET pontuacao = ? WHERE usuario_id = ?");
        $update->bind_param("ii", $pontuacao, $usuario_id);
        $update->execute();

        echo json_encode([
            "status" => "atualizado",
            "anterior" => $pontuacaoAtual
        ]);

    } else {

        echo json_encode([
            "status" => "mantido",
            "atual" => $pontuacaoAtual
        ]);
    }

} else {

    // Novo jogador
    $insert = $conn->prepare("INSERT INTO jogadores (usuario_id, pontuacao) VALUES (?, ?)");
    $insert->bind_param("ii", $usuario_id, $pontuacao);
    $insert->execute();

    echo json_encode([
        "status" => "novo"
    ]);
}

$conn->close();
?>