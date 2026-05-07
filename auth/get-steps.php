<?php
header('Content-Type: application/json');
session_start();

require_once 'conexao.php';

if (!isset($_SESSION['usuario_id'])) {
    http_response_code(401);
    echo json_encode(['erro' => 'Não autenticado']);
    exit;
}

$usuario_id = $_SESSION['usuario_id'];

// 🔍 pega progresso atual
$sql = "SELECT step_atual FROM user_progress WHERE usuario_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $usuario_id);
$stmt->execute();

$result = $stmt->get_result();
$row = $result->fetch_assoc();

$step_atual = $row['step_atual'] ?? 0;

// 📋 busca todas etapas (AGORA COM URL)
$sql = "SELECT id, titulo, icone, url FROM steps ORDER BY id ASC";
$result = $conn->query($sql);

$steps = [];

while ($row = $result->fetch_assoc()) {
    $row['concluido'] = ($row['id'] <= $step_atual);
    $steps[] = $row;
}

echo json_encode(['steps' => $steps]);