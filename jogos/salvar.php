<?php
session_start();
header("Content-Type: application/json");


// Verifica login
if (!isset($_SESSION["usuario_id"])) {

    echo json_encode([
        "status" => "erro",
        "msg" => "não autorizado"
    ]);

    exit;
}

// Usuário da sessão
$usuario_id = $_SESSION["usuario_id"];

// Conexão BD
$conn = new mysqli("localhost", "root", "", "RimPorRim_DB");


if ($conn->connect_error) {

    echo json_encode([
        "status" => "erro",
        "msg" => "erro na conexão"
    ]);

    exit;
}



// Receber dados
$pontuacao = isset($_GET["pontuacao"]) 
    ? (int)$_GET["pontuacao"] 
    : 0;


$jogo_id = isset($_GET["jogo_id"]) 
    ? (int)$_GET["jogo_id"] 
    : 0;



// Validação básica
if ($pontuacao <= 0 || $pontuacao > 2000) {

    echo json_encode([
        "status" => "erro",
        "msg" => "pontuação inválida"
    ]);

    exit;
}

// Verifica se existe pontuação desse usuário nesse jogo
$stmt = $conn->prepare(
    "SELECT pontuacao 
     FROM jogadores 
     WHERE usuario_id = ?
     AND jogo_id = ?"
);


$stmt->bind_param(
    "ii",
    $usuario_id,
    $jogo_id
);

$stmt->execute();

$result = $stmt->get_result();

if ($result->num_rows > 0) {

    $row = $result->fetch_assoc();

    $pontuacaoAtual = (int)$row["pontuacao"];

    // Atualiza apenas se bater recorde
    if ($pontuacao > $pontuacaoAtual) {

        $update = $conn->prepare(
            "UPDATE jogadores
             SET pontuacao = ?
             WHERE usuario_id = ?
             AND jogo_id = ?"
        );

        $update->bind_param(
            "iii",
            $pontuacao,
            $usuario_id,
            $jogo_id
        );

        $update->execute();

        echo json_encode([
            "status" => "atualizado",
            "anterior" => $pontuacaoAtual,
            "nova" => $pontuacao
        ]);

    } else {

        echo json_encode([
            "status" => "mantido",
            "atual" => $pontuacaoAtual
        ]);

    }

} else {

    // Primeiro registro desse jogo

    $insert = $conn->prepare(
        "INSERT INTO jogadores
        (usuario_id, jogo_id, pontuacao)
        VALUES (?, ?, ?)"
    );

    $insert->bind_param(
        "iii",
        $usuario_id,
        $jogo_id,
        $pontuacao
    );

    $insert->execute();

    echo json_encode([
        "status" => "novo"
    ]);
}

$conn->close();

?>