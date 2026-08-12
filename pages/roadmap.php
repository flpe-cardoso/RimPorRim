<?php 
include("../includes/verificar_login.php"); 
if (!$usuarioLogado) {
    $_SESSION['ultima_pagina'] = $_SERVER['REQUEST_URI'];
    header("Location: ../auth/login.html");
    exit();
}
?>

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