// Toggle tra Login e Registrazione
const loginForm = document.getElementById('loginForm');
const registerForm = document.getElementById('registerForm');
const buttons = document.querySelectorAll('.form-switch button');

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

// Validazione semplice
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', e => {
        let ok = true;
        form.querySelectorAll('input').forEach(input => {
            if (input.value.trim() === '') {
                input.style.borderColor = 'red';
                ok = false;
            } else {
                input.style.borderColor = '#cbd5e1';
            }
        });
        if (!ok) e.preventDefault();
    });
});
