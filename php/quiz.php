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
    
<script>
let score = 0;
let answered = 0;

// Funzione per verificare la risposta
function checkAnswer(button, correct) {
    const li = button.closest("li"); // prendi l'elemento li della domanda

    // Se la domanda è già stata risposta, non fare nulla
    if(li.classList.contains('answered')) return;

    // Colora il bottone selezionato
    if(correct) {
        button.style.backgroundColor = "#4CAF50"; // verde
        score++;
    } else {
        button.style.backgroundColor = "#f44336"; // rosso
    }

    // Disabilita tutti i bottoni della stessa domanda
    const buttons = li.querySelectorAll("button");
    buttons.forEach(b => b.disabled = true);

    // Marca come risposta
    li.classList.add('answered');
    answered++;

    // Mostra il risultato se tutte le domande sono state risposte
    const totalQuestions = document.querySelectorAll("ol li").length;
    if(answered === totalQuestions) {
        document.getElementById('result').innerText = "Hai totalizzato " + score + "/" + totalQuestions + " punti!";
    }
}

// Funzione per resettare il quiz
function resetQuiz() {
    score = 0;
    answered = 0;
    document.getElementById('result').innerText = "";

    const lis = document.querySelectorAll("ol li");
    lis.forEach(li => {
        li.classList.remove('answered');
        const buttons = li.querySelectorAll("button");
        buttons.forEach(b => {
            b.disabled = false;
            b.style.backgroundColor = ""; // reset colore
        });
    });
}
</script>
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

<!-- VERO/FALSO -->
<div class="quiz-section">
    <h2>Domande Vero o Falso
        <img src="../immagini/check.png" alt="Logo Portale" style="width:16px; height:16px; vertical-align:middle;">
    <img src="../immagini/cancel.png" alt="Logo Portale" style="width:16px; height:16px; vertical-align:middle;"></h2>

    <form id="quizForm">
        <ol>
            <p>
            <li>
                HTML è un linguaggio di programmazione.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button>
            </li>
    </p>
            <li>
                Il tag &lt;div&gt; serve a creare divisioni logiche di contenuto senza influenzare lo stile.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                Il tag &lt;span&gt; è utilizzato principalmente per applicare stili inline su una parte di testo.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                I commenti in HTML si scrivono così: &lt;!-- commento --&gt;.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                In CSS, la proprietà color cambia il colore dello sfondo.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button>
            </li>

            <li>
                In JavaScript, document.getElementById('id') restituisce un array di elementi con quell’ID.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button>
            </li>

            <li>
                Il tag &lt;a&gt; serve a creare link ipertestuali tra pagine web.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                Le proprietà CSS margin e padding hanno lo stesso effetto sul layout.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button>
            </li>

            <li>
                JavaScript può modificare dinamicamente il contenuto di una pagina web.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                L'attributo target="_self" apre il link nella stessa scheda, mentre target="_blank" apre il link in una nuova scheda.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                È obbligatorio rispettare la gerarchia dei titoli (&lt;h1&gt; , &lt;h2&gt; , &lt;h3&gt; , ...).
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button>
            </li>

            <li>
                CSS supporta unità di misura ASSOLUTE e RELATIVE.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                Il margin è lo spazio tra il bordo dell'elemento e tutto ciò che lo circonda nella pagina.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                :hover si applica quando un elemento è stato attivato dall'utente.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button>
            </li>

            <li>
                PHP è non tipato.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                Un parametro con valore di default può venire prima dei i parametri obbligatori. 
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button>
            </li>

            <li>
                HTTP è un protocollo STATEFUL.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button>
            </li>

            <li>
                In setcookie(nome,valore,expire,path,domain,secure) solo nome è obbligaotrio.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                L'uso di * dopo SELECT consente di selezionare tutti gli attributi della tabella.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                Non c'è relazione tra Java e JavaScript.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                JavaScript non è case-sensitive.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button>
            </li>

            <li>
                Il DOM (Document Object Model) è una collezione di oggetti che rappresentano gli elementi nel documento HTML.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                JavaScript è un linguaggio event-driven.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                L'elemento &lt;Canvas&gt; ha un metodo chiamato getContext() per ottenere il contesto di rendering.
                <button type="button" onclick="checkAnswer(this, true)">Vero</button>
                <button type="button" onclick="checkAnswer(this, false)">Falso</button>
            </li>

            <li>
                Un wireframe deve necessariamente avere un alto livello di fedeltà.
                <button type="button" onclick="checkAnswer(this, false)">Vero</button>
                <button type="button" onclick="checkAnswer(this, true)">Falso</button>
            </li>
        </ol>
    </form>
    <p id="result"></p>
    <p>
    <button type="button" onclick="resetQuiz()">Ricomincia il quiz</button>
</p>
</div>



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
