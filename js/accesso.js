// ===== SWITCH LOGIN / REGISTRAZIONE =====
document.querySelectorAll('.switch-form').forEach(link => {
    link.addEventListener('click', function(e) {
        e.preventDefault();
        const formToShow = this.dataset.form; // "login" o "register"

        if(formToShow === 'login') {
            document.getElementById('loginForm').style.display = 'flex';
            document.getElementById('registerForm').style.display = 'none';
        } else {
            document.getElementById('loginForm').style.display = 'none';
            document.getElementById('registerForm').style.display = 'flex';
        }
    });
});

// ===== VALIDAZIONE FORM LOGIN =====
const loginForm = document.getElementById('loginForm');
loginForm.addEventListener('submit', function(e) {
    let valid = true;
    const username = this.username;
    const password = this.password;

    clearErrors(loginForm);

    if(username.value.trim() === '') {
        showError(username, 'Inserisci il tuo username');
        valid = false;
    }
    if(password.value.trim() === '') {
        showError(password, 'Inserisci la password');
        valid = false;
    }

    if(!valid) e.preventDefault();
});

// ===== VALIDAZIONE FORM REGISTRAZIONE =====
const registerForm = document.getElementById('registerForm');
registerForm.addEventListener('submit', function(e) {
    let valid = true;
    const username = this.username;
    const email = this.email;
    const password = this.password;

    clearErrors(registerForm);

    if(username.value.trim() === '') {
        showError(username, 'Inserisci un username');
        valid = false;
    }
    if(email.value.trim() === '') {
        showError(email, 'Inserisci un email valida');
        valid = false;
    } else if(!validateEmail(email.value.trim())) {
        showError(email, 'Email non valida');
        valid = false;
    }
    if(password.value.trim() === '') {
        showError(password, 'Inserisci una password');
        valid = false;
    } else if(password.value.trim().length < 6) {
        showError(password, 'La password deve essere lunga almeno 6 caratteri');
        valid = false;
    }

    if(!valid) e.preventDefault();
});

// ===== FUNZIONI UTILI =====
function showError(input, message) {
    input.classList.add('input-error');
    const error = document.createElement('div');
    error.classList.add('error-message');
    error.innerText = message;
    input.parentNode.insertBefore(error, input.nextSibling);
}

function clearErrors(form) {
    form.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));
    form.querySelectorAll('.error-message').forEach(el => el.remove());
}

function validateEmail(email) {
    const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return re.test(email);
}

// ===== EFFETTI SUI CAMPi INPUT =====
document.querySelectorAll('input').forEach(input => {
    input.addEventListener('focus', () => {
        input.style.boxShadow = '0 0 5px rgba(37,117,252,0.7)';
    });
    input.addEventListener('blur', () => {
        input.style.boxShadow = 'none';
    });
});
