<?php
session_start();
include __DIR__ . '/db.php';

$utente_loggato = isset($_SESSION['username']);

// ID del quiz vero/falso
$id_quiz = 1;

// Recupera tutte le domande vero/falso dal database
$domande = pg_query_params($conn, "SELECT * FROM domande_vero_falso WHERE id_quiz=$1 ORDER BY id", [$id_quiz]);

// Gestione invio punteggio
if($utente_loggato && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $punteggio = intval($_POST['punteggio']);
    $id_quiz_post = intval($_POST['id_quiz']);

    // Inserisci o aggiorna il punteggio dell'utente
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
        // Inserisci nuovo record
        pg_query_params($conn, 
            "INSERT INTO risultati_quiz (username,id_quiz,punteggio) VALUES ($1,$2,$3)",
            [$_SESSION['username'], $id_quiz_post, $punteggio]
        );
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Quiz Tecnologie Web</title>
    <link rel="stylesheet" href="../css/quiz.css">
    <script>
        let score = 0;
        let answered = 0;

        function checkAnswer(button, correct) {
            const li = button.closest("li");
            if(li.classList.contains('answered')) return;

            if(correct){
                button.style.backgroundColor = "#4CAF50";
                score++;
            } else {
                button.style.backgroundColor = "#f44336";
            }

            const buttons = li.querySelectorAll("button");
            buttons.forEach(b => b.disabled = true);
            li.classList.add('answered');
            answered++;

            const totalQuestions = document.querySelectorAll("ol li").length;
            if(answered === totalQuestions){
                document.getElementById('result').innerText = "Hai totalizzato " + score + "/" + totalQuestions + " punti!";
                document.getElementById('punteggioInput').value = score;

                <?php if($utente_loggato): ?>
                    // Invia automaticamente il punteggio al server
                    setTimeout(() => document.getElementById('quizForm').submit(), 1000);
                <?php endif; ?>
            }
        }

        function resetQuiz() {
            score = 0;
            answered = 0;
            document.getElementById('result').innerText = "";
            document.getElementById('punteggioInput').value = "";

            const lis = document.querySelectorAll("ol li");
            lis.forEach(li => {
                li.classList.remove('answered');
                const buttons = li.querySelectorAll("button");
                buttons.forEach(b => {
                    b.disabled = false;
                    b.style.backgroundColor = "";
                });
            });
        }
    </script>
</head>
<body>

<header>
    <h1>Quiz di Tecnologie Web</h1>
    <?php if($utente_loggato): ?>
        <p>Benvenuto, <?= htmlspecialchars($_SESSION['username']) ?>! Metti alla prova le tue competenze.</p>
    <?php else: ?>
        <p>Registrati o accedi per salvare i tuoi risultati!</p>
    <?php endif; ?>
</header>


<!-- NAV BAR PRINCIPALE -->
<nav class="navquiz">
    <a href="homepage.php">Home</a>
    <a href="glossario.php">Glossario</a>
    </nav>

<div class="quiz-container">

    <!-- VERO/FALSO -->
    <div class="quiz-section">
        <h2>Domande Vero o Falso
            <img src="../immagini/check.png" alt="Logo Portale" style="width:16px; height:16px; vertical-align:middle;">
            <img src="../immagini/cancel.png" alt="Logo Portale" style="width:16px; height:16px; vertical-align:middle;">
        </h2>

        <form id="quizForm" method="post">
            <input type="hidden" name="punteggio" id="punteggioInput">
            <input type="hidden" name="id_quiz" value="<?= $id_quiz ?>">

            <ol>
                <?php while($row = pg_fetch_assoc($domande)): ?>
                    <li>
                        <?= htmlspecialchars($row['testo']) ?>
                        <button type="button" onclick="checkAnswer(this, <?= $row['risposta_corretta'] ? 'true' : 'false' ?>)">Vero</button>
                        <button type="button" onclick="checkAnswer(this, <?= $row['risposta_corretta'] ? 'false' : 'true' ?>)">Falso</button>
                    </li>
                <?php endwhile; ?>
            </ol>
        </form>

        <p id="result"></p>
        <button type="button" onclick="resetQuiz()">Ricomincia il quiz</button>
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
    <?php else: ?>
        <p><em>Nessuna domanda Vero/Falso disponibile</em></p>
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

    <!-- Drag & Drop -->
    <?php if(count($domande_dd) > 0): ?>
    <section class="quiz-section">
        <h2>Drag & Drop</h2>
        <?php foreach($domande_dd as $row): ?>
            <p><?= htmlspecialchars($row['termine']) ?>: <input type="text" name="risposte[dd][<?= $row['id'] ?>]"></p>
        <?php endforeach; ?>
    </section>
    <?php endif; ?>

    <button type="submit">Invia Risposte</button>
    <button type="button" onclick="resetQuiz()">Reset</button>
</form>

<?php if(isset($messaggio_punteggio)): ?>
    <p><strong><?= $messaggio_punteggio ?></strong></p>
<?php endif; ?>
</div>

</body>
</html>


