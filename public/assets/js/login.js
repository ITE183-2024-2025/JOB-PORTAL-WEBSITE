if (typeof axios === 'undefined') {
    console.error('Axios is not defined. Please include axios before this script.');
}

var formAnim = {
    $form: $('#form'),
    animClasses: ['face-up-left', 'face-up-right', 'face-down-left', 'face-down-right', 'form-complete', 'form-error'],

    resetClasses: function() {
        var $form = this.$form;
        $.each(this.animClasses, function(k, c) {
            $form.removeClass(c);
        });
    },

    faceDirection: function(d) {
        this.resetClasses();
        d = parseInt(d) < this.animClasses.length ? d : -1;
        if (d >= 0) {
            this.$form.addClass(this.animClasses[d]);
        }

        if (d === 4) {
            setTimeout(function() {
                const email = $('#id').val();
                window.location.href = 'http://localhost:3000/admin/dashboard/' + encodeURIComponent(id);
            }, 1000);            
        }
    },

    showAndMoveEmoji: function() {
        const emojiElement = document.getElementById('emoji');
        if (emojiElement) {
            emojiElement.style.display = 'block'; // Make it visible
            emojiElement.classList.add('shake'); // Start shaking animation
            setTimeout(() => {
                emojiElement.style.display = 'none'; // Hide after animation
                emojiElement.classList.remove('shake'); // Stop shaking animation
            }, 2500); // Adjust based on animation duration
        }
    },

    loginUser: async function(email, password) {
		console.log('Payload:', {
			email: email,
			password: password
		});

        try {
            const response = await axios.post('http://localhost:3001/api/login', {
                email: email,
                password: password
            });
            $('#id').val(response.data.user._id);

            this.faceDirection(4); // Indicate success with animation
            completed = false;

            // Process successful login (e.g., redirect, display user info)
            setTimeout(() => {
                $submit.css('pointer-events', '');
                this.resetClasses();
            }, 2000);
        } catch (error) {
			console.log(error);

            // Handle error response
            this.showAndMoveEmoji(); // Show error animation

            setTimeout(() => {
                this.faceDirection(5); // Indicate failure with animation

                setTimeout(() => {
                    $submit.css('pointer-events', '');
                    this.resetClasses();
                }, 2000);
            }, 1000);
        }
    }
}

var $input = $('#email, #password'),
    $submit = $('#submit'),
    focused = false,
    completed = false;

$input.focus(function() {
    focused = true;
    if (completed) {
        formAnim.faceDirection(1);
    } else {
        formAnim.faceDirection(0);
    }
});

$input.blur(function() {
    formAnim.resetClasses();
});

$input.on('input paste keyup', function() {
    completed = true;
    $input.each(function() {
        if (this.value === '') {
            completed = false;
        }
    });

    if (completed) {
        formAnim.faceDirection(1);
    } else {
        formAnim.faceDirection(0);
    }
});

$submit.click(function() {
    focused = true;
    formAnim.resetClasses();

    if (completed) {
        $submit.css('pointer-events', 'none');

        // Gather the form data
        const email = $('#email').val();
        const password = $('#password').val();

        // Make an API call to the login endpoint
        formAnim.loginUser(email, password);
    } else {
        setTimeout(function() {
            formAnim.faceDirection(5); // Indicate failure with animation

            setTimeout(function() {
                formAnim.resetClasses();
            }, 2000);
        }, 1000);
    }
});

$(function() {
    setTimeout(function() {
        if (!focused) {
            $input.eq(0).focus();
        }
    }, 2000);
});