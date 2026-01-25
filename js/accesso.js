const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const buttons = document.querySelectorAll('.form-switch button');
const sideTitle = document.getElementById('sideTitle');
const sideText = document.getElementById('sideText');

// Toggle Login / Registrazione con frasi personalizzate
buttons.forEach(btn => {
    btn.addEventListener('click', () => {
        buttons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        if (btn.dataset.form === 'login') {
            loginForm.classList.add('form-active');
            registerForm.classList.remove('form-active');
            sideTitle.textContent = "Bentornato amico, felice di rivederti!";
            sideText.textContent = "Ogni accesso è un passo verso la conoscenza!";
        } else {
            loginForm.classList.remove('form-active');
            registerForm.classList.add('form-active');
            sideTitle.textContent = "Benvenuto amico, felice di accoglierti!";
            sideText.textContent = "Più esercitazioni, più soddisfazioni... unisciti a noi!";
        }
    });
});

// Toggle password visibility
document.querySelectorAll('.toggle-password').forEach(span => {
    span.addEventListener('click', () => {
        const targetId = span.dataset.target;
        const input = document.getElementById(targetId);
        input.type = input.type === 'password' ? 'text' : 'password';
    });
});
