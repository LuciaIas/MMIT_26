<?php
session_start();
include __DIR__ . '/db.php';

$utente_loggato = isset($_SESSION['username']);

// Recupera tutti i quiz dal database
$quiz_result = pg_query($conn, "SELECT * FROM quiz ORDER BY id");
$quiz_list = [];
while($row = pg_fetch_assoc($quiz_result)){
    $quiz_list[$row['id']] = $row;
}

// Gestione invio punteggio
if($utente_loggato && $_SERVER['REQUEST_METHOD'] === 'POST'){
    $id_quiz_post = intval($_POST['id_quiz']);
    $punteggio = intval($_POST['punteggio']);

    // Controlla se esiste già un punteggio
    $existing = pg_query_params($conn,
        "SELECT id FROM risultati_quiz WHERE username=$1 AND id_quiz=$2",
        [$_SESSION['username'], $id_quiz_post]
    );

    if(pg_num_rows($existing) > 0){
        $row = pg_fetch_assoc($existing);
        pg_query_params($conn,
            "UPDATE risultati_quiz SET punteggio=$1 WHERE id=$2",
            [$punteggio, $row['id']]
        );
    } else {
        pg_query_params($conn,
            "INSERT INTO risultati_quiz (username,id_quiz,punteggio) VALUES ($1,$2,$3)",
            [$_SESSION['username'], $id_quiz_post, $punteggio]
        );
    }

    // Mostra punteggio salvato
    echo json_encode(['success'=>true,'punteggio'=>$punteggio]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Quiz Tecnologie Web</title>
<link rel="stylesheet" href="../css/quiz.css">
<script>
let userScore = {}; // punteggio per ogni quiz
let answered = {};  // conteggio risposte per quiz

// Funzione per verificare risposta
function checkAnswer(quizId, li, button, correct) {
    if(li.classList.contains('answered')) return;

    if(correct){
        button.style.backgroundColor = "#4CAF50";
        userScore[quizId] = (userScore[quizId] || 0) + 1;
    } else {
        button.style.backgroundColor = "#f44336";
    }

    li.querySelectorAll("button").forEach(b => b.disabled = true);
    li.classList.add('answered');

    answered[quizId] = (answered[quizId] || 0) + 1;
}

// Resetta il quiz
function resetQuiz(quizId){
    userScore[quizId] = 0;
    answered[quizId] = 0;

    document.querySelectorAll(`#quiz-${quizId} ol li`).forEach(li => {
        li.classList.remove('answered');
        li.querySelectorAll("button").forEach(b => {
            b.disabled = false;
            b.style.backgroundColor = "";
        });
    });

    document.getElementById(`result-${quizId}`).innerText = "";
}

// Salva punteggio nel DB
function saveQuiz(quizId){
    const total = document.querySelectorAll(`#quiz-${quizId} ol li`).length;
    const score = userScore[quizId] || 0;

    fetch('', {
        method: 'POST',
        headers: {'Content-Type':'application/x-www-form-urlencoded'},
        body: 'id_quiz=' + quizId + '&punteggio=' + score
    })
    .then(r => r.json())
    .then(data => {
        if(data.success){
            document.getElementById(`result-${quizId}`).innerText =
                "Hai totalizzato " + score + "/" + total + " punti!";
        }
    });
}
</script>
</head>
<body>
<header>
<h1>Quiz Tecnologie Web</h1>
<?php if($utente_loggato): ?>
<p>Benvenuto, <?= htmlspecialchars($_SESSION['username']) ?>!</p>
<?php else: ?>
<p>Registrati o accedi per salvare i tuoi risultati!</p>
<?php endif; ?>
</header>

<nav class="navquiz">
    <a href="homepage.php">Home</a>
    <a href="glossario.php">Glossario</a>
    <a href="profilo.php">Profilo</a>
</nav>

<div class="quiz-container">

<?php foreach($quiz_list as $id_quiz => $quiz): ?>
    <div class="quiz-section" id="quiz-<?= $id_quiz ?>">
        <h2><?= htmlspecialchars($quiz['titolo']) ?></h2>
        <p><?= htmlspecialchars($quiz['descrizione']) ?></p>

        <?php if($quiz['tipo'] === 'vero_falso'): 
            $domande = pg_query_params($conn, "SELECT * FROM domande_vero_falso WHERE id_quiz=$1 ORDER BY id", [$id_quiz]);
        ?>
            <ol>
            <?php while($row = pg_fetch_assoc($domande)): ?>
                <li>
                    <?= htmlspecialchars($row['testo']) ?>
                    <button type="button" onclick="checkAnswer(<?= $id_quiz ?>, this.closest('li'), this, <?= $row['risposta_corretta']?'true':'false' ?>)">Vero</button>
                    <button type="button" onclick="checkAnswer(<?= $id_quiz ?>, this.closest('li'), this, <?= $row['risposta_corretta']?'false':'true' ?>)">Falso</button>
                </li>
            <?php endwhile; ?>
            </ol>
        <?php else: ?>
            <!-- Qui potrai aggiungere dinamicamente altri tipi di quiz -->
            <p>Questo quiz di tipo "<?= htmlspecialchars($quiz['tipo']) ?>" sarà implementato prossimamente.</p>
        <?php endif; ?>

        <p id="result-<?= $id_quiz ?>"></p>
        <button type="button" onclick="resetQuiz(<?= $id_quiz ?>)">Ricomincia</button>
        <?php if($utente_loggato): ?>
            <button type="button" onclick="saveQuiz(<?= $id_quiz ?>)">Salva risultati</button>
        <?php endif; ?>
    </div>
<?php endforeach; ?>

</div>
    <!-- COMPLETA LA FRASE -->
    <section class="quiz-section">
        <h2>Completa La Frase
            <img src="../immagini/note.png" alt="Logo Portale" style="width:16px; height:16px; vertical-align:middle;">
        </h2>
        <form>
            <p>1. Il linguaggio <input type="text"> serve a creare la struttura delle pagine web. </p>
            <p>2. Il protocollo <input type="text"> permette la trasmissione di pagine web. </p>
            <p>3. <input type="text"> è un linguaggio lato server molto diffuso. </p>
            <p>4. Il Web 2.0 è caratterizzato da contenuti <input type="text"> creati dagli utenti. </p>
            <p>5. L’insieme di documenti interconnessi tramite link costituisce il <input type="text">. </p>
        </form>
    </section>

        <!-- OUTPUT CORRETTO -->
    <section class="quiz-section">
        <h2>Seleziona l'Output Corretto
            <img src="../immagini/note.png" alt="Logo Portale" style="width:16px; height:16px; vertical-align:middle;">
        </h2>
        <img src="../immagini/quiz_id3.png" alt="Logo Portale">
        <button type="button" onclick="checkAnswer(this, <?= $row['risposta_corretta'] ? 'true' : 'false' ?>)">
            Perchè impostare la codifica HTML Ã·· importante</button>
        <button type="button" onclick="checkAnswer(this, <?= $row['risposta_corretta'] ? 'false' : 'true' ?>)">
            Perchè impostare la codifica HTML è importante</button>
    </section>

    <!-- DRAG & DROP -->
    <section class="quiz-section">
        <h2>Drag & Drop</h2>
        <p>Trascina la definizione corretta accanto al termine giusto:</p>
        <div class="drag-drop-container">
            <div class="drag-item" draggable="true" id="html-drag">HTML</div>
            <div class="drag-item" draggable="true" id="css-drag">CSS</div>
            <div class="drag-item" draggable="true" id="js-drag">JavaScript</div>
            <div class="drag-item" draggable="true" id="php-drag">PHP</div>
        </div>
        <div class="drop-zone-container">
            <div class="drop-zone" data-answer="HTML">Struttura delle pagine</div>
            <div class="drop-zone" data-answer="CSS">Stile delle pagine</div>
            <div class="drop-zone" data-answer="JavaScript">Interattività lato client</div>
            <div class="drop-zone" data-answer="PHP">Esecuzione lato server</div>
        </div>
    </section>

</div>

<script src="../js/dragdrop.js"></script>
</body>
</html>


