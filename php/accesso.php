<?php
session_start();
include __DIR__ . '/db.php';

// ----------------------------
// GESTIONE LOGOUT
// ----------------------------
if(isset($_GET['logout']) && $_GET['logout'] === 'true') {
    session_destroy();
    header("Location: accesso.php");
    exit;
}

// ----------------------------
// GESTIONE AZIONE (login/register)
// ----------------------------
$azione = isset($_GET['azione']) ? $_GET['azione'] : 'login';
$errore = "";
$successo = "";

// ----------------------------
// LOGIN
// ----------------------------
if (isset($_POST['login'])) {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    if ($username == "" || $password == "") {
        $errore = "Compila tutti i campi";
    } else {
        $query = "SELECT * FROM utenti WHERE username = $1";
        $result = pg_query_params($conn, $query, array($username));

        if (pg_num_rows($result) == 0) {
            $errore = "Utente non trovato";
        } else {
            $utente = pg_fetch_assoc($result);
            if ($utente['password'] !== $password) {
                $errore = "Password errata";
            } else {
                $_SESSION['username'] = $utente['username'];
                $_SESSION['id_utente'] = $utente['id'];
                header("Location: homepage.php"); // dopo login vai alla homepage
                exit;
            }
        }
    }
}

// ----------------------------
// REGISTRAZIONE
// ----------------------------
if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $conferma = trim($_POST['conferma']);

    if ($username == "" || $email == "" || $password == "" || $conferma == "") {
        $errore = "Compila tutti i campi";
    } elseif ($password !== $conferma) {
        $errore = "Le password non coincidono";
    } else {
        $check = "SELECT * FROM utenti WHERE username = $1 OR email = $2";
        $res = pg_query_params($conn, $check, array($username, $email));

        if (pg_num_rows($res) > 0) {
            $errore = "Utente o email già registrati";
        } else {
            $insert = "INSERT INTO utenti (username, email, password) VALUES ($1, $2, $3)";
            pg_query_params($conn, $insert, array($username, $email, $password));
            $successo = "Registrazione avvenuta con successo. Ora puoi accedere.";
            $azione = "login"; // torna al login
        }
    }
}
?>

<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <title>Accesso Tecnologie Web</title>
    <link rel="stylesheet" href="../css/accesso.css">
    <script src="../js/validazione.js" defer></script>
</head>

<body>

<header>
    <h1>Tecnologie Web</h1>
</header>

<!-- NAVBAR -->
<nav>
    <a href="homepage.php">Home</a>

    <?php if(isset($_SESSION['username'])): ?>
        <span>Benvenuto, <?php echo $_SESSION['username']; ?></span>
        <a href="accesso.php?logout=true">Logout</a>
    <?php else: ?>
        <a href="accesso.php?azione=login">Login</a>
        <a href="accesso.php?azione=register">Registrazione</a>
    <?php endif; ?>

    <a href="profilo.php">Profilo</a>
    <a href="glossario.php">Glossario</a>
    <a href="quiz.php">Quiz</a>
</nav>

<main>

<?php if ($errore != ""): ?>
    <p class="errore"><?php echo $errore; ?></p>
<?php endif; ?>

<?php if ($successo != ""): ?>
    <p class="successo"><?php echo $successo; ?></p>
<?php endif; ?>

<!-- LOGIN -->
<?php if ($azione == "login" && !isset($_SESSION['username'])): ?>
<section>
    <h2>Login</h2>
    <form method="post" onsubmit="return validaLogin();">
        <label>Username</label>
        <input type="text" name="username">

        <label>Password</label>
        <input type="password" name="password">

        <input type="submit" name="login" value="Accedi">
    </form>
</section>
<?php endif; ?>

<!-- REGISTRAZIONE -->
<?php if ($azione == "register" && !isset($_SESSION['username'])): ?>
<section>
    <h2>Registrazione</h2>
    <form method="post" onsubmit="return validaRegistrazione();">
        <label>Username</label>
        <input type="text" name="username">

        <label>Email</label>
        <input type="email" name="email">

        <label>Password</label>
        <input type="password" name="password">

        <label>Conferma Password</label>
        <input type="password" name="conferma">

        <input type="submit" name="register" value="Registrati">
    </form>
</section>
<?php endif; ?>

</main>

<footer>
    <p>Corso Tecnologie Web 2025-2026</p>
</footer>

</body>
</html>
