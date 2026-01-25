document.addEventListener('DOMContentLoaded', () => {

    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const buttons = document.querySelectorAll('.form-switch button');
    const registerBtn = document.getElementById('registerBtn');

    function showLogin() {
        buttons[0].classList.add('active');
        buttons[1].classList.remove('active');
        loginForm.classList.add('form-active');
        registerForm.classList.remove('form-active');
    }

    function showRegister() {
        buttons[1].classList.add('active');
        buttons[0].classList.remove('active');
        registerForm.classList.add('form-active');
        loginForm.classList.remove('form-active');
    }

    buttons[0].onclick = showLogin;
    buttons[1].onclick = showRegister;

    /* ===== HOMEPAGE → REGISTRAZIONE ===== */
    const params = new URLSearchParams(window.location.search);
    if (params.get('register') === '1') {
        showRegister();
    } else {
        showLogin();
    }

    /* ===== MOSTRA CARATTERI ===== */
    document.querySelectorAll('.toggle-password').forEach(el => {
        el.onclick = () => {
            const input = document.getElementById(el.dataset.target);
            input.type = input.type === 'password' ? 'text' : 'password';
        };
    });

    /* ===== UNIVERSITÀ ALTRO ===== */
    const selectUni = document.getElementById('universitaSelect');
    const altraUni = document.getElementById('universitaAltro');

    selectUni.onchange = () => {
        altraUni.style.display = selectUni.value === 'Altro' ? 'block' : 'none';
    };

    /* ===== ABILITAZIONE BOTTONE ===== */
    registerForm.addEventListener('input', () => {
        const filled =
            registerForm.querySelector('[name="email_reg"]').value &&
            registerForm.querySelector('[name="username_reg"]').value &&
            registerForm.querySelector('[name="password_reg"]').value &&
            registerForm.querySelector('[name="password_conf"]').value &&
            registerForm.querySelector('[name="sesso"]:checked');

        registerBtn.disabled = !filled;
    });

});
