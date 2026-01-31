<?php
session_start();
include __DIR__ . '/db.php';

$utente_loggato = isset($_SESSION['username']);

$search_value = "";
$query_sql = "SELECT * FROM glossario";

if (isset($_GET['q']) && trim($_GET['q']) !== "") {
    $search_value = trim($_GET['q']);
    $query_sql .= " WHERE termine ILIKE $1";
}

$query_sql .= " ORDER BY termine ASC";

$result = $search_value
    ? pg_query_params($conn, $query_sql, ['%' . $search_value . '%'])
    : pg_query($conn, $query_sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="author" content="gruppoMMIT26"/>
<meta name="description" content="Pagina glossario"/>
<title>Glossario - Tecnologie Web</title>
<link rel="stylesheet" href="../css/glossario.css?v=9">
<link rel="icon" href="../immagini/zoom.ico" type="image/X.icon" />
</head>

<body id="inizio">
    
<header>
     <h1>Glossario</h1>
     <?php if ($utente_loggato): ?>
      <p>A tutti può capitare di dimenticare qualcosa!</p>
      <?php endif; ?>
</header>

<nav class="navbar">
    <div class="navbar-links">
    <a href="homepage.php">Home</a>
    <a href="quiz.php">Quiz</a>
    <a href="profilo.php">Profilo</a>
</div>
</nav>

<main class="contenitore">

<?php if (!$utente_loggato): ?>
    <section class="content-box">
        <h2>Accesso richiesto</h2>
        <br><p>Per consultare il glossario devi essere registrato ed effettuare l’accesso.</p><br>
        <p>
            <a class="btn" href="accesso.php">Login</a> oppure
            <a class="btn" href="accesso.php?form=register" >Registrati</a>
        </p>
    </section>
    
<?php else: ?>
<section class="content-box">
    <form method="get">
        <input type="text" id="js-search" name="q"
       value="<?= htmlspecialchars($search_value) ?>"
       placeholder="Cerca un termine...">
        <button type="submit">Cerca</button>
        <button type="button" onclick="window.location='glossario.php';">Reset</button>
    </form>
</section>

<section class="terms-grid">

<?php 
$found = false;
while ($row = pg_fetch_assoc($result)): 
    $found = true;
?>
<article class="term-card" data-term="<?= strtolower(htmlspecialchars($row['termine'])) ?>">
    <header class="card-header">
        <div class="card-top">
        <h3 class="term-title"> <?= htmlspecialchars($row['termine']) ?> </h3> 
        <span class="categoria"> <?= htmlspecialchars($row['categoria']) ?> </span>
        </div>
     </header>
        <div class="card-content">
            <p><?= htmlspecialchars($row['definizione']) ?></p>
        </div>
</article>
<?php endwhile; ?>

<?php if (!$found): ?>
    <p style="text-align:center; font-weight:bold; margin-top:20px;">Nessun risultato trovato.</p>
<?php endif; ?>

</section>

<a id="tornaSu" href="#inizio">Torna su</a>

</main>

<footer class="main-footer">
    <p> © Corso Tecnologie Web – A.A. 2025-2026 | Portale didattico per studenti di Ingegneria Informatica</p>
    <p>Università degli Studi di Salerno - Via Giovanni Paolo II, 132 - 84084 Fisciano (SA)</p>
</footer>
<?php endif; ?>

<script src="../js/glossario.js" type="text/javascript" ></script>

<?php
pg_close($conn);
?>

</body>
</html>