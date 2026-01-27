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
    <meta name="author" content="gruppoMMIT26"/>
    <meta name="description" content="Homepage"/>
    <title>Portale Tecnologie Web</title>
    <link rel="stylesheet" href="../css/homepagecss.css" type="text/css">
    <link rel="icon" href="../immagini/iconarazzo.ico" type="image/X.icon" />
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

<nav>

    <?php if (!$utente_loggato): ?>
        <!-- UTENTE ANONIMO -->
        
<!-- Per aprire login -->
<a href="accesso.php?form=login">Login</a>

<!-- Per aprire registrazione -->
<a href="accesso.php?form=register">Registrazione</a>
    <?php endif; ?>
        <a href="quiz.php">Quiz</a>
        <a href="glossario.php">Glossario</a>
    <?php if ($utente_loggato): ?>
        <!-- UTENTE AUTENTICATO -->
        <a href="profilo.php">Profilo</a>
    <?php endif; ?>

        <!-- SEMPRE VISIBILE -->
    <div class="dropdown-menu">
        <button class="dropbtn" onclick="toggleMenu()">Menu</button>
        <div id="dropdown-content" class="dropdown-content">
                <?php if($utente_loggato): ?>
            <a href="#storia">Storia del Web</a>
            <a href="#sessioni">Sessioni di Studio </a>
                <?php endif; ?>
            <a href="#chisiamo">Chi siamo</a>           
            <a href="#feedback">Feedback</a>
            <a href="#contatti">Contatti</a>   
        </div>
    </div>

</nav>

<!-- SEZIONE INTRO DINAMICA -->
<div class="intro">
    <?php if($utente_loggato): ?>
        <h1>Benvenuto, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Sei loggato e puoi accedere a tutte le funzionalità del portale!</p>
            <p>Disponibili ora: approfondimento sulla storia del Web, orari delle sessioni di studio, quiz di autovalutazione e glossario.
        </p>
    <?php else: ?>
        <h1>
        Sei uno studente di Tecnologie Web? <br>Sei nel posto giusto!
        </h1>

        <p>La homepage offre una panoramica generale dei servizi del portale, mentre, 
            le nostre funzionalità esclusive (approfondimenti, sessioni di studio, quiz di autovalutazione e glossario) sono accessibili solo dopo la registrazione...non perdere tempo:
            <a href="accesso.php#register" style="color: #fd0d59; font-weight: bold; text-decoration: underline;">Registrati ora!</a>
    </p>

    <?php endif; ?>
</div>

<!-- VIDEO -->
<div class="contenuto-video">
    <video controls autoplay muted loop width="68%" >
        <source src="../video/pc.mp4" type="video/mp4">
        Il tuo browser non supporta il video.
    </video>
</div>

<!-- DINAMICA -->
 <?php if($utente_loggato): ?>
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
       DARPA</span> per scopi militari. 
    </p>
    <p>
    Con l’introduzione del protocollo <span class="highlight">TCP/IP</span> nel 1982, ARPANET si trasforma progressivamente 
    in <span class="highlight">Internet</span>, un’infrastruttura che consente la comunicazione tra computer e dispositivi 
    distribuiti in tutto il mondo. <p><i>Internet esiste e funziona anche senza il Web, ma è proprio il Web che ne ha 
    favorito la diffusione di massa tra gli utenti.</i></p>Nel 1989 il fisico <span class="highlight">Tim Berners-Lee</span>, 
    lavorando al CERN di Ginevra, propose un sistema per la condivisione di documenti ipertestuali tra ricercatori. 
    Nel 1991 vennero definiti il linguaggio HTML e il protocollo HTTP, che permisero la creazione e il trasferimento 
    di documenti collegati tramite link.<br> Nasce così ufficialmente il World Wide Web, reso pubblico nel 1993 e destinato 
    a una crescita esponenziale negli anni successivi.
   </p>
  
</div>


<!-- ORARI LIVE  -->
<div id="sessioni" class="contenuto">
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
    <br>
    Seguici sui nostri social per non perderti nessuna novità!<br>
<a href="https://www.tiktok.com/@gruppo_mmit?_r=1&_t=ZN-93OUU82znuA">
    <img src="../immagini/tiktok.jpg" alt="Logo TikTok" width="100px" style="margin-left: 40px;">
</a>

</div>
<?php endif; ?>

<div class="citazione">
    <blockquote cite="https://letteralmente.net/frasi-celebri/tim-berners-lee/">
        "Il Web non si limita a collegare macchine, connette delle persone."
        <p style="text-align: right;">- Tim Berners Lee</p>
    </blockquote>
</div>



<!-- CHI SIAMO -->
<div id="chisiamo" class="contenuto">
    <h2>Chi siamo?</h2>
    <p>
        Siamo studenti dell'<a href="https://www.unisa.it/">Università di Salerno</a> e frequentiamo il terzo anno di 
        Ingegneria Informatica. <br>L'obiettivo di questo portale è semplice ma ambizioso: rendere lo studio chiaro
        e accessibile a tutti.</p>
    <h2>La nostra community</h2>
    <strong>MMIT</strong> è tra le prime community per lo studio in Italia.<br>
    Il nostro gruppo non è solo uno spazio digitale, è il punto di riferimento per chi vuole imparare 
    e migliorarsi ogni giorno.<br>
    Qui non sarai mai solo: troverai motivazione, amicizie e una rete pronta ad aiutarti a superare ogni sfida 
    universitaria.
   <h2>I fondatori</h2>
   Dietro questo progetto ci siamo noi: studenti proprio come te! <img src="../immagini/smile.png" style="width:16px; height:16px; vertical-align:middle;"> </p>

 </p>
</div>




<div class="citazione">
    <blockquote cite="https://letteralmente.net/frasi-celebri/tim-berners-lee/">
        "Considero il Web come un tutto potenzialmente collegato a tutto, come un'utopia 
        che ci regala una libertà mai vista prima."
        <p style="text-align: right;">- Tim Berners Lee</p>
    </blockquote>
    

</div>

<!-- STATISTICHE E FEEDBACK -->
<div id="feedback" class="contenuto">
    <h2>Feedback</h2>
    <ul>
        <li>Questo portale ha supportato centinaia di studenti nello studio di Tecnologie Web.</li>
        <li>Le opinioni raccolte evidenziano l'efficacia del materiale interattivo come strumento di supporto alla preparazione dell'esame.</li>
        <li>Ogni tua visita conta! Grazie a studenti come te, il nostro portale continua a crescere e migliorare ogni giorno.</li>
        <li>Numero di visite totali al sito: <strong><?php echo number_format($visite); ?></strong></li>
        <li>Unisciti alla nostra community e affronta gli esami con noi... cosa aspetti? <img src="../immagini/cuoricino.png" alt="cuore" width="16" height="16" style="vertical-align:middle;">
</li> </li>
    </ul>
</div>

<div class="citazione">
    <blockquote cite="https://netrise.it/aforismi-sul-mondo-digitale/">
        "Internet è il più grande veicolo di autodivulgazione di tutti i tempi”.
        <p style="text-align: right;">- Bill Gates</p>
    </blockquote>
</div>


<!-- CONTATTI -->
<div id="contatti" class="contenuto">
    <h2>Contatti utili</h2>
    <strong>Gruppo MMIT </strong><img src="../immagini/iconauser.png" style="width:16px; height:16px; vertical-align:middle;">
    <p>
        Lucia Iasevoli   | Email: <a href="mailto:l.iasevoli1@studenti.unisa.it">l.iasevoli1@studenti.unisa.it</a><br>
        Lucia Monetta    | Email: <a href="mailto:l.monetta8@studenti.unisa.it">l.monetta8@studenti.unisa.it</a><br>
        Matteo Muccio    | Email: <a href="mailto:m.muccio3@studenti.unisa.it">m.muccio3@studenti.unisa.it</a><br>
        Michele Tamburro | Email: <a href="mailto:m.tamburro@studenti.unisa.it">m.tamburro@studenti.unisa.it</a>
    
</div>

<a id="tornaSu" href="#inizio">Torna su</a> 

<!-- FOOTER -->
<footer>
    <p>Corso Tecnologie Web – A.A. 2025-2026 | Portale didattico per studenti di Ingegneria Informatica</p>
    <p>Università degli Studi di Salerno - Via Giovanni Paolo II, 132 - 84084 Fisciano (SA)</p>
 </footer>

</body>

</html>
