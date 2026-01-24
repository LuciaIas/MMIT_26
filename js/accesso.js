const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const buttons = document.querySelectorAll('.form-switch button');

// Toggle Login / Registrazione
buttons.forEach(btn => {
    btn.addEventListener('click', () => {
        buttons.forEach(b => b.classList.remove('active'));
        btn.classList.add('active');

        if (btn.dataset.form === 'login') {
            loginForm.classList.add('form-active');
            registerForm.classList.remove('form-active');
        } else {
            loginForm.classList.remove('form-active');
            registerForm.classList.add('form-active');
        }
    });
});

// Toggle Password
document.querySelectorAll('.toggle-password').forEach(span => {
    span.addEventListener('click', () => {
        const targetId = span.dataset.target;
        const input = document.getElementById(targetId);
        input.type = input.type === 'password' ? 'text' : 'password';
    });
});

// Validazione semplice
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', e => {
        let ok = true;

        form.querySelectorAll('input').forEach(input => {
            if(input.type !== 'checkbox' && input.value.trim() === ''){
                input.style.borderColor = 'red';
                ok = false;
            } else {
                input.style.borderColor = '#cbd5e1';
            }
        });

        // Controllo password conferma
        if(form.id === 'registerForm'){
            const pass = document.getElementById('regPassword').value;
            const conf = document.getElementById('regPasswordConf').value;
            if(pass !== conf){
                document.getElementById('regPasswordConf').style.borderColor = 'red';
                ok = false;
            }
        }

        if(!ok) e.preventDefault();
    });
});
