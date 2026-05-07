<!-- Verificar login -->
<?php include("../includes/verificar_login.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Trilha do Aprendizado | Rim Por Rim</title>

  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/roadmap.css">
  <link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap" rel="stylesheet">

</head>

<body>

  <div id="root" class="trail-app">

    <!-- HEADER -->
    <nav class="navbar">
      <!-- header -->
      <?php include("../includes/header.php"); ?>
    </nav>
    <header class="trail-header">

      <button class="trail-back-btn" id="btn-voltar">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
          stroke-linecap="round">
          <polyline points="15 18 9 12 15 6" />
        </svg>
        Voltar
      </button>

      <h1 class="trail-title">
        <span class="trail-title__dark">Trilha do </span>
        <span class="trail-title__orange">Aprendizado</span>
      </h1>

      <div class="trail-flame-badge">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#f97316">
          <path
            d="M12 23c-3.87 0-7-3.13-7-7 0-2.38 1.19-4.47 3-5.74V11c0 1.1.9 2 2 2h4c1.1 0 2-.9 2-2v-.48C17.69 11.7 19 13.72 19 16c0 3.87-3.13 7-7 7zM12 1C12 1 7 5.5 7 10c0 2.76 2.24 5 5 5s5-2.24 5-5C17 5.5 12 1 12 1z" />
        </svg>
        <span class="trail-flame-badge__count" id="flame-count">0</span>
      </div>
    </header>

    <!-- BARRA DE PROGRESSO -->
    <div class="trail-progress-wrapper">
      <div class="trail-progress-labels">
        <span class="trail-progress-label">PROGRESSO</span>
        <span class="trail-progress-label trail-progress-label--pct" id="progress-pct">0%</span>
      </div>
      <div class="trail-progress-track">
        <div class="trail-progress-fill" id="progress-fill" style="width: 0%"></div>
      </div>
    </div>

    <!-- TRILHA (scroll horizontal) -->
    <div class="trail-scroll" id="trail-scroll">
      <div class="trail-inner" id="trail-inner">
      </div>
    </div>
    <p class="trail-hint" id="trail-hint" style="display:none">
      CLIQUE PARA MARCAR COMO CONCLUÍDO · ARRASTE OU ROLE PARA NAVEGAR
    </p>

  </div>
  <script src="../includes/roadmap.js"></script>
</body>

</html>