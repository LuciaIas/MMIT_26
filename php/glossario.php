<?php
session_start();

/* ===== LOGOUT INLINE ===== */
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: homepage.php");
    exit;
}

/* ===== CONNESSIONE DB ===== */
$conn_str = "host=localhost port=5432 dbname=gruppo26 user=www password=www";
$dbconn = pg_connect($conn_str);
if (!$dbconn) {
    die("Errore di connessione al database.");
}

/* ===== SESSIONE ===== */
$is_logged = isset($_SESSION['username']);

/* ===== RICERCA ===== */
$search_value = "";
$query_sql = "SELECT * FROM glossario";

if (isset($_GET['q']) && trim($_GET['q']) !== "") {
    $search_value = trim($_GET['q']);
    $query_sql .= " WHERE termine ILIKE $1";
}

$query_sql .= " ORDER BY termine ASC";

$result = $search_value
    ? pg_query_params($dbconn, $query_sql, ['%'.$search_value.'%'])
    : pg_query($dbconn, $query_sql);
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Glossario - Tecnologie Web</title>
<link rel="stylesheet" href="../css/glossario.css">
</head>

<body>

<header class="main-header">
    <h1>Glossario Tecnologie Web</h1>
    <p>Il cuore didattico del corso</p>
</header>

<nav class="navbar">
    <a href="homepage.php">Home</a>

    <?php if ($is_logged): ?>
        <a href="profilo.php">Profilo (<?= htmlspecialchars($_SESSION['username']) ?>)</a>
        <form method="post" class="nav-form">
            <button type="submit" name="logout" class="logout-btn">Logout</button>
        </form>
    <?php else: ?>
        <a href="accesso.php">Accedi / Registrati</a>
    <?php endif; ?>

    <a href="glossario.php" class="active">Glossario</a>
</nav>

<main class="yellow-container">

<section class="content-box">
    <h2>Cerca un termine</h2>
    <form method="get">
        <input type="text" id="js-search" name="q"
               value="<?= htmlspecialchars($search_value) ?>"
               placeholder="HTML, CSS, PHP...">
        <button type="submit">Cerca</button>
    </form>
</section>

<section class="terms-grid">
<?php while ($row = pg_fetch_assoc($result)):
    $is_visible = ($row['livello_accesso'] === 'free' || $is_logged);
?>
<article class="term-card <?= $is_visible ? 'unlocked' : 'locked' ?>">
    <header>
        <h3><?= htmlspecialchars($row['termine']) ?></h3>
        <span class="category-badge"><?= htmlspecialchars($row['categoria']) ?></span>
    </header>

    <div class="card-content">
        <?php if ($is_visible): ?>
            <p><?= htmlspecialchars($row['definizione']) ?></p>
        <?php else: ?>
            <p class="blur-text">Contenuto riservato</p>
            <div class="lock-overlay">
                <span>🔒 Premium</span>
                <a href="accesso.php">Accedi</a>
            </div>
        <?php endif; ?>
    </div>
</article>
<?php endwhile; ?>
</section>

</main>

<footer class="main-footer">
    <p>&copy; 2026 – Tecnologie Web</p>
</footer>

</body>
</html>
