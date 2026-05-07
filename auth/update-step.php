<?php
header('Content-Type: application/json');
session_start();

require_once 'conexao.php';

$data = json_decode(file_get_contents('php://input'), true);

$usuario_id = $_SESSION['usuario_id'] ?? null;
$step_id    = isset($data['step_id']) ? (int)$data['step_id'] : null;

if (!$usuario_id || !$step_id) {
    http_response_code(400);
    echo json_encode(['erro' => 'Dados inválidos']);
    exit;
}

// 🔍 pega progresso atual
$sql = "SELECT step_atual FROM user_progress WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['erro' => $conn->error]);
    exit;
}

$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$step_atual = isset($row['step_atual']) ? (int)$row['step_atual'] : 0;

// 🔒 BLOQUEIO DE PROGRESSO
if ($step_id <= $step_atual) {
    http_response_code(200);
    echo json_encode(['ok' => true, 'msg' => 'Já concluído']);
    exit;
}

// ✅ INSERT / UPDATE
$sql = "
    INSERT INTO user_progress (usuario_id, step_atual)
    VALUES (?, ?)
    ON DUPLICATE KEY UPDATE step_atual = VALUES(step_atual)
";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    http_response_code(500);
    echo json_encode(['erro' => $conn->error]);
    exit;
}

$stmt->bind_param("ii", $usuario_id, $step_id);

if (!$stmt->execute()) {
    http_response_code(500);
    echo json_encode(['erro' => $stmt->error]);
    exit;
}

// Atualizar ofensiva
require_once '../includes/atualizar_ofensiva.php';
atualizar_ofensiva($conn, $usuario_id);

echo json_encode(['ok' => true]);