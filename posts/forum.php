<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
  $_SESSION['ultima_pagina'] = $_SERVER['REQUEST_URI'];
  header("Location: ../auth/login.html");
  exit();
}

include('../auth/conexao.php');

$usuario_id = $_SESSION['usuario_id'];
$tipo_usuario = strtolower($_SESSION['tipo'] ?? '');
$usuarioLogado = isset($_SESSION['usuario_id']);

// Buscar posts
$sql = "SELECT p.postagem_id, p.usuario_id, p.mensagem, p.hora_mandada, u.nome, u.foto_perfil, u.tipo
        FROM postagens p
        JOIN usuarios u ON p.usuario_id = u.usuario_id
        WHERE p.excluida = 0
        ORDER BY p.hora_mandada DESC";
$resultPosts = $conn->query($sql);

$foto_perfil = "../uploads/default.png";

if ($usuarioLogado) {
  $sql = "SELECT foto_perfil FROM usuarios WHERE usuario_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $usuario_id);
  $stmt->execute();
  $resultFoto = $stmt->get_result();
  if ($row = $resultFoto->fetch_assoc()) {
    $foto_perfil = $row["foto_perfil"] ?? "../uploads/default.png";
  }
  $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Fórum | Rim Por Rim</title>
  <link rel="stylesheet" href="../assets/css/reset.css">
  <link rel="stylesheet" href="../assets/css/forum.css">
  <link href="https://fonts.googleapis.com/css2?family=Berkshire+Swash&display=swap" rel="stylesheet">
</head>
<header>
  <nav class="navbar">
    <!-- header -->
    <?php include("../includes/header.php"); ?>
  </nav>
</header>

<body>
  <br>
  <center>
    <div class="search-bar">
      <input type="text" id="pesquisa" placeholder="Pesquisar...">
    </div>
  </center>
  <br>

  <table>
    <tr>
      <th width="80.7%"></th>
      <th><button onclick="location.href='novo_post.php'" class="btn">Perguntar</button></th>
    </tr>
  </table>

  <main>
    <div id="posts-container">
      <?php while ($row = $resultPosts->fetch_assoc()):
        $foto = $row['foto_perfil'] ?? '../uploads/default.png';
        $pode_excluir = ($row['usuario_id'] == $usuario_id || $tipo_usuario === 'profissional');
        ?>
        <div class="post" data-id="<?= $row['postagem_id'] ?>">
          <div class="post-header">
            <img src="<?= htmlspecialchars($foto) ?>" alt="Foto perfil">
            <span class="nome"><?= htmlspecialchars($row['nome']) ?></span>
            <?php if ($pode_excluir): ?>
              <span class="botao-excluir" onclick="excluirPost(<?= $row['postagem_id'] ?>)">Excluir</span>
            <?php endif; ?>
          </div>
          <div class="mensagem"><?= nl2br(htmlspecialchars($row['mensagem'])) ?></div>

          <div class="respostas">
            <?php
            $pid = $row['postagem_id'];
            $sql_resposta = "SELECT r.mensagem, u.nome, u.foto_perfil, u.tipo 
                         FROM respostas_postagem r
                         JOIN usuarios u ON r.usuario_id = u.usuario_id
                         WHERE r.postagem_id = ? ORDER BY r.hora_mandada ASC";
            $stmt_res = $conn->prepare($sql_resposta);
            $stmt_res->bind_param("i", $pid);
            $stmt_res->execute();
            $respostas = $stmt_res->get_result();
            while ($res = $respostas->fetch_assoc()):
              $foto_r = $res['foto_perfil'] ?? '../uploads/default.png';
              ?>
              <div class="resposta">
                <div class="post-header">
                  <img src="<?= htmlspecialchars($foto_r) ?>" alt="Foto perfil">
                  <span class="nome"><?= htmlspecialchars($res['nome']) ?></span>
                </div>
                <div class="mensagem"><?= nl2br(htmlspecialchars($res['mensagem'])) ?></div>
              </div>
            <?php endwhile;
            $stmt_res->close(); ?>
          </div>

          <?php if ($tipo_usuario === 'profissional'): ?>
            <div class="caixa-resposta">
              <form action="responder_post.php" method="POST">
                <input type="hidden" name="postagem_id" value="<?= $row['postagem_id'] ?>">
                <input type="text" name="mensagem" placeholder="Responder..." required>
                <button type="submit" class="btn-responder">Responder</button>
              </form>
            </div>
          <?php endif; ?>
        </div>
      <?php endwhile; ?>
    </div>
  </main>

  <script>
    function excluirPost(id) {
      if (!confirm("Deseja realmente excluir este post?")) return;

      fetch('excluir_postagem.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'postagem_id=' + encodeURIComponent(id)
      })
        .then(res => res.json())
        .then(data => {
          if (data.sucesso) {
            const post = document.querySelector('.post[data-id="' + id + '"]');
            if (post) post.remove();
          } else {
            alert(data.erro || 'Erro ao excluir o post.');
          }
        })
        .catch(err => {
          alert('Erro na requisição.');
          console.error(err);
        });
    }

    document.querySelectorAll('.post').forEach(post => {
      post.addEventListener('contextmenu', e => {
        e.preventDefault();
        document.querySelectorAll('.post').forEach(p => {
          if (p !== post) p.classList.remove('show-delete');
        });
        post.classList.toggle('show-delete');
      });
    });

    document.getElementById('pesquisa').addEventListener('input', function () {
      const filtro = this.value.toLowerCase();
      document.querySelectorAll('#posts-container .post').forEach(post => {
        const texto = post.querySelector('.mensagem').innerText.toLowerCase();
        const nome = post.querySelector('.nome').innerText.toLowerCase();
        post.style.display = (texto.includes(filtro) || nome.includes(filtro)) ? '' : 'none';
      });
    });
  </script>
</body>

</html>