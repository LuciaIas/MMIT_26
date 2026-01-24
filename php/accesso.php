<?php
session_start();
include __DIR__ . '/db.php';

// messaggi di errore/successo
$messaggio = "";
$tipo_messaggio = ""; // "error" o "success"

// LOGIN
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username != "" && $password != "") {
        $query = "SELECT * FROM utenti WHERE username = $1";
        $result = pg_query_params($conn, $query, array($username));
        $user = pg_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['tipo_utente'] = $user['tipo_utente'];
            $messaggio = "Login effettuato con successo!";
            $tipo_messaggio = "success";
        } else {
            $messaggio = "Username o password errati.";
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
    $password = trim($_POST['password_reg']);
    $email = trim($_POST['email_reg']);

    if ($username && $password && $email) {
        $check = pg_query_params($conn, "SELECT * FROM utenti WHERE username = $1", array($username));
        if (pg_num_rows($check) > 0) {
            $messaggio = "Username già esistente.";
            $tipo_messaggio = "error";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = pg_query_params($conn, 
                "INSERT INTO utenti (username, password, email, tipo_utente) VALUES ($1,$2,$3,'studente')",
                array($username, $hash, $email)
            );
            if ($insert) {
                $messaggio = "Registrazione avvenuta con successo! Ora puoi fare il login.";
                $tipo_messaggio = "success";
            }
        }
    } else {
        $messaggio = "Compila tutti i campi del form di registrazione.";
        $tipo_messaggio = "error";
    }
}

// LOGOUT integrato
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: accesso.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accesso Tecnologie Web</title>
    <link rel="stylesheet" href="css/accesso.css">
</head>
<body>

<header>
    <h1>Tecnologie Web</h1>
</header>

<main>
    <div class="login-container">

        <h2 id="titolo-form">Login / Registrazione</h2>

        <?php if($messaggio): ?>
            <div class="message <?php echo $tipo_messaggio; ?>"><?php echo $messaggio; ?></div>
        <?php endif; ?>

        <!-- LOGIN FORM -->
        <form id="loginForm" method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" required>
            </div>
            <button type="submit" name="login">Accedi</button>
            <a href="#" class="switch-form" data-form="register">Non hai un account? Registrati</a>
        </form>

        <!-- REGISTRAZIONE FORM -->
        <form id="registerForm" method="POST" style="display:none;">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username_reg" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email_reg" required>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password_reg" required>
            </div>
            <button type="submit" name="register">Registrati</button>
            <a href="#" class="switch-form" data-form="login">Hai già un account? Accedi</a>
        </form>

        <?php if(isset($_SESSION['username'])): ?>
            <div class="logout">
                Sei loggato come <b><?php echo $_SESSION['username']; ?></b>
                <a href="accesso.php?logout=1">Logout</a>
            </div>
        <?php endif; ?>

    </div>
</main>

<script src="js/accesso.js"></script>
</body>
</html>
