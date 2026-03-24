<!-- Verificar login -->
<?php include("../includes/verificar_login.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jogos | Rim Por Rim</title>
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/jogos.css">
  <link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap" rel="stylesheet">


  <script>
    function mostrarJogo(tipo) {
      const conteudo = document.getElementById("conteudo");
      const botoes = document.querySelectorAll(".sidebar button");
      botoes.forEach(btn => btn.classList.remove("active"));
      document.getElementById("btn-" + tipo).classList.add("active");

      let html = "";
      if (tipo === "jogo1") {
        html = `<iframe src="../jogos/TCC_Pou/index.html"></iframe>`;
      } else if (tipo === "jogo2") {
        html = `<iframe src="../jogos/TCC_Receita/index.html"></iframe>`;
      } else if (tipo === "jogo3") {
        html = `<iframe src=""></iframe>`;
      }

      conteudo.innerHTML = html;
    }

    window.onload = () => {
      mostrarJogo("jogo1");
    };
  </script>
</head>
 <header>
  <nav class="navbar">
    <!-- header -->
        <?php include("../includes/header.php"); ?>
  </nav>
</header>
<body class="pagina-jogos">
 

  <!-- CONTAINER PRINCIPAL -->
  <div class="container-geral">
    <div class="sidebar">
      <button id="btn-jogo1" onclick="mostrarJogo('jogo1')">Dino Rescue Cure</button>
      <button id="btn-jogo2" onclick="mostrarJogo('jogo2')">Dino Recipes Cook</button>
      <button id="btn-jogo3" onclick="mostrarJogo('jogo3')">Dino Remember Challenge</button>
    </div>
    <div class="conteudo" id="conteudo"></div>
  </div>
  
</body>
</html>
