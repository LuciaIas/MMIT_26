<?php
session_start();
include __DIR__ . '/db.php';

$utente_loggato = isset($_SESSION['username']);

$file_visite = __DIR__ . '/visite.txt';

// Controlliamo solo se il file esiste, altrimenti non facciamo nulla
if(file_exists($file_visite)) {
    $visite = (int)file_get_contents($file_visite);
    $visite++;
    file_put_contents($file_visite, $visite);
} else {
    $visite = 1; // opzionale: se non esiste, consideriamo 1 visita
}
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
    <a href="accesso.php?">Accedi</a>
    <a href="accesso.php?register=1">Registrati</a>
   <!-- <a href="<?php echo $utente_loggato ? 'quiz.php' : 'accesso.php?mode=login'; ?>" class="btn">Quiz</a> -->
      <!-- <a href="<?php echo $utente_loggato ? 'glossario.php' : 'accesso.php?mode=login'; ?>" class="btn">Glossario</a> -->
    <a href="quiz.php">Quiz</a>
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
       Il <span class="highlight">World Wide Web (WWW)</span> è una rete globale di documenti e risorse multimediali 
       interconnesse, accessibili tramite Internet e attraverso l’uso di un browser. </p>
    <p>
       Nasce come evoluzione delle prime reti di computer sviluppate per favorire la condivisione delle informazioni 
       tra più nodi. La prima rete significativa fu <span class="highlight">ARPANET</span>, creata alla fine degli 
       anni ’60 negli Stati Uniti dalla <span class="highlight" title="Defense Advanced Research Projects Agency">
       DARPA</span> sviluppò ARPANET per scopi militari. 
    </p>
    <p>
    Con l’introduzione del protocollo <span class="highlight">TCP/IP</span> nel 1982, ARPANET si trasforma progressivamente 
    in <span class="highlight">Internet</span>, un’infrastruttura che consente la comunicazione tra computer e dispositivi 
    distribuiti in tutto il mondo. <p><i>Internet esiste e funziona anche senza il Web, ma è proprio il Web che ne ha 
    favorito la diffusione di massa tra gli utenti.</i></p>Nel 1989 il fisico <span class="highlight">Tim Berners-Lee</span>, 
    lavorando al CERN di Ginevra, propose un sistema per la condivisione di documenti ipertestuali tra ricercatori. 
    Nel 1991 vennero definiti il linguaggio HTML e il protocollo HTTP, che permisero la creazione e il trasferimento 
    di documenti collegati tramite link. Nasce così ufficialmente il World Wide Web, reso pubblico nel 1993 e destinato 
    a una crescita esponenziale negli anni successivi.
   </p>
   <p>
        <h3 style="display: inline;">Web 1.0 : </h3>Pagine statiche, utenti lettori, ipertesti e URL. Pochi contenuti dinamici.
        <br>
        <h3 style="display: inline;">Web 2.0 : </h3>Web dinamico e partecipativo. Blog, social network, wiki e video sharing.
        <br>
        <h3 style="display: inline;">Web 3.0 : </h3>Web semantico e AI. Servizi personalizzati con metadati, cookie e geolocalizzazione.
        <br>
        <h3 style="display: inline;">Web 4.0 : </h3>Internet of Things: oggetti intelligenti connessi, domotica e veicoli autonomi.
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
    <p>DA AGGIUNGERE RECENSIONI SE VOGLIAMO</p>
</div>

<!-- CONTATTI -->
<div id="contatti" class="contenuto">
    <h2>Contatti</h2>
    <strong>Gruppo MMIT</strong>
    <p>
        Lucia Iasevoli   | Email: <a href="mailto:l.iasevoli1@studenti.unisa.it">l.iasevoli1@studenti.unisa.it</a><br>
        Lucia Monetta    | Email: <a href="mailto:l.monetta8@studenti.unisa.it">l.monetta8@studenti.unisa.it</a><br>
        Matteo Muccio    | Email: <a href="mailto:l.iasevoli1@studenti.unisa.it">l.iasevoli1@studenti.unisa.it</a><br>
        Michele Tamburro | Email: <a href="mailto:l.monetta8@studenti.unisa.it">l.monetta8@studenti.unisa.it</a>
    </p>
</div>


<!-- FOOTER -->
<div class="footer">
    <p>Corso Tecnologie Web – A.A. 2025-2026 | Portale didattico per studenti di Ingegneria Informatica</p>
    <p>Università degli Studi di Salerno - Via Giovanni Paolo II, 132 - 84084 Fisciano (SA)</p>
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
