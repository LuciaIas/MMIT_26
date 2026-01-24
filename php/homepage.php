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
    <title>Tecnologie Web</title>
    <link rel="stylesheet" href="../css/homepagecss.css">
</head>

<body>

<header>
    <h1>Benvenuto nel Portale Tecnologie Web</h1>
    <p class="intro">Il tuo spazio per imparare, ripassare e testare le tue competenze!</p>
</header>

<!-- NAV BAR PRINCIPALE -->
<nav>
    <a href="accesso.php">Accedi</a>
    <a href="accessso.php">Registrazione</a>
    <a href="contenuti.php">Quiz</a>
    <a href="glossario.php">Glossario</a>
</nav>

<!-- SEZIONE CENTRALE DI ATTENZIONE -->
<section class="focus">
    <h2>Se sei uno studente di Tecnologie Web… sei nel posto giusto!</h2>

<!-- CHI SIAMO -->
<section class="chi-siamo">
    <h2>Chi siamo?</h2>
    <p>
       Siamo un gruppo di studenti del terzo anno di Ingegneria Informatica, iscritti al corso di Tecnologie Web. 
        Abbiamo sviluppato questo portale come strumento di supporto allo studio, per offrirti spiegazioni sintetiche, 
        esempi pratici e quiz di autovalutazione. 
        Qui potrai approfondire HTML, CSS, JavaScript, PHP e database in modo interattivo.
        Registrati per accedere a tutte le funzionalità!
    </p>
     <p>
       
        Alcuni contenuti avanzati, come il dizionario dei termini tecnici e altre risorse esclusive, 
        sono accessibili solo dopo esserti registrato e aver effettuato il login. 
        Questa dashboard iniziale ti permette di consultare liberamente la parte descrittiva e introduttiva dei linguaggi e della storia del Web.
    </p>
</section>

    <!-- CHECKLIST INTRODUTTIVA -->
<div class="sommario">
    <h3>Sommario</h3>
    <ul>
        <li><a href="#storia">Storia del Web</a></li>
        <li><a href="#html">HTML</a></li>
        <li><a href="#css">CSS</a></li>
        <li><a href="#javascript">JavaScript</a></li>
        <li><a href="#php">PHP</a></li>
        <li><a href="#contatti">Contatti</a></li>
    </ul>
</div>



<!-- SEZIONE STORIA DEL WEB -->
<section id="storia" class="contenuto">
    <h2>La storia del World Wide Web</h2>

    <p>
        Il World Wide Web (WWW) è una rete di documenti e risorse interconnesse accessibili tramite Internet. 
        Nasce come evoluzione delle prime reti di computer, in particolare ARPANET negli anni ’60,
        creata per lo scambio sicuro di informazioni. Con l’introduzione del protocollo TCP/IP nel 1982 nasce Internet, 
        e nel 1991 il CERN di Ginevra sviluppa il primo server web, definendo HTML e HTTP per creare e trasferire documenti ipertestuali navigabili.
    </p>
    <p>
        Il Web 1.0 era statico: poche aziende pubblicavano contenuti informativi e gli utenti potevano solo leggere.
        L’ipertesto permetteva di navigare tra documenti tramite link.
    </p>
    <p>
        Con l’avvento del Web 2.0 (dal 2004) gli utenti diventano protagonisti: creano contenuti, commentano e condividono informazioni
        su blog, social network e piattaforme collaborative. Le pagine diventano dinamiche e interattive grazie a HTML, CSS, JavaScript, AJAX e database server.
    </p>
    <p>
        Oggi si parla di Web 3.0 e Web semantico, dove i dati vengono interpretati per generare nuova conoscenza,
        grazie a intelligenza artificiale, metadati, cookie e geolocalizzazione. Infine, il Web 4.0 o Internet delle cose (IoT)
        rende intelligenti gli oggetti e i dispositivi connessi, permettendo loro di raccogliere e condividere dati per migliorare la vita quotidiana.
    </p>
</section>

<!-- LINGUAGGI CHIAVE -->
<section id="html" class="contenuto">
    <h2>Linguaggi chiave</h2>

    <h3>HTML</h3>
    <p>
        HTML (HyperText Markup Language) è il linguaggio standard per creare e strutturare pagine web.
        Permette di definire titoli, paragrafi, elenchi, link, immagini e altri contenuti. Funziona con tag che indicano
        al browser come visualizzare il contenuto. HTML costituisce la struttura fondamentale di ogni sito.
    </p>

    <h3>CSS</h3>
    <p>
        CSS (Cascading Style Sheets) serve a definire l’aspetto delle pagine web, come colori, font, layout e spaziature.
        Permette di separare stile e contenuto, rendendo il sito più gradevole e adattabile a diversi dispositivi.
    </p>

    <h3>JavaScript</h3>
    <p>
        JavaScript è un linguaggio lato client che rende le pagine interattive. Permette di reagire a click, movimenti del mouse,
        aggiornare contenuti senza ricaricare la pagina e creare animazioni. Rende il sito dinamico e coinvolgente.
    </p>

    <h3>PHP</h3>
    <p>
        PHP è un linguaggio lato server che genera contenuti dinamici. Gestisce login, registrazioni e interazioni con database.
        Il server elabora le richieste e invia al browser solo l’HTML risultante, rendendo possibile creare applicazioni web complesse.
    </p>
</section>

<p>STATISTICHE DA IMPLEMENTARE </p>

<!-- FOOTER -->
<footer id="contatti">
    <p>Corso Tecnologie Web – A.A. 2025-2026 | Portale didattico per studenti di Ingegneria Informatica</p>
    <p>Gruppo MMIT</p>
    <p>Email: l.iasevoli1@studenti.unisa.it, l.monetta8@studenti.unisa.it etc</p>
</footer>

</body>
</html>
