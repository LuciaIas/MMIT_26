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
            sideTitle.textContent = "Benvenuto amico di nuovo qui!";
            sideText.textContent = "Pronto a fare click nel nostro mondo di quiz tipo così...";
        } else {
            loginForm.classList.remove('form-active');
            registerForm.classList.add('form-active');
            sideTitle.textContent = "Siamo pronti a darti il benvenuto e farti entrare nella nostra community";
            sideText.textContent = "Più registrazioni, più esercitazioni, più soddisfazioni! Unisciti a noi!";
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
