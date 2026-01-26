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
        <p>Qui puoi approfondire HTML, CSS, JavaScript e PHP e testare le tue competenze con il quiz di autovalutazione.</p>
        <p>La dashboard fornisce una panoramica generale del sito ma, alcune funzionalità, come il glossario e i quiz interattivi, 
            sono accessibili solo dopo la registrazione...non perdere tempo,<span style="color: #fd0d59ff;"><strong> Registrati ora!</strong></span>
        </p>
    <?php endif; ?>
</div>

<!-- VIDEO -->
<div class="contenuto-video">
    <video controls autoplay muted loop width="68%" >
        <source src="../immagini/pc.mp4" type="video/mp4">
        Il tuo browser non supporta il video.
    </video>
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
    <img src="../immagini/cuoricino.png" style="width:16px; height:16px; vertical-align:middle;">
    </p> 
</div>



<div class="citazione">
    <blockquote cite="https://letteralmente.net/frasi-celebri/tim-berners-lee/">
        "Il Web non si limita a collegare macchine, connette delle persone."
        <p style="text-align: right;">- Tim Berners Lee</p>
    </blockquote>
</div>


<!-- ORARI LIVE  -->
<div class="contenuto">
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
    <p> Tiktok: <a href="https://www.tiktok.com/@gruppo_mmit?_r=1&_t=ZN-93OUU82znuA">@gruppo_mmit</a> 
</div>

<div class="citazione">
    <blockquote cite="https://letteralmente.net/frasi-celebri/tim-berners-lee/">
        "Considero il Web come un tutto potenzialmente collegato a tutto, come un'utopia 
        che ci regala una libertà mai vista prima."
        <p style="text-align: right;">- Tim Berners Lee</p>
    </blockquote>
    

</div>
<!-- CHI SIAMO -->
<div class="contenuto">
    <h2>Chi siamo?</h2>
    <p>
        Siamo studenti dell'<a href="https://www.unisa.it/">Università di Salerno</a> e frequentiamo il terzo anno di 
        Ingegneria Informatica. <img src="../immagini/smile.png" style="width:16px; height:16px; vertical-align:middle;">
    </p>
    <p>Abbiamo deciso di creare questo portale per supportare lo studio di altri studenti come noi, 
        offrendo spiegazioni sintetiche, esempi pratici e quiz di autovalutazione. </p>
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
