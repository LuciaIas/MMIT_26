document.addEventListener('DOMContentLoaded', () => {

    /* ===== ELEMENTI ===== */
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');

    const switchButtons = document.querySelectorAll('.form-switch button');

    const sideTitle = document.getElementById('sideTitle');
    const sideText = document.getElementById('sideText');

    const registerBtn = document.getElementById('registerBtn');

    /* ===== FUNZIONI ===== */

    function showLogin() {
        switchButtons.forEach(b => b.classList.remove('active'));
        switchButtons[0].classList.add('active');

        loginForm.classList.add('form-active');
        registerForm.classList.remove('form-active');

        sideTitle.textContent = "Bentornato!";
        sideText.textContent = "Accedi per continuare il tuo percorso di apprendimento.";
    }

    function showRegister() {
        switchButtons.forEach(b => b.classList.remove('active'));
        switchButtons[1].classList.add('active');

        loginForm.classList.remove('form-active');
        registerForm.classList.add('form-active');

        sideTitle.textContent = "Benvenuto amico, felice di accoglierti!";
        sideText.textContent = "Più esercitazioni, più soddisfazioni... unisciti a noi!";
    }

    /* ===== SWITCH MANUALE ===== */
    switchButtons[0].addEventListener('click', showLogin);
    switchButtons[1].addEventListener('click', showRegister);

    /* ===== CONTROLLO URL (HOMEPAGE → REGISTRAZIONE) ===== */
    const params = new URLSearchParams(window.location.search);

    if (params.get('register') === '1') {
        showRegister();
    } else {
        showLogin();
    }

    /* ===== TOGGLE PASSWORD ===== */
    document.querySelectorAll('.toggle-password').forEach(icon => {
        icon.addEventListener('click', () => {
            const input = document.getElementById(icon.dataset.target);
            input.type = input.type === 'password' ? 'text' : 'password';
        });
    });

    /* ===== ABILITAZIONE BOTTONE REGISTRAZIONE ===== */
    const requiredFields = [
        'email_reg',
        'username_reg',
        'password_reg',
        'password_conf',
        'sesso'
    ];

    registerForm.addEventListener('input', () => {
        let allFilled = requiredFields.every(name => {
            const el = registerForm.querySelector(`[name="${name}"]`);
            if (!el) return false;

            if (el.type === 'radio') {
                return [...registerForm.querySelectorAll(`[name="${name}"]`)]
                    .some(r => r.checked);
            }

            return el.value.trim() !== '';
        });

        registerBtn.disabled = !allFilled;
    });

});
