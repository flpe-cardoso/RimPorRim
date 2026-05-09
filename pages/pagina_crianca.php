<!-- Verificar login -->
<?php include("../includes/verificar_login.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Jogos | Rim Por Rim</title>
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/pagina_crianca.css">

  <link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap" rel="stylesheet">
  
</head>
<header>
    <nav class="navbar">
        <!-- header -->
        <?php include("../includes/header.php"); ?>
    </nav>
</header>

<body>
  <section class="area-jogos">
    <div class="conteudo">
      <div class="texto">
        <h1>Área de Jogos</h1>
        <p>
          Bem-vindo à nossa área interativa! Aqui você poderá aprender sobre <strong>saúde renal</strong> enquanto se
          diverte com jogos educativos.
          <br><br>
          Explore, descubra e aprenda de um jeito leve e divertido!
        </p>
        <a href="jogos.php" class="btn-jogar">Ir para os Jogos</a>
      </div>

      <img class="menino" src="../assets/img/Crianca.png" alt="Menino personagem">
    </div>
  </section>

</body>

</html>
