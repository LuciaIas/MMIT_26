<?php
session_start();
include __DIR__ . '/db.php';
$utente_loggato = isset($_SESSION['username']);

$visite = 0;

$result_insert = pg_query($conn, "INSERT INTO visite_sito DEFAULT VALUES");
if (!$result_insert) {
    die("Errore inserimento visite: " . pg_last_error($conn));
}

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
    <link rel="stylesheet" href="../css/homepagecss?v=7.css" type="text/css">
    <link rel="icon" href="../immagini/iconalogo.png" type="image/X.icon" />

</head>

<body>
<div id="inizio"></div>

<header>
    <i> Da studenti, per studenti.</i>
</header>

<nav class="navbar">
    <div class="navbar-left">
        <img src="../immagini/logo111.png" alt="Logo Portale" class="logo">
        <span class="title">Portale di Tecnologie Web</span>
    </div>

<div class="navbar-links">
<?php if (!$utente_loggato): ?> 
<a href="accesso.php?form=login">Login</a>
<a href="accesso.php?form=register">Registrazione</a>
    <?php endif; ?>
        <a href="quiz.php">Quiz</a>
        <a href="glossario.php">Glossario</a>
    <?php if ($utente_loggato): ?>
        <a href="profilo.php">Profilo</a>
    <?php endif; ?>

    <div class="dropdown-menu">
        <button class="dropbtn" onclick="toggleMenu()">Menu ▾</button>
        <div id="dropdown-content" class="dropdown-content">
                <?php if($utente_loggato): ?>
            <a href="#sessioni">Sessioni di Studio </a>
                <?php endif; ?>
            <a href="#storia">Storia del Web</a>
            <a href="#chisiamo">Chi siamo</a>           
            <a href="#feedback">Feedback</a>
            <a href="#contatti">Contatti</a>   
        </div>
    </div>
</div>
</nav>


<div class="intro">
    <?php if($utente_loggato): ?>
        <h1>Benvenuto, <?php echo htmlspecialchars($_SESSION['username']); ?>!</h1>
            <p>Sei loggato e puoi accedere a tutte le funzionalità del portale!
            <br>Disponibili ora: orari delle sessioni di studio, nuovi quiz settimanali e glossario.
        </p>
    <?php else: ?>
        <h1>
        Sei uno studente di Tecnologie Web? <br>Sei nel posto giusto!
        </h1>

        <p>La Homepage offre una panoramica dei servizi del portale.<br> 
            Le funzionalità esclusive: sessioni di studio, quiz settimanali e glossario, sono accessibili solo dopo la registrazione...<br>non perdere tempo:
            <a href="accesso.php?form=register" style="color: #fd0d59; font-weight: bold; text-decoration: underline;">Registrati ora!</a>
    </p>

    <?php endif; ?>
</div>

<div class="contenuto-video">
       <video class="responsive-video" controls autoplay muted loop>
        <source src="../video/pc.mp4" type="video/mp4">
        Il tuo browser non supporta il video.
    </video>
</div>

<div id="storia" class="contenuto">
    <h2>La storia del World Wide Web</h2>

    <p>
       Il <span class="highlight">World Wide Web (WWW)</span> è una rete globale di documenti e risorse multimediali 
       accessibili tramite Internet grazie all’uso di un browser.
    </p>

    <p>
       Nasce dall’evoluzione delle prime reti di computer create per condividere informazioni. La più importante fu 
       <span class="highlight">ARPANET</span>, sviluppata alla fine degli anni ’60 negli Stati Uniti dalla 
       <span class="highlight" title="Defense Advanced Research Projects Agency">DARPA</span> per scopi militari.
    </p>

    <p>
       Con l’introduzione del protocollo <span class="highlight">TCP/IP</span> nel 1982, ARPANET si trasformò progressivamente 
       in <span class="highlight">Internet</span>, un’infrastruttura che collega computer e dispositivi in tutto il mondo.
       <img src="../immagini/website.png" style="width:16px; height:16px; vertical-align:middle;">
    </p>

    <p class="paragrafo-speciale">
        <strong>Curiosità:</strong> Nel 1989 il fisico <span class="highlight">Tim Berners-Lee</span>, al 
        <span class="highlight">CERN</span> di Ginevra, propose un sistema di documenti ipertestuali collegati tra loro. 
        Nel 1991 nacquero il linguaggio <span class="highlight">HTML</span> e il protocollo <span class="highlight">HTTP</span>, 
        rendendo possibile la creazione e la navigazione delle pagine web. Il World Wide Web fu reso pubblico nel 1993!
    </p>

    <p><i>Internet esiste e funziona anche senza il Web, ma è proprio il Web che ne ha favorito la diffusione di massa tra gli utenti.</i></p>
</div>

<?php if($utente_loggato): ?>
<div id="sessioni" class="contenuto">
    <h2>Sessioni di Studio</h2>
    <p>Partecipa alle nostre live su TikTok per studiare insieme e supportarci durante la sessione!
        <img src="../immagini/clock.png" style="width:16px; height:16px; vertical-align:middle;">
    </p>
    
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

<div id="chisiamo" class="contenuto">
    <h2>Chi siamo?</h2>
    <p>
        Siamo studenti dell'<a href="https://www.unisa.it/">Università di Salerno</a> e frequentiamo il terzo anno di 
        Ingegneria Informatica. <br>L'obiettivo di questo portale è semplice ma ambizioso: rendere lo studio chiaro
        e accessibile a tutti. <img src="../immagini/cervello.png" style="width:16px; height:16px; vertical-align:middle;">
    </p>
    <h2>La nostra community</h2>
    <strong>MMIT</strong> è tra le prime community per lo studio in Italia. <img src="../immagini/trofeo.png" style="width:16px; height:16px; vertical-align:middle;"><br>
    Il nostro gruppo non è solo uno spazio digitale, è il punto di riferimento per chi vuole imparare 
    e migliorarsi ogni giorno.<br>
    Qui non sarai mai solo: troverai motivazione, amicizie e una rete pronta ad aiutarti a superare ogni sfida 
    universitaria.
   <h2>I fondatori</h2>
   Dietro questo progetto ci siamo noi: Lucia Iasevoli, Lucia Monetta, Matteo Muccio e Michele Tamburro...
   <br> studenti proprio come te! 
    <img src="../immagini/smile.png" style="width:16px; height:16px; vertical-align:middle;"> </p>
 </p>
</div>

<div class="citazione">
    <blockquote cite="https://letteralmente.net/frasi-celebri/tim-berners-lee/">
        "Considero il Web come un tutto potenzialmente collegato a tutto, come un'utopia 
        che ci regala una libertà mai vista prima."
        <p style="text-align: right;">- Tim Berners Lee</p>
    </blockquote>
</div>



<div id="box-finali" class="box-container">
<div id="contatti" class="box">
    <h2>Contatti utili</h2>
      <p>
            Hai domande, suggerimenti o vuoi collaborare con noi? <img src="../immagini/letter.png" style="width:16px; height:16px; vertical-align:middle;"><br>
            Scrivi a: <a href="mailto:gruppo26MMIT@studenti.unisa.it">gruppo26MMIT@studenti.unisa.it</a><br>
         </p>
</div>
 <div id="feedback" class="box">
        <h2>Feedback</h2>
        <p>
       La totalità degli studenti considera il portale uno strumento efficace per prepararsi all’esame.<br>
La community continua a crescere, con <strong><?php echo number_format($visite); ?></strong></li> accessi registrati.<br>
        </p>
    </div>

</div>

<a id="tornaSu" href="#inizio">Torna su</a> 

<footer>
    <p> © Corso Tecnologie Web – A.A. 2025-2026 | Portale didattico per studenti di Ingegneria Informatica</p>
    <p>Università degli Studi di Salerno - Via Giovanni Paolo II, 132 - 84084 Fisciano (SA)</p>
 </footer>
 <script src="../js/homepage.js" type="text/javascript" ></script>
</body>
</html>
