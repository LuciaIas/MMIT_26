<?php
session_start();
include __DIR__ . '/db.php';

$utente_loggato = isset($_SESSION['username']);

$visite = 0;

// prova a inserire una visita e controlla errore
$result_insert = pg_query($conn, "INSERT INTO visite_sito DEFAULT VALUES");
if (!$result_insert) {
    die("Errore inserimento visite: " . pg_last_error($conn));
}

// conta tutte le visite
$result = pg_query($conn, "SELECT COUNT(*) FROM visite_sito");
if ($result !== false) {
    $row = pg_fetch_row($result);
    $visite = $row[0];
} else {
    die("Errore conteggio visite: " . pg_last_error($conn));
}

?>


<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <title>Portale Tecnologie Web</title>
    <link rel="stylesheet" href="../css/homepagecss.css">
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
</head>


<body>
<header>
    <div id="inizio" class="header-content">
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
    <!-- MENU A TENDINA -->
    <div class="dropdown-menu">
        <button class="dropbtn" onclick="toggleMenu()">Sezioni </button>
        <div id="dropdown-content" class="dropdown-content">
            <a href="#storia">Storia del Web</a>
            <a href="#feedback">Feedback</a>
            <a href="#contatti">Contatti</a>           
        </div>
    </div>

    <!-- <a href="<?php echo $utente_loggato ? 'quiz.php' : 'accesso.php?mode=login'; ?>" class="btn">Quiz</a> -->
    <!-- <a href="<?php echo $utente_loggato ? 'glossario.php' : 'accesso.php?mode=login'; ?>" class="btn">Glossario</a> -->
    <a href="quiz.php">Quiz</a>
    <a href="glossario.php">Glossario</a>
    <a href="profilo.php">Profilo</a> 
    <!-- <a href="<?php echo $utente_loggato ? 'glossario.php' : 'accesso.php?mode=login'; ?>" class="btn">Glossario</a> -->   
</nav>

<!-- SEZIONE INTRO DINAMICA -->
<div class="intro">
    <?php if($utente_loggato): ?>
        <h1>Benvenuto, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
        <p>
            Sei loggato e puoi accedere a tutte le funzionalità del portale, inclusi quiz interattivi e glossario completo.
            Approfondisci HTML, CSS, JavaScript e PHP e testa le tue competenze direttamente dalla dashboard.
        </p>
    <?php else: ?>
        <h1>Sei uno studente di Tecnologie Web? Sei nel posto giusto!</h1>
        <p>
            Qui puoi approfondire HTML, CSS, JavaScript e PHP e testare le tue competenze con i quiz di autovalutazione.
            La dashboard fornisce la parte introduttiva dei linguaggi e la descrizione della storia del Web.
            Alcune funzionalità, come il glossario e i quiz interattivi, 
            sono accessibili solo dopo la registrazione...non perdere tempo,<span style="color: #0d6efd;"><strong> Registrati ora!</strong></span>
        </p>
    <?php endif; ?>
</div>

<!-- VIDEO -->
<div class="contenuto-video">
    <video controls autoplay muted loop width="61%" >
        <source src="../immagini/pc.mp4" type="video/mp4">
        Il tuo browser non supporta il video.
    </video>
</div>

<div class="citazione">
    <blockquote cite="https://netrise.it/aforismi-sul-mondo-digitale/">
        "Internet è il più grande veicolo di autodivulgazione di tutti i tempi”.
        <p style="text-align: right;">- Bill Gates</p>
    </blockquote>
</div>

<div class="citazione">
    <blockquote cite="https://letteralmente.net/frasi-celebri/tim-berners-lee/">
        "Considero il Web come un tutto potenzialmente collegato a tutto, come un'utopia 
        che ci regala una libertà mai vista prima."
        <p style="text-align: right;">- Tim Berners Lee</p>
    </blockquote>
    

</div>

<div class="citazione">
    <blockquote cite="https://letteralmente.net/frasi-celebri/tim-berners-lee/">
        "Il Web non si limita a collegare macchine, connette delle persone."
        <p style="text-align: right;">- Tim Berners Lee</p>
    </blockquote>
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


<!-- STATISTICHE E FEEDBACK -->
<div id="feedback" class="contenuto">
    <h2>Feedback</h2>
    <p>Questo portale ha supportato centinaia di studenti nello studio di Tecnologie Web. </p>
    <p>La maggior parte di loro dichiara di aver trovato utile il materiale interattivo e i quiz di autovalutazione 
    e di aver superato con successo l'esame!</p>
    <p>Ogni visita conta, il nostro portale cresce ogni giorno grazie a studenti come te.
    <p>Numero di visite totali al sito:<strong><?php echo number_format($visite); ?></strong></p>
    <p>Unisciti anche tu alla nostra community e prepara gli esami con noi...Cosa aspetti!
     <img src="../immagini/cuoricino.png" alt="Logo Portale" style="width:16px; height:16px; vertical-align:middle;">
    </p> 
</div>

<!-- ORARI LIVE  -->
<div id="orari-live" class="contenuto">
    <h2>Sessioni di Studio</h2>
    <p>Partecipa alle nostre live su TikTok per studiare insieme e supportarci durante la sessione!</p>
    
    <table class="tabella-orari">
        <thead>
            <tr>
                <th>Giorno</th>
                <th>Orario</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Lunedì</td>
                <td>9:00 - 13:00 / 16:00 - 20:00</td>
            </tr>
            <tr>
                <td>Martedì</td>
                <td>9:00 - 13:00 / 16:00 - 20:00</td>
            </tr>
            <tr>
                <td>Mercoledì</td>
                <td>9:00 - 13:00 / 16:00 - 20:00</td>
            </tr>
            <tr>
                <td>Giovedì</td>
                <td>9:00 - 13:00 / 16:00 - 20:00</td>
            </tr>
            <tr>
                <td>Venerdì</td>
                <td>9:00 - 13:00 / 16:00 - 18:00</td>
            </tr>
            <tr>
                <td>Sabato</td>
                <td>9:00 - 13:00 / 16:30 - 18:00</td>
            </tr>
            <tr>
                <td>Domenica</td>
                <td>Tutti meritiamo un po' di riposo!</td>
            </tr>
        </tbody>
    </table>
    <p> Tiktok: @Gruppo_MMIT 
</div>


<!-- CHI SIAMO -->
<div class="contenuto">
    <h2>Chi siamo?</h2>
    <p>
        Siamo un gruppo di studenti del terzo anno di Ingegneria Informatica frequentanti
        il corso di Tecnologie Web. Abbiamo creato questo portale per supportare lo studio,
        offrendo spiegazioni sintetiche, esempi pratici e quiz di autovalutazione. 
        Qui puoi accedere alla parte descrittiva della storia e dei linguaggi; altre sezioni sono riservate agli utenti registrati.
    </p>
</div>


<!-- CONTATTI -->
<div id="contatti" class="contenuto">
    <h2>Contatti utili</h2>
    <strong>Gruppo MMIT</strong>
    <p>
        Lucia Iasevoli   | Email: <a href="mailto:l.iasevoli1@studenti.unisa.it">l.iasevoli1@studenti.unisa.it</a><br>
        Lucia Monetta    | Email: <a href="mailto:l.monetta8@studenti.unisa.it">l.monetta8@studenti.unisa.it</a><br>
        Matteo Muccio    | Email: <a href="mailto:m.muccio3@studenti.unisa.it">m.muccio3@studenti.unisa.it</a><br>
        Michele Tamburro | Email: <a href="mailto:m.tamburro@studenti.unisa.it">m.tamburro@studenti.unisa.it</a>
    </p>
</div>

<a id="tornaSu" href="#inizio">Torna su</a> 

<!-- FOOTER -->
<div class="footer">
    <p>Corso Tecnologie Web – A.A. 2025-2026 | Portale didattico per studenti di Ingegneria Informatica</p>
    <p>Università degli Studi di Salerno - Via Giovanni Paolo II, 132 - 84084 Fisciano (SA)</p>
</div>


</body>
</html>
