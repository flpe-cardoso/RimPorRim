<?php
include("../includes/verificar_login.php");
include_once("../auth/conexao.php");

// ID do jogo selecionado no filtro (padrão = 1 - Dino Rescue Cure)
$jogo_id = isset($_GET['jogo_id']) && (int)$_GET['jogo_id'] > 0 ? (int)$_GET['jogo_id'] : 1;

// Mapeamento dos nomes dos jogos
$jogos_nomes = [
    1 => "Dino Rescue Cure",
    2 => "Dino Remember Challenge",
    3 => "Dino Recipes Cook"
];

// Montar e executar consulta ao banco de dados
$sql = "SELECT j.usuario_id, j.jogo_id, j.pontuacao, u.nome, u.foto_perfil 
        FROM jogadores j
        JOIN usuarios u ON j.usuario_id = u.usuario_id
        WHERE j.jogo_id = ?
        ORDER BY j.pontuacao DESC LIMIT 10";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $jogo_id);
$stmt->execute();
$result = $stmt->get_result();

$ranking = [];
while ($row = $result->fetch_assoc()) {
    $ranking[] = $row;
}
$stmt->close();
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ranking | Rim Por Rim</title>
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/ranking.css">
  <link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap" rel="stylesheet">
</head>
<header>
  <nav class="navbar">
    <?php include("../includes/header.php"); ?>
  </nav>
</header>
<body class="pagina-ranking">

  <div class="ranking-container">
    <div class="ranking-header">
      <h1>🏆 Ranking Top 10</h1>
      <p>Confira os maiores pontuadores dos nossos jogos e tente alcançar o topo!</p>
    </div>

    <!-- Filtros por Jogo -->
    <div class="ranking-filtros">
      <a href="ranking.php?jogo_id=1" class="btn-filtro <?= $jogo_id === 1 ? 'active' : '' ?>">
        🦕 Dino Rescue Cure
      </a>
      <a href="ranking.php?jogo_id=2" class="btn-filtro <?= $jogo_id === 2 ? 'active' : '' ?>">
        🧠 Dino Remember Challenge
      </a>
      <a href="ranking.php?jogo_id=3" class="btn-filtro <?= $jogo_id === 3 ? 'active' : '' ?>">
        🍳 Dino Recipes Cook
      </a>
    </div>

    <!-- Lista do Ranking -->
    <div class="ranking-card">
      <?php if (empty($ranking)): ?>
        <div class="ranking-vazio">
          <span class="icone-vazio">🎮</span>
          <p>Nenhuma pontuação foi registrada ainda para este jogo.</p>
          <a href="jogos.php" class="btn-jogar-agora">Jogar Agora</a>
        </div>
      <?php else: ?>
        <div class="ranking-lista">
          <?php foreach ($ranking as $index => $item): 
            $posicao = $index + 1;
            
            // Tratamento da foto de perfil
            $foto = !empty($item['foto_perfil']) ? $item['foto_perfil'] : '../uploads/default.png';
            if (strpos($foto, '../') !== 0 && strpos($foto, 'uploads/') === 0) {
                $foto = '../' . $foto;
            }

            // Medalha e classe de destaque para o Top 3
            $medalha = "";
            $classe_posicao = "pos-outros";
            if ($posicao === 1) {
                $medalha = "🥇";
                $classe_posicao = "pos-1";
            } elseif ($posicao === 2) {
                $medalha = "🥈";
                $classe_posicao = "pos-2";
            } elseif ($posicao === 3) {
                $medalha = "🥉";
                $classe_posicao = "pos-3";
            }

            $nome_jogo = isset($jogos_nomes[$item['jogo_id']]) ? $jogos_nomes[$item['jogo_id']] : 'Jogo #' . $item['jogo_id'];
          ?>
            <div class="ranking-item <?= $classe_posicao ?>">
              <div class="ranking-posicao">
                <?php if ($medalha): ?>
                  <span class="medalha"><?= $medalha ?></span>
                <?php endif; ?>
                <span class="numero"><?= $posicao ?>º</span>
              </div>

              <div class="ranking-avatar">
                <img src="<?= htmlspecialchars($foto) ?>" alt="Foto de <?= htmlspecialchars($item['nome']) ?>">
              </div>

              <div class="ranking-info">
                <h3 class="nome-jogador"><?= htmlspecialchars($item['nome']) ?></h3>
                <span class="nome-jogo"><?= htmlspecialchars($nome_jogo) ?></span>
              </div>

              <div class="ranking-pontos">
                <span class="valor-pontos"><?= number_format($item['pontuacao'], 0, ',', '.') ?></span>
                <span class="label-pts">pts</span>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>

    <div class="ranking-footer-acao">
      <a href="jogos.php" class="btn-voltar-jogos">Ir para os Jogos</a>
    </div>
  </div>

</body>
</html>
