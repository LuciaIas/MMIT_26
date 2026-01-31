document.addEventListener('DOMContentLoaded', () => {
    const loginForm = document.getElementById('loginForm');
    const registerForm = document.getElementById('registerForm');
    const buttons = document.querySelectorAll('.form-switch button');
    const sideTitle = document.getElementById('sideTitle');
    const sideText = document.getElementById('sideText');
    const registerBtn = document.getElementById('registerBtn');
    const uniSelect = document.getElementById('universitaSelect');
    const loginBtn = loginForm.querySelector('button[name="login"]');

    const showLogin = () => {
        buttons[0].classList.add('active');
        buttons[1].classList.remove('active');
        loginForm.classList.add('form-active');
        registerForm.classList.remove('form-active');
        sideTitle.textContent = "Bentornato, felice di rivederti!";
        sideText.textContent = "Ogni accesso è un passo verso la conoscenza!";
    };

    const showRegister = () => {
        buttons[1].classList.add('active');
        buttons[0].classList.remove('active');
        registerForm.classList.add('form-active');
        loginForm.classList.remove('form-active');
        sideTitle.textContent = "Benvenuto, felice di accoglierti!";
        sideText.textContent = "Esercitazione? Soddisfazione ... unisciti a noi!";
    };

    buttons[0].addEventListener('click', showLogin);
    buttons[1].addEventListener('click', showRegister);
    window.apriRegistrazione ? showRegister() : showLogin();

    document.querySelectorAll('.show-pass input').forEach(check => {
        check.addEventListener('change', () => {
            check.dataset.target.split(',').forEach(id => {
                const input = document.getElementById(id);
                if (input) input.type = check.checked ? 'text' : 'password';
            });
        });
    });

    registerForm.addEventListener('input', () => {
        const ok = ['email_reg','username_reg','password_reg','password_conf']
                    .every(name => registerForm.querySelector(`[name="${name}"]`).value.trim() !== "") &&
                   registerForm.querySelector('[name="sesso"]:checked') &&
                   uniSelect.value !== "";
        registerBtn.disabled = !ok;
    });

    loginForm.addEventListener('input', () => {
        const ok = ['username','password'].every(name => loginForm.querySelector(`[name="${name}"]`).value.trim() !== "");
        loginBtn.disabled = !ok;
    });

    registerBtn.disabled = true;
    loginBtn.disabled = true;
});
