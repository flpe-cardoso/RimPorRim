<?php

function atualizar_ofensiva($conn, $usuario_id) {
    // Busca os dados da ofensiva
    $sql = "SELECT ofensiva, ultima_atividade FROM usuarios WHERE usuario_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($row = $result->fetch_assoc()) {
        $ofensiva = (int)($row["ofensiva"] ?? 0);
        $ultima_atividade = $row["ultima_atividade"];
        
        $hoje = date('Y-m-d');
        $ontem = date('Y-m-d', strtotime('-1 day'));
        
        // Se já atualizou hoje, não faz nada
        if ($ultima_atividade === $hoje) {
            $stmt->close();
            return;
        }
        
        // Se a última atividade foi ontem, incrementa
        if ($ultima_atividade === $ontem || $ultima_atividade === null) {
            $ofensiva++;
        } else {
            // Se faz mais de um dia, reseta para 1
            $ofensiva = 1;
        }
        
        // Atualiza no banco
        $update_sql = "UPDATE usuarios SET ofensiva = ?, ultima_atividade = ? WHERE usuario_id = ?";
        $update_stmt = $conn->prepare($update_sql);
        $update_stmt->bind_param("isi", $ofensiva, $hoje, $usuario_id);
        $update_stmt->execute();
        $update_stmt->close();
    }
    $stmt->close();
}
?>
