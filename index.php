<?php
session_start();
require_once 'config.php';

function h($v) { return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
function logged() { return isset($_SESSION['user']); }
function go($msg = '') {
    if ($msg !== '') $_SESSION['flash'] = $msg;
    header('Location: index.php'); exit;
}
$flash = $_SESSION['flash'] ?? '';
unset($_SESSION['flash']);

if (isset($_GET['sair'])) {
    session_destroy();
    header('Location: index.php'); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'register') {
        $nome = trim($_POST['nome'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $senha = $_POST['senha'] ?? '';
        if ($nome === '' || !filter_var($email, FILTER_VALIDATE_EMAIL) || strlen($senha) < 6) {
            go('Preencha os dados corretamente. A senha deve ter pelo menos 6 caracteres.');
        }
        try {
            $st = $pdo->prepare("INSERT INTO usuarios (nome,email,senha,tipo) VALUES (?,?,?,'morador')");
            $st->execute([$nome, $email, password_hash($senha, PASSWORD_DEFAULT)]);
            go('Cadastro realizado! Entre com seu e-mail e senha.');
        } catch (PDOException $e) {
            go('Não foi possível cadastrar. Verifique se o e-mail já existe.');
        }
    }

    if ($action === 'login') {
        $st = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
        $st->execute([trim($_POST['email'] ?? '')]);
        $u = $st->fetch();
        if ($u && password_verify($_POST['senha'] ?? '', $u['senha'])) {
            session_regenerate_id(true);
            $_SESSION['user'] = ['id'=>$u['id'], 'nome'=>$u['nome'], 'tipo'=>$u['tipo']];
            go('Bem-vindo(a), ' . $u['nome'] . '!');
        }
        go('E-mail ou senha incorretos.');
    }

    if (!logged()) go('Faça login para continuar.');

    if ($action === 'save_help') {
        $id = (int)($_POST['id'] ?? 0);
        $titulo = trim($_POST['titulo'] ?? '');
        $descricao = trim($_POST['descricao'] ?? '');
        $categoria = trim($_POST['categoria'] ?? 'Outros');
        $status = $_POST['status'] ?? 'Aberto';
        if ($titulo === '' || $descricao === '') go('Informe título e descrição.');
        if (!in_array($status, ['Aberto','Em andamento','Concluído'], true)) $status = 'Aberto';

        if ($id > 0) {
            $st = $pdo->prepare("UPDATE pedidos_ajuda SET titulo=?, descricao=?, categoria=?, status=? WHERE id=? AND usuario_id=?");
            $st->execute([$titulo,$descricao,$categoria,$status,$id,$_SESSION['user']['id']]);
            go('Solicitação atualizada.');
        } else {
            $st = $pdo->prepare("INSERT INTO pedidos_ajuda (usuario_id,titulo,descricao,categoria,status) VALUES (?,?,?,?,?)");
            $st->execute([$_SESSION['user']['id'],$titulo,$descricao,$categoria,$status]);
            go('Solicitação cadastrada.');
        }
    }

    if ($action === 'delete_help') {
        $st = $pdo->prepare("DELETE FROM pedidos_ajuda WHERE id=? AND usuario_id=?");
        $st->execute([(int)$_POST['id'], $_SESSION['user']['id']]);
        go('Solicitação excluída.');
    }
}

$edit = null;
if (logged() && isset($_GET['editar'])) {
    $st = $pdo->prepare("SELECT * FROM pedidos_ajuda WHERE id=? AND usuario_id=?");
    $st->execute([(int)$_GET['editar'], $_SESSION['user']['id']]);
    $edit = $st->fetch();
}
$helps = [];
$notices = $events = $shops = [];
if (logged()) {
    $st = $pdo->prepare("SELECT p.*, u.nome FROM pedidos_ajuda p JOIN usuarios u ON u.id=p.usuario_id ORDER BY p.criado_em DESC");
    $st->execute(); $helps = $st->fetchAll();
    $notices = $pdo->query("SELECT * FROM avisos ORDER BY criado_em DESC LIMIT 5")->fetchAll();
    $events = $pdo->query("SELECT * FROM eventos ORDER BY data_evento ASC LIMIT 5")->fetchAll();
    $shops = $pdo->query("SELECT * FROM comercios ORDER BY nome ASC LIMIT 5")->fetchAll();
}
?>
<!doctype html>
<html lang="pt-br">
<head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>ConectaBairro | Bairro Uninove</title>
<link rel="stylesheet" href="assets/style.css">
</head>
<body>
<header class="topbar">
  <div class="brand"><span class="brand-icon">CB</span><div><strong>ConectaBairro</strong><small>Bairro Uninove</small></div></div>
  <?php if (logged()): ?><div class="userbox">Olá, <?=h($_SESSION['user']['nome'])?> · <a href="?sair=1">Sair</a></div><?php endif; ?>
</header>

<?php if ($flash): ?><div class="flash"><?=h($flash)?></div><?php endif; ?>

<?php if (!logged()): ?>
<main class="auth-wrap">
  <section class="hero">
    <span class="eyebrow">UMA COMUNIDADE MAIS CONECTADA</span>
    <h1>Informação, apoio e colaboração perto de você.</h1>
    <p>Um espaço digital para moradores compartilharem avisos, organizarem ações e ajudarem uns aos outros.</p>
    <div class="hero-points"><span>✓ Avisos comunitários</span><span>✓ Pedidos de ajuda</span><span>✓ Eventos locais</span></div>
  </section>
  <section class="auth-card">
    <h2>Acessar a plataforma</h2>
    <form method="post" class="form">
      <input type="hidden" name="action" value="login">
      <label>E-mail</label><input type="email" name="email" required placeholder="seu@email.com">
      <label>Senha</label><input type="password" name="senha" required placeholder="Sua senha">
      <button class="btn primary">Entrar</button>
    </form>
    <div class="separator">ou crie sua conta</div>
    <form method="post" class="form">
      <input type="hidden" name="action" value="register">
      <label>Nome</label><input name="nome" required placeholder="Seu nome">
      <label>E-mail</label><input type="email" name="email" required placeholder="seu@email.com">
      <label>Senha (mínimo 6 caracteres)</label><input type="password" name="senha" minlength="6" required>
      <button class="btn secondary">Criar cadastro</button>
    </form>
  </section>
</main>
<?php else: ?>
<main class="container">
  <section class="welcome">
    <div><span class="eyebrow">PAINEL DA COMUNIDADE</span><h1>Olá, <?=h($_SESSION['user']['nome'])?>!</h1><p>Veja o que está acontecendo no Bairro Uninove.</p></div>
    <div class="welcome-mark">⌂</div>
  </section>

  <section class="stats">
    <div class="stat"><span>Pedidos cadastrados</span><strong><?=count($helps)?></strong></div>
    <div class="stat"><span>Avisos recentes</span><strong><?=count($notices)?></strong></div>
    <div class="stat"><span>Eventos publicados</span><strong><?=count($events)?></strong></div>
  </section>

  <section class="section-head"><div><span class="eyebrow">AJUDA MÚTUA</span><h2>Solicitações da comunidade</h2><p>Cadastre e acompanhe pedidos de apoio.</p></div></section>
  <section class="content-grid">
    <div class="panel">
      <h3><?= $edit ? 'Editar solicitação' : 'Nova solicitação' ?></h3>
      <form method="post" class="form">
        <input type="hidden" name="action" value="save_help">
        <input type="hidden" name="id" value="<?=h($edit['id'] ?? 0)?>">
        <label>Título</label><input name="titulo" required maxlength="150" value="<?=h($edit['titulo'] ?? '')?>" placeholder="Ex.: Doação de roupas">
        <label>Descrição</label><textarea name="descricao" required rows="4" placeholder="Explique como a comunidade pode ajudar..."><?=h($edit['descricao'] ?? '')?></textarea>
        <label>Categoria</label>
        <select name="categoria">
          <?php foreach (['Doações','Apoio a idosos','Animais','Manutenção','Voluntariado','Outros'] as $c): ?>
          <option <?=($edit['categoria'] ?? '')===$c?'selected':''?>><?=h($c)?></option>
          <?php endforeach; ?>
        </select>
        <?php if ($edit): ?><label>Status</label><select name="status"><?php foreach (['Aberto','Em andamento','Concluído'] as $s): ?><option <?=($edit['status']===$s?'selected':'')?>><?=h($s)?></option><?php endforeach; ?></select><?php endif; ?>
        <button class="btn primary"><?= $edit ? 'Salvar alterações' : 'Publicar pedido' ?></button>
        <?php if ($edit): ?><a class="cancel" href="index.php">Cancelar edição</a><?php endif; ?>
      </form>
    </div>
    <div class="panel list-panel">
      <h3>Pedidos publicados</h3>
      <?php if (!$helps): ?><div class="empty">Ainda não há pedidos. Cadastre o primeiro ao lado.</div><?php endif; ?>
      <?php foreach ($helps as $p): ?>
      <article class="help-card">
        <div class="card-top"><span class="tag"><?=h($p['categoria'])?></span><span class="status"><?=h($p['status'])?></span></div>
        <h4><?=h($p['titulo'])?></h4><p><?=nl2br(h($p['descricao']))?></p>
        <small>Publicado por <?=h($p['nome'])?></small>
        <?php if ((int)$p['usuario_id']===(int)$_SESSION['user']['id']): ?>
        <div class="actions"><a href="?editar=<?=$p['id']?>">Editar</a>
        <form method="post" onsubmit="return confirm('Deseja realmente excluir esta solicitação?')"><input type="hidden" name="action" value="delete_help"><input type="hidden" name="id" value="<?=$p['id']?>"><button class="link-danger">Excluir</button></form></div>
        <?php endif; ?>
      </article>
      <?php endforeach; ?>
    </div>
  </section>

  <section class="section-head"><div><span class="eyebrow">OUTRAS ÁREAS</span><h2>Informações do Bairro Uninove</h2><p>Conheça as áreas de atuação da plataforma.</p></div></section>
  <section class="tiles">
    <article class="tile"><div class="tile-icon">📢</div><h3>Avisos</h3><p>Comunicados sobre serviços, campanhas e informações importantes.</p><span class="tile-note">Comunicação comunitária</span></article>
    <article class="tile"><div class="tile-icon">📅</div><h3>Eventos</h3><p>Divulgação de reuniões, feiras, mutirões e atividades culturais.</p><span class="tile-note">Integração social</span></article>
    <article class="tile"><div class="tile-icon">🏪</div><h3>Comércio local</h3><p>Espaço para apresentar profissionais e pequenos negócios.</p><span class="tile-note">Valorização local</span></article>
  </section>
  <footer>ConectaBairro · Projeto acadêmico demonstrativo · Bairro Uninove</footer>
</main>
<?php endif; ?>
</body></html>
