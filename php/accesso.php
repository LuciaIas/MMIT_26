<?php 
session_start();
include __DIR__ . '/db.php';

//Scelta del form da aprire (default login)
$apriRegistrazione = false;

if (isset($_GET['form']) && $_GET['form'] === 'register') {
    $apriRegistrazione = true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['register'])) {
        $apriRegistrazione = true;  // Mantieni registrazione aperta se ci sono errori
    } elseif (isset($_POST['login'])) {
        $apriRegistrazione = false; // Mantieni login aperto se ci sono errori
    }
}

//Variabili per msg di errore/successo
$messaggio = "";
$tipo_messaggio = "";

//Variabili sticky
$email_sticky = htmlspecialchars($_POST['email_reg'] ?? '');
$username_sticky = htmlspecialchars($_POST['username_reg'] ?? '');
$sesso_sticky = $_POST['sesso'] ?? '';
$universita_sticky = $_POST['universita'] ?? '';
$username_login_sticky = htmlspecialchars($_POST['username'] ?? '');

//LOGIN
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username && $password) {
        $query = "SELECT * FROM utenti WHERE username=$1";
        $result = pg_query_params($conn, $query, [$username]);

        if (!$result) {
            die("Errore nella query: " . pg_last_error());
        }

        $user = pg_fetch_assoc($result);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['username'] = $user['username'];
            header("Location: profilo.php");
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

//REGISTRAZIONE
if (isset($_POST['register'])) {
    $errore = false;
    $sesso = $_POST['sesso'] ?? '';
    $username = trim($_POST['username_reg']);
    $email = trim($_POST['email_reg']);
    $password = trim($_POST['password_reg']);
    $password_conf = trim($_POST['password_conf']);
    $universita = $_POST['universita'] ?? '';

    if (!$sesso || !$username || !$email || !$password || !$password_conf || !$universita) {
        $messaggio = "Compila tutti i campi obbligatori.";
        $errore = true;
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $messaggio = "Email non valida. Formato corretto: nome@esempio.com";
        $errore = true;
    } elseif (strlen($username) < 3) {
        $messaggio = "Lo username deve contenere almeno 3 caratteri.";
        $errore = true;
    } elseif (strlen($password) < 6) {
        $messaggio = "La password deve contenere almeno 6 caratteri.";
        $errore = true;
    } elseif ($password !== $password_conf) {
        $messaggio = "Le password non coincidono.";
        $errore = true;
    }

    if (!$errore) {
        $check = pg_query_params(
            $conn,
            "SELECT 1 FROM utenti WHERE username=$1",
            [$username]
        );

        if (pg_num_rows($check) > 0) {
            $messaggio = "Nome utente già esistente.";
            $tipo_messaggio = "error";
        } else {
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $insert = pg_query_params(
                $conn,
                "INSERT INTO utenti (username,email,password,tipo_utente,sesso,universita)
                 VALUES ($1,$2,$3,'studente',$4,$5)",
                [$username, $email, $hash, $sesso, $universita]
            );

            if ($insert) {
                $_SESSION['username'] = $username;
                header("Location: profilo.php");
                exit;
            } else {
                $messaggio = "Errore durante la registrazione.";
                $tipo_messaggio = "error";
            }
        }
    } else {
        $tipo_messaggio = "error";
        $apriRegistrazione = true;
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<meta name="author" content="gruppoMMIT26"/>
<meta name="description" content="Pagina di accesso"/>
<title>Accesso</title>
<link rel="stylesheet" href="../css/accesso?v=5.css" type="text/css">
<link rel="icon" href="../immagini/lucchetto.ico" type="image/x-icon">
</head>

<body>
<script>
window.apriRegistrazione = <?php echo $apriRegistrazione ? 'true' : 'false'; ?>;
</script>

<div class="container-login">
<div class="form-container">
<div class="avatar">
    <img src="../immagini/iconauser.png" alt="Avatar studenti" >
</div>
<br>
<h2>Accesso al Portale</h2>
<br>
<?php if ($messaggio): ?>
<div class="message <?= $tipo_messaggio ?>"><?= $messaggio ?></div>
<?php endif; ?>

<div class="form-switch">
    <button data-form="login" class="active">Login</button>
    <button data-form="register">Registrazione</button>
</div>
<br>

<!-- FORM LOGIN -->
<form id="loginForm" method="post" class="form-active">
  <input type="text" name="username" placeholder="Nome utente"
       value="<?= $username_login_sticky ?>" required autofocus>
    <input autofocus type="password" name="password" placeholder="Password" id="loginPassword">
    <label class="show-pass">
        <input type="checkbox" data-target="loginPassword"> Mostra caratteri
    </label>
    <button name="login">Accedi</button>
    <button type="button" class="btn-back" onclick="window.location.href='homepage.php'">Indietro</button>
</form>

<!-- FORM REGISTRAZIONE -->
<form id="registerForm" method="post">
    <div class="radio-group">
        <span class="radio-label">Sesso:</span>
        <div class="radio-options">
            <label>
                <input type="radio" name="sesso" value="M"
                    <?= ($sesso_sticky === 'M') ? 'checked' : '' ?> required>
                Maschio
            </label>
            <label>
                <input type="radio" name="sesso" value="F"
                    <?= ($sesso_sticky === 'F') ? 'checked' : '' ?>>
                Femmina
            </label>
        </div>
    </div>

    <input maxlength="200" autofocus type="email" name="email_reg" placeholder="nome@esempio.com"
           value="<?= $email_sticky ?>" required>

    <input maxlength="30" type="text" name="username_reg" placeholder="Nome utente"
           value="<?= $username_sticky ?>" required>

    <input maxlength="64" type="password" name="password_reg" placeholder="Password (min. 6 caratteri)" id="regPassword" required>
    <input maxlength="64" type="password" name="password_conf" placeholder="Conferma password" id="regPasswordConf" required>

    <label class="show-pass">
        <input type="checkbox" data-target="regPassword,regPasswordConf"> Mostra caratteri
    </label>

    <select name="universita" id="universitaSelect" required>
        <option value="">Seleziona università</option>
        <?php
        $universita_lista = [
            "Università degli Studi di Salerno",
            "Università Federico II",
            "Università di Bologna",
            "Politecnico di Milano",
            "Altro"
        ];
        foreach ($universita_lista as $u) {
            $sel = ($universita_sticky === $u) ? 'selected' : '';
            echo "<option value=\"$u\" $sel>$u</option>";
        }
        ?>
    </select>

    <button name="register" id="registerBtn" disabled>Registrati</button>
    <button type="button" class="btn-back" onclick="window.location.href='homepage.php'">Indietro</button>
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
