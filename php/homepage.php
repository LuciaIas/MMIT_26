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
    <h1>Tecnologie Web</h1>
</header>

<!-- NAV BAR PRINCIPALE -->
<nav>
    <a href="accesso.php">Accedi</a>
    <a href="accessso.php">Registrazione</a>
    <a href="contenuti.php">Quiz</a>
    <a href="glossario.php">Glossario</a>
</nav>

<!-- SOMMARIO / MENU INTERNO -->
<section class="sommario">
    <h2>Sommario</h2>
    <ul>
        <li><a href="#storia">Storia del Web</a></li>
        <li><a href="#contatti">Contatti</a></li>
    </ul>
</section>

<main>

    <!-- SEZIONE STORIA DEL WEB -->
    <section id="storia" class="contenuto">
        <h2>La storia del World Wide Web</h2>

        <p>
            Le origini di Internet risalgono alla fine degli anni Sessanta con ARPANET,
            un progetto finanziato dal Dipartimento della Difesa degli Stati Uniti.
            L’obiettivo era creare una rete di comunicazione decentralizzata, capace di
            funzionare anche in caso di guasti a singoli nodi.
        </p>

        <p>
            Negli anni Ottanta ARPANET si evolve e si diffonde nel mondo accademico,
            fino a diventare la base di Internet. Tuttavia, è solo nei primi anni Novanta
            che nasce il World Wide Web, grazie a Tim Berners-Lee, che introduce
            HTML, HTTP e il concetto di collegamenti ipertestuali.
        </p>

        <p>
            Il Web 1.0 era caratterizzato da pagine statiche e contenuti principalmente
            informativi. Con il Web 2.0 si passa a un Web interattivo, in cui gli utenti
            diventano protagonisti attraverso social network, blog e piattaforme collaborative.
        </p>

        <p>
            Oggi si parla di Web 3.0 e Web semantico, in cui i dati sono strutturati
            in modo intelligente e le applicazioni web sfruttano tecnologie avanzate
            come intelligenza artificiale, API e servizi distribuiti.
        </p>
    </section>



</main>

<!-- FOOTER -->
<footer id="contatti">
    <p>Corso Tecnologie Web 2025-2026</p>
    <p>Gruppo MMIT</p>
    <p>Email: l.iasevoli1@studenti.unisa.it, l.monetta8@studenti.unisa.it</p>
</footer>

</body>
</html>
