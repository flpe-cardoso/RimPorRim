<!-- Verificar login -->
<?php include("../includes/verificar_login.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Início | Rim Por Rim</title>
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/index.css">
  <link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap" rel="stylesheet">
</head>

<header>
  <nav class="navbar">
    <!-- header -->
        <?php include("../includes/header.php"); ?>

  </nav>
</header>

<body>
  <section class="Meio">
    <center>
      <table class="tabelaMeio">
        <tr>
          <th class="escritaDRC">
            <h1>DRC </h1>
            <h2>Doença Renal Crônica</h2>
          </th>
          <th>
            <img src="../assets/img/log.png" class="logoIndex" width="80%" height="400px" alt="Imagem principal">
          </th>
        </tr>
      </table>
      <br><br>
      <a href="../pages/escolha.php" class="saiba-mais">Saiba mais</a>
      <br><br><br><br><br><br>
    </center>
  </section>
  <!-- Footer -->
    <?php include("../includes/footer.html"); ?>
      

</body>

</html>