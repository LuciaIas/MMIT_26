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
        $query = "SELECT * FROM utenti WHERE username=$1";
        $result = pg_query_params($conn, $query, [$username]);
        $user = pg_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            $_SESSION['tipo_utente'] = $user['tipo_utente'];
            header("Location: studente/home.php");
            exit;
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
    $password_conf = trim($_POST['password_conf']);
    $sesso = trim($_POST['sesso']);
    $universita = trim($_POST['universita']);

    if ($username && $email && $password && $password_conf && $sesso) {
        if ($password !== $password_conf) {
            $messaggio = "Le password non coincidono.";
            $tipo_messaggio = "error";
        } else {
            $check = pg_query_params($conn, "SELECT 1 FROM utenti WHERE username=$1", [$username]);
            if (pg_num_rows($check) > 0) {
                $messaggio = "Nome utente già esistente.";
                $tipo_messaggio = "error";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);
                pg_query_params(
                    $conn,
                    "INSERT INTO utenti (username,email,password,tipo_utente,sesso,universita) VALUES ($1,$2,$3,'studente',$4,$5)",
                    [$username, $email, $hash, $sesso, $universita]
                );
                $messaggio = "Registrazione completata. Ora puoi accedere.";
                $tipo_messaggio = "success";
            }
        }
    } else {
        $messaggio = "Tutti i campi obbligatori devono essere compilati.";
        $tipo_messaggio = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="author" content="gruppo26"/>
<meta name="description" content="Pagina di accesso"/>
<title>Accesso – Portale Tecnologie Web</title>
<link href="../css/accesso.css" rel="stylesheet" type="text/css" >
<link rel="icon" href="../immagini/iconcinalogin.jpg" type="image/png">
</head>
<body>

<div class="container-login">

    <!-- FORM SECTION -->
    <div class="form-container">

        <div class="avatar">
            <img src="../immagini/students_avatar.png" alt="Avatar Studenti">
        </div>

        <h2>Accesso al Portale</h2>

        <?php if ($messaggio): ?>
            <div class="message <?= $tipo_messaggio ?>"><?= $messaggio ?></div>
        <?php endif; ?>

        <!-- TENDINA LOGIN / REGISTRAZIONE -->
        <div class="form-switch">
            <button data-form="login" class="active">Login</button>
            <button data-form="register">Registrazione</button>
        </div>

        <!-- LOGIN -->
        <form id="loginForm" method="post" class="form-active">
            <input type="text" name="username" placeholder="Nome utente" value="<?= $_POST['username'] ?? '' ?>" required>
            <div class="password-wrapper">
                <input type="password" name="password" placeholder="Password" id="loginPassword">
                <span class="toggle-password" data-target="loginPassword">&#128065;</span>
            </div>
            <label class="remember-me">
                <input type="checkbox" name="remember">
                <span class="rm-text">Remember me</span>
            </label>
            <button name="login">Accedi</button>
        </form>

      <form id="registerForm" method="post">

    <!-- SESSO -->
    <label>Sesso:</label>
    <div class="radio-group">
        <label><input type="radio" name="sesso" value="M" required> Maschio</label>
        <label><input type="radio" name="sesso" value="F" required> Femmina</label>
    </div>

    <!-- UNIVERSITÀ -->
    <label>Università:</label>
    <select name="universita">
        <option value="Università degli Studi di Salerno">Università degli Studi di Salerno</option>
        <option value="Università Federico II">Università Federico II</option>
        <option value="Università di Bologna">Università di Bologna</option>
        <option value="Other">Altro</option>
    </select>

    <!-- NOME UTENTE -->
    <input type="text"
           name="username_reg"
           placeholder="Nome utente"
           value="<?= $_POST['username_reg'] ?? '' ?>"
           required>

    <!-- EMAIL -->
    <input type="email"
           name="email_reg"
           placeholder="nome@esempio.com"
           value="<?= $_POST['email_reg'] ?? '' ?>"
           required>

    <!-- PASSWORD -->
    <div class="password-wrapper">
        <input type="password"
               name="password_reg"
               placeholder="Password"
               id="regPassword">
        <span class="toggle-password" data-target="regPassword">&#128065;</span>
    </div>

    <!-- CONFERMA PASSWORD -->
    <div class="password-wrapper">
        <input type="password"
               name="password_conf"
               placeholder="Conferma password"
               id="regPasswordConf">
        <span class="toggle-password" data-target="regPasswordConf">&#128065;</span>
    </div>

    <button name="register" id="registerBtn" disabled>Registrati</button>
</form>

    </div>

    <!-- RIGHT PANEL -->
    <div class="side-panel">
        <h1 id="sideTitle"> Bentornato amico, felice di rivederti! </h1>
        <p id="sideText"> Ogni accesso è un passo verso la conoscenza! </p>
    </div>

</div>
<script src="../js/accesso.js" type="text/javascript" ></script>
</body>
</html>
