<!DOCTYPE html>
<html lang="it">
<head>
<meta charset="UTF-8">
<title>Accesso – Portale Tecnologie Web</title>
<link rel="stylesheet" href="../css/accesso.css">
</head>
<body>

<div class="container-login">

    <!-- FORM WRAPPER -->
    <div class="form-container">

        <div class="avatar">
            <img src="../img/avatar.jpg" alt="Avatar utente">
        </div>

        <h2>Accedi o Registrati</h2>

        <div class="form-switch">
            <button data-form="login" class="active">Login</button>
            <button data-form="register">Registrazione</button>
        </div>

        <form id="loginForm" method="post" class="form-active">

            <input type="text" name="username" placeholder="Username" required>
            <div class="password-wrapper">
                <input type="password" name="password" placeholder="Password" id="loginPassword">
                <span class="toggle-password" data-target="loginPassword">&#128065;</span>
            </div>

            <div class="extra-options">
                <label><input type="checkbox" name="remember"> Remember Me</label>
                <a href="#">Password dimenticata?</a>
            </div>

            <button name="login">Accedi</button>
        </form>

        <form id="registerForm" method="post">

            <input type="email" name="email_reg" placeholder="Email" required>
            <input type="text" name="username_reg" placeholder="Username" required>
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
        <h1>Hello, Friend!</h1>
        <p>Benvenuto! Unisciti alla nostra avventura… promettiamo più caffè e meno bug! ☕😄</p>
    </div>

</div>

<script src="../js/accesso.js"></script>
</body>
</html>
