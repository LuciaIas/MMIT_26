<?php
session_start();
include __DIR__ . '/db.php';

$messaggio = "";
$tipo_messaggio = "";

// LOGIN
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        $query = "SELECT * FROM utenti WHERE username = $1";
        $result = pg_query_params($conn, $query, [$username]);
        $user = pg_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['tipo_utente'] = $user['tipo_utente'];
            $messaggio = "Login effettuato con successo!";
            $tipo_messaggio = "success";
        } else {
            $messaggio = "Credenziali non valide.";
            $tipo_messaggio = "error";
        }
    } else {
        $messaggio = "Compila tutti i campi.";
        $tipo_messaggio = "error";
    }
}

// REGISTRAZIONE
if (isset($_POST['register'])) {
    $username = trim($_POST['username_reg']);
    $email = trim($_POST['email_reg']);
    $password = trim($_POST['password_reg']);

    if ($username && $email && $password) {
        $check = pg_query_params($conn, "SELECT 1 FROM utenti WHERE username=$1", [$username]);

        if (pg_num_rows($check) > 0) {
            $messaggio = "Username già esistente.";
            $tipo_messaggio = "error";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            pg_query_params(
                $conn,
                "INSERT INTO utenti (username,email,password,tipo_utente) VALUES ($1,$2,$3,'studente')",
                [$username, $email, $hash]
            );
            $messaggio = "Registrazione completata. Ora puoi accedere.";
            $tipo_messaggio = "success";
        }
    } else {
        $messaggio = "Tutti i campi sono obbligatori.";
        $tipo_messaggio = "error";
    }
}

// LOGOUT
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: accesso.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accesso – Tecnologie Web</title>
    <link rel="stylesheet" href="css/accesso.css">
</head>
<body>

<main class="card">
    <h1>Tecnologie Web</h1>

    <?php if ($messaggio): ?>
        <div class="message <?= $tipo_messaggio ?>"><?= $messaggio ?></div>
    <?php endif; ?>

    <?php if (!isset($_SESSION['username'])): ?>

    <!-- LOGIN -->
    <form id="loginForm" method="post">
        <input type="text" name="username" placeholder="Username" value="<?= $_POST['username'] ?? '' ?>">
        <input type="password" name="password" placeholder="Password">
        <button name="login">Accedi</button>
        <p class="switch-form" data-form="register">Non hai un account? Registrati</p>
    </form>

    <!-- REGISTRAZIONE -->
    <form id="registerForm" method="post" style="display:none">
        <input type="text" name="username_reg" placeholder="Username" value="<?= $_POST['username_reg'] ?? '' ?>">
        <input type="email" name="email_reg" placeholder="Email" value="<?= $_POST['email_reg'] ?? '' ?>">
        <input type="password" name="password_reg" placeholder="Password">
        <button name="register">Registrati</button>
        <p class="switch-form" data-form="login">Hai già un account? Accedi</p>
    </form>

    <?php else: ?>
        <div class="logout">
            Sei loggato come <b><?= $_SESSION['username'] ?></b><br>
            <a href="?logout=1">Logout</a>
        </div>
    <?php endif; ?>

</main>

<script src="js/accesso.js"></script>
</body>
</html>
