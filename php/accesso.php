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

    if ($username && $email && $password && $password_conf) {
        if ($password !== $password_conf) {
            $messaggio = "Le password non coincidono.";
            $tipo_messaggio = "error";
        } else {
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
        }
    } else {
        $messaggio = "Tutti i campi sono obbligatori.";
        $tipo_messaggio = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Accesso – Portale Tecnologie Web</title>
<link rel="stylesheet" href="../css/accesso.css">

<!-- Favicon: icona in alto nella scheda del browser -->
<link rel="icon" type="image/png" href="../immagini/iconcinalogin.jpg">
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
            <input type="text" name="username" placeholder="Username" value="<?= $_POST['username'] ?? '' ?>" required>
            <div class="password-wrapper">
                <input type="password" name="password" placeholder="Password" id="loginPassword">
                <span class="toggle-password" data-target="loginPassword">&#128065;</span>
            </div>
            <label class="remember-me">
                <input type="checkbox" name="remember">
                <span>Remember Me</span>
            </label>
            <div class="extra-options">
                <a href="#">Password dimenticata?</a>
            </div>
            <button name="login">Accedi</button>
        </form>

        <!-- REGISTRAZIONE -->
        <form id="registerForm" method="post">
            <input type="email" name="email_reg" placeholder="Email" value="<?= $_POST['email_reg'] ?? '' ?>" required>
            <input type="text" name="username_reg" placeholder="Username" value="<?= $_POST['username_reg'] ?? '' ?>" required>
            <div class="password-wrapper">
                <input type="password" name="password_reg" placeholder="Password" id="regPassword">
                <span class="toggle-password" data-target="regPassword">&#128065;</span>
            </div>
            <div class="password-wrapper">
                <input type="password" name="password_conf" placeholder="Conferma Password" id="regPasswordConf">
                <span class="toggle-password" data-target="regPasswordConf">&#128065;</span>
            </div>
            <button name="register">Registrati</button>
        </form>

    </div>

    <!-- RIGHT PANEL -->
    <div class="side-panel">
        <h1 id="sideTitle">Benvenuto amico di nuovo qui!</h1>
        <p id="sideText">Pronto a fare click nel nostro mondo di quiz tipo così...</p>
    </div>

</div>

<script src="../js/accesso.js"></script>

</body>
</html>
