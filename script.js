// Wait for the DOM to be fully loaded before executing the script
document.addEventListener("DOMContentLoaded", function() {
    // Select all input fields for focus and blur animations
    const inputs = document.querySelectorAll('.input-group input');
    
    // Add focus and blur animations on input fields
    inputs.forEach((input) => {
        input.addEventListener('focus', () => {
            // Scale the input field when focused
            input.style.transform = 'scale(1.05)';
            input.style.transition = 'transform 0.3s ease';
            input.parentElement.querySelector('i').style.color = '#007bff';  // Change icon color on focus
        });

        input.addEventListener('blur', () => {
            // Reset input scale when blurred
            input.style.transform = 'scale(1)';
            input.parentElement.querySelector('i').style.color = '#888'; // Reset icon color when unfocused
        });
    });

    // Form validation for both sign-up and login forms
    const forms = document.querySelectorAll('form');
    forms.forEach((form) => {
        form.addEventListener('submit', function(e) {
            const username = document.getElementById('username');
            const email = document.getElementById('email');
            const password = document.getElementById('password');
            let errorMessage = '';

            // Validate that no field is empty
            if (!username || !email || !password || username.value.trim() === '' || email.value.trim() === '' || password.value.trim() === '') {
                errorMessage = 'Please fill in all fields.';
                e.preventDefault(); // Prevent form submission
                alert(errorMessage);
                return;
            }

            // If validation passes, show loading on the button and disable it
            const button = form.querySelector('.btn');
            button.innerHTML = 'Loading...'; // Change button text to loading
            button.disabled = true; // Disable the submit button to prevent multiple submissions
        });
    });

    // Optional: Smooth scroll to form sections (for multi-step forms or just for smooth scrolling)
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();

            document.querySelector(this.getAttribute('href')).scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
});
