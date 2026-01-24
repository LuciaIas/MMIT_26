<?php
session_start(); // gestione login
include __DIR__ . '/db.php'; // connessione al database

// Controllo se utente loggato
$utente_loggato = isset($_SESSION['username']);
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
    <h1>Benvenuto nel Portale Tecnologie Web</h1>
    <p>Il tuo spazio per imparare, ripassare e testare le tue competenze!</p>
</header>

<!-- NAV BAR PRINCIPALE -->
<nav>
    <a href="accesso.php?mode=login">Accedi</a>
    <a href="accesso.php?mode=register">Registrazione</a>
    <a href="contenuti.php">Quiz</a>
    <a href="glossario.php">Glossario</a>
</nav>

<!-- SEZIONE INTRO -->
<div class="intro">
    <h1>Sei uno studente di Tecnologie Web? Sei nel posto giusto!</h1>
    <p>
    Qui puoi approfondire HTML, CSS, JavaScript e PHP e testare le tue competenze con quiz di autovalutazione.
    La dashboard fornisce la parte introduttiva dei linguaggi e la descrizione della storia del Web.
    Alcune funzionalità, come il glossario e i quiz interattivi, sono accessibili solo dopo la registrazione...Registrati ora!
    </p>
</div>

<!-- SOMMARIO / MENU INTERNO -->
<div class="sommario">
    <h3>Sommario</h3>
    <ul>
        <li><a href="#storia">Storia del Web</a></li>
        <li><a href="#html">HTML</a></li>
        <li><a href="#css">CSS</a></li>
        <li><a href="#javascript">JavaScript</a></li>
        <li><a href="#php">PHP</a></li>
        <li><a href="#contatti">Contatti</a></li>
        <li><a href="#statistiche">Statistiche</a></li>
    </ul>
</div>



<!-- CHI SIAMO -->
<div class="chi-siamo">
    <h2>Chi siamo?</h2>
    <p>
        Siamo un gruppo di studenti del terzo anno di Ingegneria Informatica frequentanti
        il corso di Tecnologie Web. Abbiamo creato questo portale per supportare lo studio,
        offrendo spiegazioni sintetiche, esempi pratici e quiz di autovalutazione. 
        
    </p>
</div>

<!-- STORIA DEL WEB -->
<div id="storia" class="contenuto">
    <h2>La storia del World Wide Web</h2>
    <p>
        Il World Wide Web (WWW) è una rete di documenti e risorse interconnesse accessibili tramite Internet. 
        Nasce come evoluzione di ARPANET negli anni ’60, creata per lo scambio sicuro di informazioni. 
        Con TCP/IP nasce Internet, e nel 1991 il CERN definisce HTML e HTTP per creare documenti ipertestuali navigabili.
    </p>
    <p>
        Il Web 1.0 era statico: poche aziende pubblicavano contenuti e gli utenti potevano solo leggere. 
        L’ipertesto permetteva di navigare tra documenti tramite link.
    </p>
    <p>
        Con il Web 2.0 (dal 2004) gli utenti diventano protagonisti: creano contenuti, commentano e condividono informazioni su blog, social network e piattaforme collaborative. Le pagine diventano dinamiche e interattive grazie a HTML, CSS, JavaScript, AJAX e database server.
    </p>
    <p>
        Oggi Web 3.0 e Web semantico interpretano i dati per generare nuova conoscenza, grazie a intelligenza artificiale, metadati, cookie e geolocalizzazione. Infine, Web 4.0 (IoT) rende intelligenti gli oggetti connessi, migliorando la vita quotidiana dalla domotica ai veicoli autonomi.
    </p>
</div>

<!-- LINGUAGGI CHIAVE -->
<div id="html" class="contenuto">
    <h2>HTML</h2>
    <p>
        HTML (HyperText Markup Language) è il linguaggio standard per creare e strutturare pagine web. 
        Definisce titoli, paragrafi, elenchi, link, immagini e altri elementi. 
        Funziona tramite tag che indicano al browser come visualizzare il contenuto. 
        HTML stabilisce la struttura ma non lo stile estetico della pagina. 
        Ogni sito web si basa su HTML, fondamentale per la costruzione di qualsiasi pagina.
    </p>
</div>

<div id="css" class="contenuto">
    <h2>CSS</h2>
    <p>
        CSS (Cascading Style Sheets) definisce l’aspetto delle pagine web. 
        Controlla colori, font, spaziature, layout e altri aspetti visivi dei contenuti HTML. 
        Permette di separare la struttura dalla presentazione, rendendo più facile aggiornare lo stile. 
        CSS rende le pagine adattabili a computer, tablet e smartphone, trasformando il contenuto HTML in pagine gradevoli e leggibili.
    </p>
</div>

<div id="javascript" class="contenuto">
    <h2>JavaScript</h2>
    <p>
        JavaScript è un linguaggio di programmazione lato client che aggiunge interattività ai siti web. 
        Permette di reagire alle azioni degli utenti, aggiornare contenuti senza ricaricare la pagina, creare animazioni e giochi. 
        Il codice viene eseguito dal browser, garantendo un’interazione rapida e fluida. 
        JavaScript rende i siti attivi e coinvolgenti.
    </p>
</div>

<div id="php" class="contenuto">
    <h2>PHP</h2>
    <p>
        PHP (Hypertext Preprocessor) è un linguaggio lato server per contenuti dinamici. 
        Gestisce login, registrazioni, moduli e interazioni con database. 
        Elabora le richieste degli utenti e genera pagine personalizzate in base ai dati ricevuti. 
        PHP viene eseguito sul server, e il browser riceve solo l’HTML risultante. 
        Essenziale per siti interattivi e applicazioni web complesse.
    </p>
</div>

<!-- STATISTICHE -->
<div id="statistiche" class="contenuto">
    <h2>Statistiche e feedback</h2>
    <p>Il portale ha aiutato molti studenti a superare gli esami di Tecnologie Web!</p>
    <p>Il 70% degli studenti che ha utilizzato il sito ha superato con successo gli esami.</p>
    <p>Visite totali: <?php echo file_exists('visite.txt') ? file_get_contents('visite.txt') : 0; ?></p>
</div>

<!-- FOOTER -->
<div id="contatti" class="footer">
    <p>Corso Tecnologie Web – A.A. 2025-2026 | Portale didattico per studenti di Ingegneria Informatica</p>
    <p>Gruppo MMIT</p>
    <p>Email: l.iasevoli1@studenti.unisa.it, l.monetta8@studenti.unisa.it</p>
</div>

</body>
</html>
