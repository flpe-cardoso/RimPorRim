<!-- Verificar login -->
<?php include("../includes/verificar_login.php"); ?>

<!DOCTYPE html>
<html>
    
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profissionais | Rim Por Rim</title>
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/pagina_profissional.css">

</head>
<body style="background-image: url('../assets/img/outroroxo.jpg'); background-size: cover;">
    
<header>
  <nav class="navbar">
    <!-- header -->
        <?php include("../includes/header.php"); ?>
  </nav>
</header>

<div class="content">
    <h1>Compartilhe seu<br>Conhecimento!</h1>
    <p>Venha fazer parte dessa equipe.<br>Se prepare para conscientizar!</p>
    <div style="display: flex; gap: 10px;"> <!-- container para os botões lado a lado -->
        <a href="../posts/forum.php" class="btnpro">Acesse o fórum</a>
        <a href="https://forms.gle/TxcFnR8Gw82FbkKL9" class="btnpro">Verificar sua conta profissional</a>
    </div>
</div>

<img src="../assets/img/medicodesenho.png" class="imagem">

</body>
</html>
