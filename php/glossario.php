<?php
session_start();

// 1. Connessione al Database (Requisito: utente 'www')
$conn_str = "host=localhost port=5432 dbname=gruppoXX user=www password=www";
$dbconn = pg_connect($conn_str);

if (!$dbconn) {
    die("Errore di connessione al database.");
}

// 2. Controllo Sessione (Slide 15.1)
// Se la variabile 'username' esiste in sessione, l'utente è loggato.
$is_logged = isset($_SESSION['username']);

// 3. Gestione Ricerca e Sticky Form (Slide 14.1)
$search_value = "";
$query_sql = "SELECT * FROM glossario";

// Se l'utente ha inviato il form di ricerca (metodo GET)
if (isset($_GET['q'])) {
    $search_value = trim($_GET['q']); // trim toglie spazi vuoti
    // Usiamo il parametro $1 per sicurezza contro SQL Injection
    $query_sql .= " WHERE termine ILIKE $1"; 
}

$query_sql .= " ORDER BY termine ASC";

// Esecuzione Query
if ($search_value) {
    $result = pg_query_params($dbconn, $query_sql, array('%'.$search_value.'%'));
} else {
    $result = pg_query($dbconn, $query_sql);
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Glossario - Tecnologie Web</title>
    
    <link rel="stylesheet" href="glossario.css">
    
    <script src="glossario.js" defer></script>
</head>
<body>

    <header class="main-header">
        <h1>Glossario Tecnologie Web</h1>
        <p>Termini e definizioni fondamentali per il corso</p>
    </header>

    <nav class="navbar">
        <a href="homepage.php">Home</a>
        
        <?php if($is_logged): ?>
            <a href="profilo.php">Profilo (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
            <a href="logout.php">Logout</a>
        <?php else: ?>
            <a href="accesso.php">Accedi / Registrati</a>
        <?php endif; ?>
        
        <a href="glossario.php" class="active">Glossario</a>
    </nav>

    <main class="yellow-container">

        <section class="content-box search-box">
            <h2>Cerca un termine</h2>
            <form action="glossario.php" method="GET">
                <input type="text" name="q" id="js-search" 
                       placeholder="Es. HTML, Sessioni..." 
                       value="<?php echo htmlspecialchars($search_value); ?>">
                <button type="submit">Cerca (PHP)</button>
            </form>
            <p class="small-text">Puoi anche filtrare in tempo reale scrivendo qui sotto.</p>
        </section>

        <section class="terms-grid">
            <?php 
            // Ciclo sui risultati (Slide 13.2 - Array e Cicli)
            while ($row = pg_fetch_assoc($result)): 
                
                // LOGICA PERMESSI
                // Il contenuto è visibile se è 'free' OPPURE se l'utente è loggato
                $is_visible = ($row['livello_accesso'] === 'free' || $is_logged);
            ?>

                <article class="term-card <?php echo $is_visible ? 'unlocked' : 'locked'; ?>" 
                         data-term="<?php echo strtolower($row['termine']); ?>">
                    
                    <header>
                        <h3><?php echo htmlspecialchars($row['termine']); ?></h3>
                        <span class="category-badge"><?php echo htmlspecialchars($row['categoria']); ?></span>
            </header>

                    <div class="card-content">
                        <?php if ($is_visible): ?>
                            <p><?php echo htmlspecialchars($row['definizione']); ?></p>
                        <?php else: ?>
                            <p class="blur-text">Contenuto riservato agli studenti registrati.</p>
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
        <p>&copy; 2026 Progetto Tecnologie Web - Gruppo XX</p>
    </footer>

</body>
</html>