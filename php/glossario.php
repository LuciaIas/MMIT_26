<?php
session_start();

$utente_loggato = isset($_SESSION['username']);

/* ===== CONNESSIONE DB ===== */
$conn_str = "host=localhost port=5432 dbname=gruppo26 user=www password=www";
$dbconn = pg_connect($conn_str);

if (!$dbconn) {
    die("Errore di connessione al database.");
}

/* ===== RICERCA ===== */
$search_value = "";
$query_sql = "SELECT * FROM glossario";

if (isset($_GET['q']) && trim($_GET['q']) !== "") {
    $search_value = trim($_GET['q']);
    $query_sql .= " WHERE termine ILIKE $1";
}

$query_sql .= " ORDER BY termine ASC";

$result = $search_value
    ? pg_query_params($dbconn, $query_sql, ['%' . $search_value . '%'])
    : pg_query($dbconn, $query_sql);
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="author" content="gruppoMMIT26"/>
<meta name="description" content="Pagina glossario"/>
<title>Glossario - Tecnologie Web</title>
<link rel="stylesheet" href="../css/glossario.css?v=6">
<link rel="icon" href="../immagini/zoom.ico" type="image/X.icon" />
</head>


<body id="inizio">

<header class="main-header">
    <h1>Glossario</h1>
    <p>A tutti può capitare di dimenticare qualcosa!</p>
</header>

<!-- NAV BAR PRINCIPALE -->
<nav>
    <a href="homepage.php">Home</a>
    <a href="quiz.php">Quiz</a>
    <a href="profilo.php">Profilo</a>
</nav>

<main class="contenitore">

<?php if (!$utente_loggato): ?>
    <section class="content-box">
        <h2>Accesso richiesto</h2>
        <br><p>Per consultare il glossario devi essere registrato ed effettuare l’accesso.</p><br>
        <p>
            <a id="btn" href="accesso.php">Login</a> oppure
            <a id="btn" href="accesso.php?form=register" >Registrati</a>
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

<?php while ($row = pg_fetch_assoc($result)): ?>
    <article class="term-card">
        <header>
            <h3><?= htmlspecialchars($row['termine']) ?></h3>
        
           <!--  <span class="category-badge">
                <?= htmlspecialchars($row['categoria']) ?>
            </span>
-->
        </header>

        <div class="card-content">
            <p><?= htmlspecialchars($row['definizione']) ?></p>
        </div>
    </article>
<?php endwhile; ?>

</section>

<a id="tornaSu" href="#inizio">Torna su</a>

<?php endif; ?>
</main>

 

<!-- FOOTER -->
<footer class="main-footer">
     <p>Corso Tecnologie Web – A.A. 2025-2026 | Portale didattico per studenti di Ingegneria Informatica</p>
    <p>Università degli Studi di Salerno - Via Giovanni Paolo II, 132 - 84084 Fisciano (SA)</p>
</footer>


</body>
</html>