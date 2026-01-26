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

// Carica le domande dai DB usando gli ID dei tuoi insert
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
<title>Quiz Tecnologie Web</title>
<link rel="stylesheet" href="../css/quiz.css">
<script>
function resetQuiz() {
    document.getElementById('quizForm').reset();
}
</script>
</head>
<body>

<header>
    <h1>Quiz di Tecnologie Web</h1>
    <a href="homepage.php" class="home-btn">🏠 Home</a>
    <?php if($utente_loggato): ?>
        <p>Benvenuto, <?= htmlspecialchars($username) ?>! Metti alla prova le tue competenze.</p>
    <?php else: ?>
        <p>Registrati o accedi per salvare i tuoi risultati!</p>
    <?php endif; ?>
</header>

<div class="quiz-container">
<form id="quizForm" method="post">

    <!-- Vero/Falso -->
    <?php if(count($domande_vf) > 0): ?>
    <section class="quiz-section">
        <h2>Vero o Falso</h2>
        <ol>
            <?php foreach($domande_vf as $row): ?>
            <li>
                <?= htmlspecialchars($row['testo']) ?>
                <label>
                    <input type="radio" name="risposte[vf][<?= $row['id'] ?>]" value="1">
                    <img src="../immagini/check.png" alt="Vero" style="width:20px; vertical-align:middle;">
                </label>
                <label>
                    <input type="radio" name="risposte[vf][<?= $row['id'] ?>]" value="0">
                    <img src="../immagini/cancel.png" alt="Falso" style="width:20px; vertical-align:middle;">
                </label>
            </li>
            <?php endforeach; ?>
        </ol>
    </section>
    <?php endif; ?>

    <!-- Completa la frase -->
    <?php if(count($domande_cf) > 0): ?>
    <section class="quiz-section">
        <h2>Completa la frase</h2>
        <?php foreach($domande_cf as $row): ?>
            <p><?= htmlspecialchars($row['frase']) ?> <input type="text" name="risposte[cf][<?= $row['id'] ?>]"></p>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <!-- Output immagine -->
    <?php if(count($domande_output_img) > 0): ?>
    <section class="quiz-section">
        <h2>Qual è l'output del codice?</h2>
        <?php foreach($domande_output_img as $row): ?>
            <img src="../immagini/<?= htmlspecialchars($row['immagine']) ?>" alt="Quiz codice" style="max-width:400px; display:block; margin-bottom:10px;">
            <input type="text" name="risposte[output_img][<?= $row['id'] ?>]" placeholder="Scrivi qui la tua risposta">
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

<!-- Drag & Drop -->
<?php if(count($domande_dd) > 0): ?>
<section class="quiz-section">
    <h2>Drag & Drop</h2>
    <p>Trascina i termini nella definizione corretta:</p>

    <div class="drag-drop-container" style="display:flex; gap:40px; flex-wrap:wrap;">

        <!-- Termini trascinabili -->
        <div class="drag-items" style="flex:1; min-width:150px;">
            <h3>Termini</h3>
            <?php foreach($domande_dd as $row): ?>
                <div 
                    class="drag-item" 
                    id="term<?= $row['id'] ?>" 
                    draggable="true"
                    style="padding:5px 10px; background:#0055aa; color:white; margin:5px; border-radius:5px; cursor:grab;">
                    <?= htmlspecialchars($row['termine']) ?>
                </div>
            <?php endforeach; ?>
        </div>

<!-- Definizioni / drop -->
<div class="drop-zones" style="flex:2; min-width:250px;">
    <h3>Definizioni</h3>
    <?php foreach($domande_dd as $row): ?>
        <div class="dd-item" style="margin-bottom:20px;">
            <!-- Testo della definizione -->
            <span class="def-text" style="display:block; margin-bottom:8px; font-weight:bold;">
                <?= htmlspecialchars($row['definizione_corretta']) ?>
            </span>
            <!-- Drop zone per trascinare il termine -->
            <div class="drop-zone" 
                 data-answer="<?= htmlspecialchars($row['termine']) ?>" 
                 style="min-height:50px; border:2px dashed #ccc; border-radius:6px; text-align:center; line-height:50px; background:#f4f4f4;">
                <!-- Qui apparirà il termine trascinato -->
            </div>
            <!-- Input nascosto per invio form -->
            <input type="hidden" name="risposte[dd][<?= $row['id'] ?>]">
        </div>
    <?php endforeach; ?>
</div>


    </div>
</section>
<?php endif; ?>


    <button type="submit">Invia Risposte</button>
    <button type="button" onclick="resetQuiz()">Reset</button>
</form>

<?php if(isset($messaggio_punteggio)): ?>
    <p><strong><?= $messaggio_punteggio ?></strong></p>
<?php endif; ?>
</div>
<script src="../js/quiz.js"></script>

</body>
</html>
