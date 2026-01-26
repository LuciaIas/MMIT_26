<?php
session_start();
include __DIR__ . '/db.php';

$utente_loggato = isset($_SESSION['username']);
$username = $utente_loggato ? $_SESSION['username'] : null;

// Funzione sicura per recuperare domande
function get_domande($conn, $tabella, $id_quiz) {
    $query = "SELECT * FROM $tabella WHERE id_quiz=$1 ORDER BY id";
    $res = pg_query_params($conn, $query, [$id_quiz]);
    if(!$res) {
        die("Errore nella query su $tabella: " . pg_last_error($conn));
    }
    $domande = [];
    while($row = pg_fetch_assoc($res)) {
        $domande[] = $row;
    }
    return $domande;
}

// Carica le domande dai DB
$domande_vf = get_domande($conn, 'domande_vero_falso', 1);
$domande_cf = get_domande($conn, 'domande_completa_frase', 2);
$domande_output_img = get_domande($conn, 'domande_output_immagine', 3);
$domande_dd = get_domande($conn, 'domande_drag_drop', 4);

// Gestione invio risposte
if($utente_loggato && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $risposte = $_POST['risposte'] ?? [];
    $risposte_json = json_encode($risposte);
    $punteggio = 0;

    // Vero/Falso
    foreach($risposte['vf'] ?? [] as $id => $risposta) {
        $query = pg_query_params($conn, "SELECT risposta_corretta FROM domande_vero_falso WHERE id=$1", [$id]);
        $row = pg_fetch_assoc($query);
        if($row && ((bool)$risposta === (bool)$row['risposta_corretta'])) $punteggio++;
    }

    // Completa frase
    foreach($risposte['cf'] ?? [] as $id => $risposta) {
        $query = pg_query_params($conn, "SELECT risposta_corretta FROM domande_completa_frase WHERE id=$1", [$id]);
        $row = pg_fetch_assoc($query);
        if($row && strtolower(trim($risposta)) === strtolower(trim($row['risposta_corretta']))) $punteggio++;
    }

    // Output immagine
    foreach($risposte['output_img'] ?? [] as $id => $risposta) {
        $query = pg_query_params($conn, "SELECT risposta_corretta FROM domande_output_immagine WHERE id=$1", [$id]);
        $row = pg_fetch_assoc($query);
        if($row && trim($risposta) === trim($row['risposta_corretta'])) $punteggio++;
    }

    // Drag & Drop
    foreach($risposte['dd'] ?? [] as $id => $def) {
        $query = pg_query_params($conn, "SELECT definizione_corretta FROM domande_drag_drop WHERE id=$1", [$id]);
        $row = pg_fetch_assoc($query);
        if($row && trim($def) === trim($row['definizione_corretta'])) $punteggio++;
    }

    // Inserisci o aggiorna il punteggio
    $existing = pg_query_params($conn, "SELECT id FROM risultati_quiz WHERE username=$1 AND id_quiz=$2", [$username, 1]);
    if(pg_num_rows($existing) > 0){
        $row = pg_fetch_assoc($existing);
        pg_query_params($conn, "UPDATE risultati_quiz SET punteggio=$1, risposte_utente=$2 WHERE id=$3",
            [$punteggio, $risposte_json, $row['id']]);
    } else {
        pg_query_params($conn, "INSERT INTO risultati_quiz (username, id_quiz, punteggio, risposte_utente) VALUES ($1,$2,$3,$4)",
            [$username, 1, $punteggio, $risposte_json]);
    }

    $messaggio_punteggio = "Hai totalizzato $punteggio punti!";
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="author" content="gruppoMMIT26"/>
<meta name="description" content="Pagina di quiz"/>
<title>Pagina dei quiz</title>
<link rel="stylesheet" href="../css/quiz.css?v=5">
<link rel="shrtcut icon" href="../immagini/note.png" type="image/x-icon">
<script>
function resetQuiz() {
    document.getElementById('quizForm').reset();
}
</script>
</head>
<body>

<header>
    <h1>Quiz di Tecnologie Web</h1>
    <?php if($utente_loggato): ?>
        <p>Ciao, <?= htmlspecialchars($username) ?>! Che aspetti? </p>
        <p>Metti alla prova le tue competenze!</p>
    <?php endif; ?>
</header>

<nav>
    <a href="homepage.php" class="home-btn">Home</a>
    <a href="glossario.php" class="home-btn">Glossario</a>
    <a href="profilo.php" class="home-btn">Profilo</a>
    </nav>

<div class="quiz-container">
    <p> Nota: tutte le risposte vanno inserite in MAIUSCOLO.</p>
<form id="quizForm" method="post">

    <!-- Vero/Falso -->
    <?php if(count($domande_vf) > 0): ?>
<section class="quiz-section">
    <h2>Vero o Falso</h2>
    <ol>
        <?php foreach($domande_vf as $row): 
            $id = $row['id'];
            $user_risposta = $risposte['vf'][$id] ?? null; // risposta dell'utente
            $corretta = $row['risposta_corretta'];         // dal DB

            // cast corretti
            $corretta_bool = ($corretta === true || $corretta === 't' || $corretta === '1' || $corretta === 1);
            $user_bool = ($user_risposta == 1);

            $inviato = isset($messaggio_punteggio);

            // determina il messaggio solo una volta
            $messaggio_risposta = null;
            if($inviato && $user_risposta !== null){
                $messaggio_risposta = ($user_bool === $corretta_bool) ? '(Corretta)' : '(Errata)';
            }
        ?>
        <li>
            <?= htmlspecialchars($row['testo']) ?>
            <label>
                <input type="radio" name="risposte[vf][<?= $id ?>]" value="1"
                    <?= ($user_risposta !== null && $user_risposta == 1) ? 'checked' : '' ?>
                    <?= $inviato ? 'disabled' : '' ?>>
                <img src="../immagini/check.png" alt="Vero" style="width:20px; vertical-align:middle;">
            </label>
            <label>
                <input type="radio" name="risposte[vf][<?= $id ?>]" value="0"
                    <?= ($user_risposta !== null && $user_risposta == 0) ? 'checked' : '' ?>
                    <?= $inviato ? 'disabled' : '' ?>>
                <img src="../immagini/cancel.png" alt="Falso" style="width:20px; vertical-align:middle;">
            </label>

            <!-- Messaggio unico alla fine della domanda -->
            <?php if($messaggio_risposta): ?>
                <strong><?= $messaggio_risposta ?></strong>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ol>
</section>
<?php endif; ?>

<!-- Dopo i bottoni del form, puoi mostrare un riepilogo totale se vuoi -->
<?php if(isset($messaggio_punteggio)): ?>
    <p><strong><?= $messaggio_punteggio ?></strong></p>
<?php endif; ?>








    <!-- Completa la frase -->
    <?php if(count($domande_cf) > 0): ?>
<section class="quiz-section">
    <h2>Completa la frase</h2>
    <ol>
        <?php foreach($domande_cf as $row): 
            $id = $row['id'];
            $user_risposta = $risposte['cf'][$id] ?? '';           // risposta dell'utente
            $corretta = $row['risposta_corretta'];                 // risposta corretta dal DB
            $inviato = isset($messaggio_punteggio);                // se il form è stato inviato
        ?>
        <li>
            <?= htmlspecialchars($row['frase']) ?>
            <input type="text" name="risposte[cf][<?= $id ?>]"
                value="<?= htmlspecialchars($user_risposta) ?>"
                <?= $inviato ? 'disabled' : '' ?>>

            <?php if($inviato): ?>
                <?php if(strtolower(trim($user_risposta)) === strtolower(trim($corretta))): ?>
                    <strong>(Corretta)</strong>
                <?php else: ?>
                    <strong>(Errata, risposta corretta: <?= htmlspecialchars($corretta) ?>)</strong>
                <?php endif; ?>
            <?php endif; ?>
        </li>
        <?php endforeach; ?>
    </ol>
</section>
<?php endif; ?>


    <!-- Output immagine -->
   <?php if(count($domande_output_img) > 0): ?>
<section class="quiz-section">
    <h2>I due codici hanno lo stesso output?</h2>
    <?php foreach($domande_output_img as $row): 
        $id = $row['id'];
        $user_risposta = $risposte['output_img'][$id] ?? '';    // risposta dell'utente
        $corretta = $row['risposta_corretta'];                  // risposta corretta dal DB
        $inviato = isset($messaggio_punteggio);                 // se il form è stato inviato
    ?>
    <img class="output-img-large" src="../immagini/<?= htmlspecialchars($row['immagine']) ?>" alt="Quiz codice" style="display:block; margin-bottom:10px;">
    <img class="output-img-large" src="../immagini/quiz32.png" alt="Pixel ID 32" style="display:block; margin-bottom:10px;">
    <input type="text" name="risposte[output_img][<?= $id ?>]"
        placeholder="Scrivi qui la tua risposta"
        value="<?= htmlspecialchars($user_risposta) ?>"
        <?= $inviato ? 'disabled' : '' ?>>

    <?php if($inviato): ?>
        <?php if(trim($user_risposta) === trim($corretta)): ?>
            <strong>(Corretta)</strong>
        <?php else: ?>
            <strong>(Errata, risposta corretta: <?= htmlspecialchars($corretta) ?>)</strong>
        <?php endif; ?>
    <?php endif; ?>
    <br><br>
    <?php endforeach; ?>
</section>
<?php endif; ?>

<!-- drag drop -->
   <?php if(count($domande_dd) > 0): ?>
<section class="quiz-section">
    <h2>Drag & Drop</h2>
    <p>Trascina i termini nella definizione corretta:</p>

    <div class="drag-drop-container">

        <!-- Termini trascinabili -->
        <div class="drag-items">
            <h3>Termini</h3>
            <?php foreach($domande_dd as $row): 
                $id = $row['id'];
                $inviato = isset($messaggio_punteggio);
            ?>
                <div class="drag-item" id="term<?= $id ?>" 
                     draggable="<?= $inviato ? 'false' : 'true' ?>">
                    <?= htmlspecialchars($row['termine']) ?>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- Definizioni / drop -->
        <div class="drop-zones">
            <h3>Definizioni</h3>
            <?php foreach($domande_dd as $row): 
                $id = $row['id'];
                $user_risposta = $risposte['dd'][$id] ?? '';  // termine selezionato dall'utente
                $corretta = $row['termine'];                  // termine corretto
                $inviato = isset($messaggio_punteggio);
            ?>
            <div class="dd-item">
                <span class="def-text"><?= htmlspecialchars($row['definizione_corretta']) ?></span>

                <!-- drop-zone disabilitata dopo invio -->
                <div class="drop-zone" data-answer="<?= htmlspecialchars($row['termine']) ?>"
                     <?= $inviato ? 'data-disabled="true"' : '' ?>>
                    <?php if($inviato && $user_risposta !== ''): ?>
                        <!-- mostra il termine già posizionato dall'utente -->
                        <span class="dropped-term"><?= htmlspecialchars($user_risposta) ?></span>
                    <?php endif; ?>
                </div>

                <input type="hidden" name="risposte[dd][<?= $id ?>]" value="<?= htmlspecialchars($user_risposta) ?>">

                <!-- messaggio unico -->
                <?php if($inviato && $user_risposta !== ''): ?>
                    <?php if(trim($user_risposta) === trim($corretta)): ?>
                        <strong>(Corretta)</strong>
                    <?php else: ?>
                        <strong>(Errata, risposta corretta: <?= htmlspecialchars($corretta) ?>)</strong>
                    <?php endif; ?>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>

    </div>
</section>
<?php endif; ?>




    <button type="submit">Invia Risposte</button>
    <button type="button" onclick="window.location='quiz.php';">Reset</button>

</form>

<?php if(isset($messaggio_punteggio)): ?>
    <p><strong><?= $messaggio_punteggio ?></strong></p>
<?php endif; ?>
</div>

<script src="../js/quiz.js"></script>
</body>
</html>
