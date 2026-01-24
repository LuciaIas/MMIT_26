document.querySelectorAll('.switch-form').forEach(link => {
    link.addEventListener('click', () => {
        document.getElementById('loginForm').style.display =
            link.dataset.form === 'login' ? 'flex' : 'none';

        document.getElementById('registerForm').style.display =
            link.dataset.form === 'register' ? 'flex' : 'none';
    });
});

// Validazione base
document.querySelectorAll('form').forEach(form => {
    form.addEventListener('submit', e => {
        let ok = true;
        form.querySelectorAll('input').forEach(input => {
            if (input.value.trim() === '') {
                ok = false;
                input.style.borderColor = 'red';
            } else {
                input.style.borderColor = '#cbd5e1';
            }
        });
        if (!ok) e.preventDefault();
    });
});
