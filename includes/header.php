   <link rel="stylesheet" href="../assets/css/header.css">

<!-- menu mobile -->
<?php include("../includes/mobile.html"); ?>
<!-- menu -->

<div class="logo"><a href="../public/index.php"><img src="../assets/img/Imagem rim.png" class="img_navbar" alt="Logo"></a></div>
<ul class="nav-links">
  <li><a href="../public/index.php">Home</a></li>
  <li><a download href="../docs/Minha Lancheira Amiga - Ebook.pdf">EBook</a></li>
  <li><a href="../pages/contato.php">Contato</a></li>
  <li><a href="../posts/forum.php">Fórum</a></li>
</ul>
<div class="botoes">

  <!-- login/cadastro ou usuário logado -->
  <?php if ($usuarioLogado): ?>
    <table>
      <tr>
        <th style="vertical-align: middle; padding: 5px; color: #ff9800; font-weight: bold; font-size: 1.2rem; text-shadow: 1px 1px 2px rgba(0,0,0,0.2);" title="Sua ofensiva diária">
          🔥 <?= isset($ofensiva) ? $ofensiva : 0 ?>
        </th>
        <th style="vertical-align: middle; padding: 5px;">
          <img src="<?= htmlspecialchars($foto_perfil) ?>" style="width: 40px; height: 40px; border-radius: 50%;
                  border: 2px solid #653485; object-fit: cover;" alt="Foto de perfil">
        </th>
        <th style="vertical-align: middle; padding: 5px;">
          <a href="../perfil/perfil.php" class="btn perfil">Perfil</a>
        </th>
      </tr>
    </table>
  <?php else: ?>
    <a href="../auth/login.html" class="btn entrar">Entrar</a>
    <a href="../auth/cadastro.html" class="btn cadastrar">Cadastrar</a>
  <?php endif; ?>
</div>

<!-- Lógica Global do Botão Concluir Etapa -->
<script src="../assets/js/concluir_etapa.js" defer></script>