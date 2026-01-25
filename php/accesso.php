<?php
session_start();
include __DIR__ . '/db.php';

$messaggio = "";
$tipo_messaggio = "";

/* ===== LOGIN ===== */
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        $query = "SELECT * FROM utenti WHERE username=$1";
        $result = pg_query_params($conn, $query, [$username]);
        $user = pg_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
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

/* ===== REGISTRAZIONE ===== */
if (isset($_POST['register'])) {

    $sesso = $_POST['sesso'] ?? '';
    $username = trim($_POST['username_reg']);
    $email = trim($_POST['email_reg']);
    $password = trim($_POST['password_reg']);
    $password_conf = trim($_POST['password_conf']);

    $universita = $_POST['universita'] ?? '';
    $universita_altro = trim($_POST['universita_altro'] ?? '');

    if ($universita === 'Altro' && $universita_altro !== '') {
        $universita = $universita_altro;
    }

    if ($sesso && $username && $email && $password && $password_conf) {

        if ($password !== $password_conf) {
            $messaggio = "Le password non coincidono.";
            $tipo_messaggio = "error";
        } else {
            $check = pg_query_params($conn,
                "SELECT 1 FROM utenti WHERE username=$1",
                [$username]
            );

            if (pg_num_rows($check) > 0) {
                $messaggio = "Nome utente già esistente.";
                $tipo_messaggio = "error";
            } else {
                $hash = password_hash($password, PASSWORD_DEFAULT);

                pg_query_params(
                    $conn,
                    "INSERT INTO utenti (username,email,password,tipo_utente,sesso,universita)
                     VALUES ($1,$2,$3,'studente',$4,$5)",
                    [$username, $email, $hash, $sesso, $universita]
                );

                $messaggio = "Registrazione completata. Ora puoi accedere.";
                $tipo_messaggio = "success";
            }
        }
    } else {
        $messaggio = "Compila tutti i campi obbligatori.";
        $tipo_messaggio = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Accesso</title>
<link rel="stylesheet" href="../css/accesso.css">
</head>

<body>

<div class="container-login">

<div class="form-container">

<h2>Accesso al Portale</h2>

<?php if ($messaggio): ?>
<div class="message <?= $tipo_messaggio ?>"><?= $messaggio ?></div>
<?php endif; ?>

<div class="form-switch">
    <button data-form="login" class="active">Login</button>
    <button data-form="register">Registrazione</button>
</div>

<!-- LOGIN -->
<form id="loginForm" method="post" class="form-active">
    <input type="text" name="username" placeholder="Nome utente" required>

    <div class="password-wrapper">
        <input type="password" name="password" placeholder="Password" id="loginPassword">
        <span class="toggle-password" data-target="loginPassword">Mostra caratteri</span>
    </div>

    <button name="login">Accedi</button>
</form>

<!-- REGISTRAZIONE -->
<form id="registerForm" method="post">

    <div class="radio-group">
        <span>Sesso</span>
        <label><input type="radio" name="sesso" value="M"> Maschio</label>
        <label><input type="radio" name="sesso" value="F"> Femmina</label>
    </div>

    <input type="email" name="email_reg" placeholder="nome@esempio.com">
    <input type="text" name="username_reg" placeholder="Nome utente">

    <div class="password-wrapper">
        <input type="password" name="password_reg" placeholder="Password" id="regPassword">
        <span class="toggle-password" data-target="regPassword">Mostra caratteri</span>
    </div>

    <div class="password-wrapper">
        <input type="password" name="password_conf" placeholder="Conferma password" id="regPasswordConf">
        <span class="toggle-password" data-target="regPasswordConf">Mostra caratteri</span>
    </div>

    <select name="universita" id="universitaSelect">
        <option value="">Seleziona università</option>
        <option>Università di Salerno</option>
        <option>Università Federico II</option>
        <option>Università di Bologna</option>
        <option>Politecnico di Milano</option>
        <option>Università La Sapienza</option>
        <option value="Altro">Altra università</option>
    </select>

    <textarea name="universita_altro" id="universitaAltro"
              placeholder="Scrivi il nome della tua università"
              style="display:none"></textarea>

    <button name="register" id="registerBtn" disabled>Registrati</button>
</form>

</div>

<div class="side-panel">
    <h1 id="sideTitle"></h1>
    <p id="sideText"></p>
</div>

</div>

<script src="../js/accesso.js"></script>
</body>
</html>
