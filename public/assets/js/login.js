var formAnim = {
    $form: document.getElementById('form'),
    animClasses: ['face-up-left', 'face-up-right', 'face-down-left', 'face-down-right', 'form-complete', 'form-error'],

    resetClasses: function() {
        this.animClasses.forEach((c) => {
            this.$form.classList.remove(c);
        });
    },

    faceDirection: function(d) {
        this.resetClasses();
        if (d >= 0 && d < this.animClasses.length) {
            this.$form.classList.add(this.animClasses[d]);
        }
    },

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
    focused = false,
    completed = false;

$input.forEach(function(input) {
    input.addEventListener('focus', function() {
        focused = true;
        formAnim.faceDirection(completed ? 1 : 0);
    });

    input.addEventListener('blur', function() {
        formAnim.resetClasses();
    });

    input.addEventListener('input', function() {
        completed = Array.from($input).every(input => input.value !== '');
        formAnim.faceDirection(completed ? 1 : 0);
    });
});

$submit.addEventListener('click', function(e) {
    e.preventDefault();

    if (completed) {
        formAnim.resetClasses();
        submitForm();
    } else {
        formAnim.showAndMoveEmoji('Inputs Required');
        formAnim.faceDirection(5);
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
            formAnim.faceDirection(5);
        } else if (data.status === 'success') {
            window.location.href = 'dashboard';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        formAnim.showAndMoveEmoji('An error occurred. Please try again.');
        formAnim.faceDirection(5);
    });
}


setTimeout(function() {
    if (!focused) {
        document.querySelector('#email').focus();
    }
}, 2000);
