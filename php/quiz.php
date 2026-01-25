<?php
session_start();
include __DIR__ . '/db.php'; // connessione al database
$utente_loggato = isset($_SESSION['username']);
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Quiz Tecnologie Web</title>
    <link rel="stylesheet" href="../css/quiz.css">
</head>
<body>

<header>
    <h1>Quiz di Tecnologie Web</h1>
    <?php if($utente_loggato): ?>
        <p>Benvenuto, <?php echo htmlspecialchars($_SESSION['username']); ?>! Metti alla prova le tue competenze.</p>
    <?php else: ?>
        <p>Registrati o accedi per salvare i tuoi risultati!</p>
    <?php endif; ?>
</header>


<div class="quiz-container">
<div class="quiz-section">
    <h2>Domande Vero o Falso</h2>
    <!-- VERO/FALSO -->
        <form id="quizForm">
                <p>1. HTML è un linguaggio di programmazione.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button></p>

                <p>2. Il tag &lt;div&gt; serve a creare divisioni logiche di contenuto senza influenzare lo stile.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button></p>

                <p>3. Il tag &lt;span&gt; è utilizzato principalmente per applicare stili inline su una parte di testo.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button></p>

                <p>4. I commenti in HTML si scrivono così: &lt;!-- commento --&gt;.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button></p>

                <p>5. In CSS, la proprietà color cambia il colore dello sfondo.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button></p>

                <p>6. In JavaScript, document.getElementById('id') restituisce un array di elementi con quell’ID.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button></p>

                <p>7. Il tag &lt;a&gt; serve a creare link ipertestuali tra pagine web.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button></p>

                <p>8. Le proprietà CSS margin e padding hanno lo stesso effetto sul layout.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button></p>

                <p>9. JavaScript può modificare dinamicamente il contenuto di una pagina web.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button></p>

                <p>10. Gli attributi id e class in HTML possono essere usati più volte nello stesso documento.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button></p>
        </form>
        <p id="result"></p>
</div>

<script>
let score = 0;
let answered = 0;

function checkAnswer(button, correct) {
    if(button.parentElement.classList.contains('answered')) return; // evita doppie risposte

    if(correct) {
        button.style.backgroundColor = "#4CAF50"; // verde
        score++;
    } else {
        button.style.backgroundColor = "#f44336"; // rosso
    }

    button.parentElement.classList.add('answered');
    answered++;

    // Mostra risultato finale
    if(answered === 10) {
        document.getElementById('result').innerText = "Hai totalizzato " + score + "/10 punti!";
    }
}
</script>


    <!-- COMPLETA LA FRASE -->
    <section class="quiz-section">
        <h2>Completa la frase</h2>
        <form>
            <p>1. Il linguaggio <input type="text"> serve a creare la struttura delle pagine web. </p>
            <p>2. Il protocollo <input type="text"> permette la trasmissione di pagine web. </p>
            <p>3. <input type="text"> è un linguaggio lato server molto diffuso. </p>
            <p>4. Il Web 2.0 è caratterizzato da contenuti <input type="text"> creati dagli utenti. </p>
            <p>5. L’insieme di documenti interconnessi tramite link costituisce il <input type="text">. </p>
        </form>
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
