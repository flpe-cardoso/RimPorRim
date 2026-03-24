<!-- Verificar login -->
<?php include("../includes/verificar_login.php"); ?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsáveis | Rim Por Rim</title>

  <link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/pagina_adulto.css">
</head>

<body>

<header>
<nav class="navbar">
<?php include("../includes/header.php"); ?>
</nav>
</header>

<div class="adultos-page">

<div class="area">

<div class="sidebar">
<button id="btn-drc" onclick="mostrarConteudo('drc')">O que é DRC</button>
<button id="btn-receitas" onclick="mostrarConteudo('receitas')">Receitas</button>
<button id="btn-videos" onclick="mostrarConteudo('videos')">Vídeos</button>
<button onclick="window.location.href='../posts/forum.php'">Fórum</button>
</div>

<div class="conteudo" id="conteudo"></div>
</div>

  <script>
    function mostrarConteudo(tipo) {

      const conteudo = document.getElementById("conteudo");
      const botoes = document.querySelectorAll(".adultos-page .sidebar button");

      botoes.forEach(btn => btn.classList.remove("active"));

      const botao = document.getElementById("btn-" + tipo);
      if (botao) botao.classList.add("active");

      conteudo.className = "conteudo";
      

      if (tipo === "drc") {

        conteudo.innerHTML = `
        <div class="conteudo">
          <h2>O que é DRC</h2>

          <p>
          A Doença Renal Crônica (DRC) acontece quando os rins vão perdendo, lentamente, 
          a capacidade de filtrar o sangue. O que isso significa? Significa que substâncias 
          que deveriam ser eliminadas acabam ficando no organismo, o que pode trazer vários 
          problemas de saúde. O grande desafio é que no começo a doença costuma ser silenciosa, 
          sem sintomas claros, o que dificulta a percepção de que algo está errado.
          </p>

          <p>
          Com o avanço da DRC, começam a surgir sinais como inchaço nas pernas, pressão alta, 
          cansaço frequente e mudanças na urina. Esses sintomas aparecem porque os rins já não 
          conseguem trabalhar como deveriam. É por isso que exames de sangue e urina feitos 
          regularmente são fundamentais, principalmente para quem tem fatores de risco como 
          diabetes, hipertensão ou histórico familiar.
          </p>

          <p>
          A melhor forma de conter o avanço da doença é cuidar bem da saúde no dia a dia. 
          Isso inclui controlar a pressão arterial e o diabetes, beber água na medida certa, 
          manter uma alimentação equilibrada e evitar excesso de sal. Além disso, o acompanhamento 
          médico é indispensável, já que quanto mais cedo a DRC é identificada, maiores são as 
          chances de prevenir complicações e garantir qualidade de vida.
          </p>

        </div>
        `;

      } else if (tipo === "receitas") {

        conteudo.classList.add("receitas-grid");

        conteudo.innerHTML = `
<div class="grid-wrap">

<h2>Receitas saudáveis</h2>
<p>Para ver mais verifique o <a download href="../docs/Minha Lancheira Amiga - Ebook.pdf" class="link_ebook">EBook</a></p>

<div class="grid">

<div id="receita1" class="receita">
<a href="conteudos/miojo.html">
<img src="../assets/img/Img_Miojo.jpg" alt="Miojo saudável">
<p>Miojo saudável</p>
</a>
</div>

<div id="receita2" class="receita">
<a href="conteudos/bolacha.html">
<img src="../assets/img/Img_bolacha.jpg" alt="Bolacha">
<p>Massa de bolacha</p>
</a>
</div>

<div id="receita3" class="receita">
<a href="conteudos/danone.html">
<img src="../assets/img/Img_DanoneMorango.jpg" alt="Danone Morango">
<p>Danone de Morango</p>
</a>
</div>

<div id="receita4" class="receita">
<a href="conteudos/bolinho.html">
<img src="../assets/img/Img_BolinhoChocolate.jpg" alt="Bolinho de Chocolate">
<p>Bolinho de Chocolate</p>
</a>
</div>

</div>
</div>
`;

      } else if (tipo === "videos") {

        conteudo.innerHTML = `
<h2>Vídeos das receitas</h2>

<div class="videos">

<div>
<h3>Bolinho de Iogurte</h3>
<video controls>
<source src="../assets/videos/Bolinho.mp4" type="video/mp4">
</video>
</div>

<div>
<h3>Iogurte de Couve Flor</h3>
<video controls>
<source src="../assets/videos/Danone.mp4" type="video/mp4">
</video>
</div>

<div>
<center><h3>Macarrão instantâneo sabor frango</h3>
<video controls>
<source src="../assets/videos/Miojo.mp4" type="video/mp4">
</video>
</center>
</div>

</div>
`;
      }
    }

    window.onload = function () {
      mostrarConteudo("drc");
    };
  </script>
</body>

</html>