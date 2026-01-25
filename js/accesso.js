document.addEventListener('DOMContentLoaded', () => {

    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const buttons = document.querySelectorAll('.form-switch button');
    const sideTitle = document.getElementById('sideTitle');
    const sideText = document.getElementById('sideText');
    const registerBtn = document.getElementById('registerBtn');

    function showLogin() {
        buttons[0].classList.add('active');
        buttons[1].classList.remove('active');
        loginForm.classList.add('form-active');
        registerForm.classList.remove('form-active');

        sideTitle.textContent = "Bentornato amico, felice di rivederti!";
        sideText.textContent = "Ogni accesso è un passo verso la conoscenza!";
    }

    function showRegister() {
        buttons[1].classList.add('active');
        buttons[0].classList.remove('active');
        registerForm.classList.add('form-active');
        loginForm.classList.remove('form-active');

        sideTitle.textContent = "Benvenuto amico, felice di accoglierti!";
        sideText.textContent = "Più esercitazioni, più soddisfazioni... unisciti a noi!";
    }

    buttons[0].onclick = showLogin;
    buttons[1].onclick = showRegister;

    /* ===== HOMEPAGE → REGISTRAZIONE ===== */
    const params = new URLSearchParams(window.location.search);
    if (params.get('register') === '1') showRegister();

    /* ===== MOSTRA CARATTERI ===== */
    document.querySelectorAll('.show-pass input').forEach(check => {
        check.addEventListener('change', () => {
            const targets = check.dataset.target.split(',');
            targets.forEach(id => {
                const input = document.getElementById(id);
                if (input) input.type = check.checked ? 'text' : 'password';
            });
        });
    });

    /* ===== UNIVERSITÀ ALTRO ===== */
    const uniSelect = document.getElementById('universitaSelect');
    const uniAltro = document.getElementById('universitaAltro');

    uniSelect.addEventListener('change', () => {
        uniAltro.style.display = uniSelect.value === 'Altro' ? 'block' : 'none';
    });

    /* ===== BOTTONE REGISTRATI ===== */
    registerForm.addEventListener('input', () => {
        const ok =
            registerForm.querySelector('[name="email_reg"]').value &&
            registerForm.querySelector('[name="username_reg"]').value &&
            registerForm.querySelector('[name="password_reg"]').value &&
            registerForm.querySelector('[name="password_conf"]').value &&
            registerForm.querySelector('[name="sesso"]:checked');

        registerBtn.disabled = !ok;
    });
});
