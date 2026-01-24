<?php
session_start(); // gestione login
include __DIR__ . '/db.php'; // connessione al database

// Controllo se utente loggato
$utente_loggato = isset($_SESSION['username']);


$file_visite = 'visite.txt';

// Se il file non esiste, lo creiamo e mettiamo 0
if(!file_exists($file_visite)) {
    file_put_contents($file_visite, 0);
}

// Leggiamo il numero di visite attuali
$visite = (int)file_get_contents($file_visite);

// Incrementiamo di 1
$visite++;

// Riscriviamo il numero aggiornato nel file
file_put_contents($file_visite, $visite);

?>

<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Portale Tecnologie Web</title>
    <link rel="stylesheet" href="../css/homepagecss.css">

</head>

<body>

<header>
    <div class="header-content">
        <img src="../immagini/logo.png" alt="Logo Portale" class="header-img">
        <div class="header-text">
            <h1>Benvenuto nel Portale Tecnologie Web</h1>
            <p>Il tuo spazio per imparare, ripassare e testare le tue competenze!</p>
        </div>
    </div>
</header>


<!-- NAV BAR PRINCIPALE -->
<nav>
    <a href="accesso.php?mode=login">Accedi</a>
    <a href="accesso.php?mode=register">Registrati</a>
    <a href="contenuti.php">Quiz</a>
    <a href="glossario.php">Glossario</a>

    <!-- MENU A TENDINA -->
    <div class="dropdown-menu">
        <button class="dropbtn" onclick="toggleMenu()">Sezioni </button>
        <div id="dropdown-content" class="dropdown-content">
            <a href="#storia">Storia del Web</a>
            <a href="#html">HTML</a>
            <a href="#css">CSS</a>
            <a href="#php">PHP</a>
            <a href="#javascript">JavaScript</a>
            <a href="#statistiche">Statistiche</a>
            <a href="#feedback">Feedback</a>
            <a href="#contatti">Contatti</a>           
        </div>
    </div>
</nav>

<!-- SEZIONE INTRO DINAMICA -->
<div class="intro">
    <?php if($utente_loggato): ?>
        <h1>Benvenuto, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>
            Sei loggato e puoi accedere a tutte le funzionalità del portale, inclusi quiz interattivi e glossario completo.
            Approfondisci HTML, CSS, JavaScript e PHP e testa le tue competenze direttamente dalla dashboard.
        </p>
        <a href="quiz.php" class="btn">Vai ai Quiz</a>
        <a href="glossario.php" class="btn">Vai al Glossario</a>
    <?php else: ?>
        <h1>Sei uno studente di Tecnologie Web? Sei nel posto giusto!</h1>
        <p>
            Qui puoi approfondire HTML, CSS, JavaScript e PHP e testare le tue competenze con i quiz di autovalutazione.
            La dashboard fornisce la parte introduttiva dei linguaggi e la descrizione della storia del Web.
            Alcune funzionalità, come il glossario e i quiz interattivi, 
            sono accessibili solo dopo la registrazione...non perdere tempo,<strong> Registrati ora!</strong>
        </p>
    <?php endif; ?>
</div>

<!-- CHI SIAMO -->
<div class="chi-siamo">
    <h2>Chi siamo?</h2>
    <p>
        Siamo un gruppo di studenti del terzo anno di Ingegneria Informatica frequentanti
        il corso di Tecnologie Web. Abbiamo creato questo portale per supportare lo studio,
        offrendo spiegazioni sintetiche, esempi pratici e quiz di autovalutazione. 
        Qui puoi accedere alla parte descrittiva della storia e dei linguaggi; altre sezioni sono riservate agli utenti registrati.
    </p>
</div>

<!-- STORIA DEL WEB -->
<div id="storia" class="contenuto">
    <h2>La storia del World Wide Web</h2>
    <p>
        Il <span class="highlight">World Wide Web (WWW)</span> è una rete di documenti e risorse interconnesse accessibili tramite Internet. 
        Nasce come evoluzione di ARPANET negli anni ’60, creata per lo scambio sicuro di informazioni. 
        Con TCP/IP nasce Internet, e nel 1991 il CERN definisce HTML e HTTP per creare documenti ipertestuali navigabili.
    </p>
    <p>
        Il <span class="highlight">Web 1.0</span> era statico: poche aziende pubblicavano contenuti e gli utenti potevano solo leggere. 
        L’ipertesto permetteva di navigare tra documenti tramite link.
    </p>
    <p>
        Con il <span class="highlight">Web 2.0</span> (dal 2004) gli utenti diventano protagonisti: creano contenuti, commentano e condividono informazioni su blog, social network e piattaforme collaborative. Le pagine diventano dinamiche e interattive grazie a HTML, CSS, JavaScript, AJAX e database server.
    </p>
    <p>
        Oggi <span class="highlight">Web 3.0</span> e Web semantico interpretano i dati per generare nuova conoscenza, grazie a intelligenza artificiale, metadati, cookie e geolocalizzazione. Infine, Web 4.0 (IoT) rende intelligenti gli oggetti connessi, migliorando la vita quotidiana dalla domotica ai veicoli autonomi.
    </p>
</div>

<!-- LINGUAGGI CHIAVE -->
<div id="html" class="contenuto">
    <h2>HTML</h2>
    <p>HTML è il linguaggio standard per creare e strutturare pagine web. Definisce titoli, paragrafi, elenchi, link, immagini e altri elementi. Funziona tramite tag che indicano al browser come visualizzare il contenuto. Stabilisce la struttura ma non lo stile estetico della pagina. Fondamentale per qualsiasi sito web.</p>
</div>

<div id="css" class="contenuto">
    <h2>CSS</h2>
    <p>CSS definisce l’aspetto delle pagine web: colori, font, spaziature e layout. Permette di separare la struttura dalla presentazione, rendendo più semplice aggiornare lo stile. Adatta i contenuti a diversi dispositivi e trasforma l’HTML in pagine leggibili e gradevoli.</p>
</div>

<div id="javascript" class="contenuto">
    <h2>JavaScript</h2>
    <p>JavaScript aggiunge interattività ai siti web: risponde alle azioni dell’utente, aggiorna contenuti senza ricaricare la pagina, crea animazioni e giochi. Eseguito dal browser, garantisce un’interazione fluida e rende i siti attivi e coinvolgenti.</p>
</div>

<div id="php" class="contenuto">
    <h2>PHP</h2>
    <p>PHP è un linguaggio lato server per contenuti dinamici. Gestisce login, registrazioni, moduli e interazioni con database. Elabora richieste e genera pagine personalizzate in base ai dati. Viene eseguito sul server, fornendo HTML pronto al browser. Essenziale per siti interattivi e applicazioni web complesse.</p>
</div>

<!-- STATISTICHE -->
<div id="statistiche" class="contenuto">
    <h2>Statistiche</h2>
    <p>Questo portale ha supportato centinaia di studenti nello studio di Tecnologie Web. </p>
    <p>La maggior parte di loro dichiara di aver trovato utile il materiale interattivo e i quiz di autovalutazione 
    e di aver superato con successo l'esame!</p>
    <p>Ogni visita conta, il nostro portale cresce ogni giorno grazie a studenti come te.
    <p>Numero di visite totali al sito:<strong> <?php echo number_format($visite); ?> </strong> (aggiornate in tempo reale)</p>
    <p>Unisciti anche tu alla nostra community e prepara gli esami con noi...Cosa aspetti!
     <img src="../immagini/cuoricino.png" alt="Logo Portale" style="width:16px; height:16px; vertical-align:middle;">
    </p> 
</div>

<!-- FEEDBACK -->
<div id="feedback" class="contenuto">
    <h2>Feedback</h2>
    
</div>

<!-- FOOTER -->
<div class="footer">
    <p>Corso Tecnologie Web – A.A. 2025-2026 | Portale didattico per studenti di Ingegneria Informatica</p>
    <p>Gruppo MMIT</p>
    <p id="contatti">CONTATTI - Email : l.iasevoli1@studenti.unisa.it , l.monetta8@studenti.unisa.it , 
        m.muccio@studenti.unisa.it , m.tamburro@studenti.unisa.it</p>
</div>

<script>
function toggleMenu() {
    document.getElementById("dropdown-content").classList.toggle("show");
}

window.onclick = function(event) {
  if (!event.target.matches('.dropbtn')) {
    var dropdowns = document.getElementsByClassName("dropdown-content");
    for (var i = 0; i < dropdowns.length; i++) {
      dropdowns[i].classList.remove('show');
    }
  }
}

</script>

</body>
</html>
