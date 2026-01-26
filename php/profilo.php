<?php
session_start();

/* ===== LOGOUT INLINE ===== */
if (isset($_POST['logout'])) {
    session_unset();
    session_destroy();
    header("Location: homepage.php");
    exit;
}

/* ===== ACCESSO ===== */
if (!isset($_SESSION['username'])) {
    header("Location: accesso.php");
    exit;
}

include __DIR__ . '/db.php';
$username = $_SESSION['username'];

/* ===== DATI UTENTE ===== */
$query = "SELECT username, email, tipo_utente, sesso, universita
          FROM utenti WHERE username=$1";
$result = pg_query_params($conn, $query, [$username]);
$user = pg_fetch_assoc($result);

/* ===== RISULTATI QUIZ ===== */
$queryRisultati = "SELECT punteggio FROM risultati_quiz WHERE username=$1";
$resRisultati = pg_query_params($conn, $queryRisultati, [$username]);

$totalePunteggio = 0;

while ($row = pg_fetch_assoc($resRisultati)) {
    $totalePunteggio += (int)$row['punteggio'];
}

/* ===== NOTE TEMPORANEE SESSION ===== */
if (isset($_POST['salva_note'])) {
    $_SESSION['note_temporanee'] = $_POST['note_temporanee'] ?? '';
}
$note = $_SESSION['note_temporanee'] ?? '';
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Profilo</title>
<link rel="stylesheet" href="../css/profilo.css">
<link rel="shrtcut icon" href="../immagini/iconauser.png" type="image/x-icon">
<style>
/* Nota personale compatta */
.note-personali {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin-bottom: 20px;
}

.note-personali textarea {
    width: 100%;
    resize: vertical;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
}

.note-personali button {
    align-self: flex-start; /* il pulsante allinea in alto a sinistra sotto la textarea */
    background: #159649;
    color: #fff;
    font-weight: bold;
    border: none;
    padding: 8px 16px;
    border-radius: 8px;
    cursor: pointer;
}

.note-personali button:hover {
    background: #12733d;
}
</style>
</head>

<body>

<div class="container-profilo">
    <h1>Ciao <?= htmlspecialchars($user['username']) ?> 👋</h1>

<div class="info-personali">
    <p><strong>Nome utente:</strong> <span><?= htmlspecialchars($user['username']) ?></span></p>
    <p><strong>Email:</strong> <span><?= htmlspecialchars($user['email']) ?></span></p>
    <p><strong>Tipo:</strong> <span><?= htmlspecialchars($user['tipo_utente']) ?></span></p>
    <p><strong>Sesso:</strong> <span><?= htmlspecialchars($user['sesso']) ?></span></p>
    <p><strong>Università:</strong> <span><?= htmlspecialchars($user['universita']) ?></span></p>
    <?php if ($totalePunteggio > 0): ?>
        <p><strong>Punteggio totale dai quiz:</strong> <span><?= $totalePunteggio ?></span></p>
    <?php else: ?>
        <p>Nessun quiz completato.</p>
    <?php endif; ?>
</div>


    <div class="note-personali">
        <form method="post">
            <label for="note_temporanee"><strong>Note personali (temporanee):</strong></label>
            <textarea name="note_temporanee" id="note_temporanee" rows="4"><?= htmlspecialchars($note) ?></textarea>
            <button type="submit" name="salva_note">Salva note</button>
        </form>
    </div>

    <div class="azioni">
        <a href="homepage.php" class="btn">Home</a>
        <a href="glossario.php" class="btn">Glossario</a>
        <a href="quiz.php" class="btn">Quiz</a>

        <form method="post" style="display:inline;">
            <button type="submit" name="logout" class="btn btn-logout">Logout</button>
        </form>
    </div>
</div>

</body>
</html>
