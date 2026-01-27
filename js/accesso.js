document.addEventListener('DOMContentLoaded', () => {

    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const buttons = document.querySelectorAll('.form-switch button');
    const sideTitle = document.getElementById('sideTitle');
    const sideText = document.getElementById('sideText');
    const registerBtn = document.getElementById('registerBtn');
    const uniSelect = document.getElementById('universitaSelect');

    // ===== FUNZIONI VISUALIZZAZIONE FORM =====
    function showLogin() {
        buttons[0].classList.add('active');
        buttons[1].classList.remove('active');
        loginForm.classList.add('form-active');
        registerForm.classList.remove('form-active');
        sideTitle.textContent = "Bentornato, felice di rivederti!";
        sideText.textContent = "Ogni accesso è un passo verso la conoscenza!";
    }

    function showRegister() {
        buttons[1].classList.add('active');
        buttons[0].classList.remove('active');
        registerForm.classList.add('form-active');
        loginForm.classList.remove('form-active');
        sideTitle.textContent = "Benvenuto, felice di accoglierti!";
        sideText.textContent = "Esercitazione? Soddisfazione ... unisciti a noi!";
    }

    // ===== EVENTI BOTTONE =====
    buttons[0].addEventListener('click', showLogin);
    buttons[1].addEventListener('click', showRegister);

    // ===== MOSTRA IL FORM CORRETTO ALL'APERTURA =====
    function apriFormCorretta() {
        // 1. Se c'è hash #register
        if (window.location.hash === "#register") {
            showRegister();
        }
        // 2. Altrimenti se PHP ha impostato apriRegistrazione
        else if (typeof window.apriRegistrazione !== 'undefined' && window.apriRegistrazione === true) {
            showRegister();
        }
        // 3. Altrimenti apri login
        else {
            showLogin();
        }
    }

    apriFormCorretta();

    // ===== MOSTRA CARATTERI PASSWORD =====
    document.querySelectorAll('.show-pass input').forEach(check => {
        check.addEventListener('change', () => {
            const targets = check.dataset.target.split(',');
            targets.forEach(id => {
                const input = document.getElementById(id);
                if (input) input.type = check.checked ? 'text' : 'password';
            });
        });
    });

    // ===== BOTTONE REGISTRATI ATTIVO SOLO SE CAMPi COMPILATI =====
    registerForm.addEventListener('input', () => {
        const email = registerForm.querySelector('[name="email_reg"]').value.trim();
        const username = registerForm.querySelector('[name="username_reg"]').value.trim();
        const password = registerForm.querySelector('[name="password_reg"]').value.trim();
        const passwordConf = registerForm.querySelector('[name="password_conf"]').value.trim();
        const sesso = registerForm.querySelector('[name="sesso"]:checked');
        const universita = uniSelect.value;

        const ok = email && username && password && passwordConf && sesso && universita && universita !== "";

        registerBtn.disabled = !ok;
    });

});
