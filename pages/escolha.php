<!-- Verificar login -->
<?php include("../includes/verificar_login.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escolha | Rim Por Rim</title>
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/escolha.css">
    <link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap" rel="stylesheet">
</head>
<header>
    <nav class="navbar">
        <!-- header -->
        <?php include("../includes/header.php"); ?>
    </nav>
</header>

<body>

    <section class="Meio_escolha">
    <h1 class="titulo_escolha">Escolha a página</h1>

    <div class="container_botoes">
        <a href="pagina_crianca.php" class="btn_infantil button">
            <span class="texto_botao">Jogos educativos</span>
        </a>

        <a href="pagina_adulto.php" class="btn_adulto button">
            <span class="texto_botao">Responsável</span>
        </a>

        <a href="pagina_profissional.php" class="btn_profissional button">
            <span class="texto_botao">Profissional</span>
        </a>
    </div>
</section> 
</body>

</html>