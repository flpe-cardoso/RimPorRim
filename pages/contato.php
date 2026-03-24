<!-- Verificar login -->
<?php include("../includes/verificar_login.php"); ?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/reset.css">
    <link rel="stylesheet" href="../assets/css/contato.css">

    <title>Contato | Rim Por Rim</title>

</head>

<body>

    <header>
        <nav class="navbar">
            <!-- header -->
            <?php include("../includes/header.php"); ?>
        </nav>
    </header>
    <center>
        <br>
        <h1>Entre em contato</h1>
        <br>
        <p>Nos informe caso tenha alguma duvida sobre o site,</p><p>
ou tenha encontrado algum tipo de erro.
        </p> 
    </center>

    <div class="container">
        <form action="#" method="post">

            <label for="nome">Nome</label>
            <input type="text" id="nome" name="nome" required>

            <label for="email">E-mail</label>
            <input type="email" id="email" name="email" required>

            <label for="assunto">Assunto</label>
            <input type="text" id="assunto" name="assunto">

            <label for="mensagem">Mensagem</label>
            <textarea id="mensagem" name="mensagem" required></textarea>

            <button type="submit">Enviar Mensagem</button>

        </form>
    </div>
</body>

</html>