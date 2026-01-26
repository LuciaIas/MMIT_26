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
?>
<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Profilo</title>
<link rel="stylesheet" href="../css/profilo.css">
</head>

<body>

<div class="container-profilo">
    <h1>Ciao <?= htmlspecialchars($user['username']) ?> 👋</h1>

    <div class="info-personali">
        <p><strong>Nome utente:</strong> <?= htmlspecialchars($user['username']) ?> </p>
        <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>
        <p><strong>Tipo:</strong> <?= htmlspecialchars($user['tipo_utente']) ?></p>
        <p><strong>Sesso:</strong> <?= htmlspecialchars($user['sesso']) ?></p>
        <p><strong>Università:</strong> <?= htmlspecialchars($user['universita']) ?></p>
    </div>

    <div class="azioni">
        <a href="homepage.php" class="btn">Home</a>
        <a href="glossario.php" class="btn">Glossario</a>

        <form method="post" style="display:inline;">
            <button type="submit" name="logout" class="btn btn-logout">Logout</button>
        </form>
    </div>
</div>

</body>
</html>
