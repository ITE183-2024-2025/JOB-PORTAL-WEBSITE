var formAnim = {
    $form: document.getElementById('loginForm'),

    showAndMoveEmoji: function(message) {
        const emojiElement = document.getElementById('emoji');
        if (emojiElement) {
            emojiElement.innerHTML = '⛔🛡️ ' + message + ' 🛡️⛔';
            emojiElement.style.display = 'block';
            emojiElement.classList.add('shake');
            setTimeout(() => {
                emojiElement.style.display = 'none';
                emojiElement.classList.remove('shake');
            }, 2500);
        }
    }
};

var $input = document.querySelectorAll('#email, #password'),
    $submit = document.getElementById('submit'),
    completed = false;

$input.forEach(function(input) {
    input.addEventListener('input', function() {
        completed = Array.from($input).every(input => input.value !== '');
    });
});

$submit.addEventListener('click', function(e) {
    e.preventDefault();

    if (completed) {
        submitForm();
    } else {
        formAnim.showAndMoveEmoji('Inputs Required');
    }
});

function submitForm() {
    const formData = new FormData(document.getElementById('loginForm'));

    fetch('/login', {
        method: 'POST',
        headers: { 'X-Requested-With': 'XMLHttpRequest' },
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if (data.status === 'error') {
            formAnim.showAndMoveEmoji(data.message);
        } else if (data.status === 'success') {
            // Redirect to dashboard.html after successful login
            window.location.href = 'dashboard';
        }
    })
    .catch(() => {
        formAnim.showAndMoveEmoji('An error occurred. Please try again.');
    });
}

// Toggle between the Sign In and Sign Up forms
const container = document.getElementById('container');
const registerBtn = document.getElementById('register');
const loginBtn = document.getElementById('login');

registerBtn.addEventListener('click', () => {
    container.classList.add("active");
});

loginBtn.addEventListener('click', () => {
    container.classList.remove("active");
});
