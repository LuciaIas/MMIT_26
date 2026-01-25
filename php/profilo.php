<?php
session_start();
include __DIR__ . '/db.php';

// 1️⃣ Controllo accesso
if (!isset($_SESSION['username'])) {
    header("Location: accesso.php");
    exit;
}

$username = $_SESSION['username'];

// 2️⃣ Recupera dati utente (senza data_registrazione e ultimo_accesso)
$query = "SELECT username, email, tipo_utente, sesso, universita 
          FROM utenti 
          WHERE username=$1";
$result = pg_query_params($conn, $query, [$username]);

if (!$result) {
    die("Errore nel recupero dati utente: " . pg_last_error());
}

$user = pg_fetch_assoc($result);

// 3️⃣ Recupera quiz svolti
$quizQuery = "SELECT q.titolo, r.punteggio
              FROM risultati_quiz r
              JOIN quiz q ON r.id_quiz = q.id
              WHERE r.username = $1";
$quizResult = pg_query_params($conn, $quizQuery, [$username]);

?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Profilo Studente</title>
<link rel="stylesheet" href="../css/profilo.css">
</head>
<body>

<div class="container-profilo">
    <h1>Benvenuto, <?= htmlspecialchars($user['username']) ?>!</h1>

    <div class="info-personali">
        <p><strong>Nome utente:</strong> <?= htmlspecialchars($user['username']) ?></p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Tipo utente:</strong> <?= htmlspecialchars($user['tipo_utente']) ?></p>
        <p><strong>Sesso:</strong> <?= htmlspecialchars($user['sesso']) ?></p>
        <p><strong>Università:</strong> <?= htmlspecialchars($user['universita']) ?></p>
    </div>

    <div class="quiz-svolti">
        <h2>Quiz svolti</h2>
        <?php if ($quizResult && pg_num_rows($quizResult) > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Titolo Quiz</th>
                        <th>Punteggio</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($row = pg_fetch_assoc($quizResult)): ?>
                        <tr>
                            <td><?= htmlspecialchars($row['titolo']) ?></td>
                            <td><?= htmlspecialchars($row['punteggio']) ?>/100</td>
                            <td><?= date("d/m/Y H:i", strtotime($row['data_svolgimento'])) ?></td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>Non hai ancora svolto quiz.</p>
        <?php endif; ?>
    </div>

    <div class="azioni">
        <a href="homepage.php" class="btn">Dashboard</a>
        <a href="logout.php" class="btn btn-logout">Logout</a>
    </div>
</div>

</body>
</html>
