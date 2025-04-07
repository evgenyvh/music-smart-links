document.addEventListener('DOMContentLoaded', function() {
    const registerForm = document.getElementById('registerForm');
    
    if (registerForm) {
        // Form fields
        const emailInput = document.getElementById('email');
        const nameInput = document.getElementById('name');
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirm');
        const termsCheckbox = document.getElementById('terms');
        const submitButton = registerForm.querySelector('button[type="submit"]');
        
        // Error messages container
        let errorContainer = document.getElementById('error-container');
        if (!errorContainer) {
            errorContainer = document.createElement('div');
            errorContainer.id = 'error-container';
            errorContainer.className = 'alert alert-danger d-none';
            registerForm.insertBefore(errorContainer, registerForm.firstChild);
        }
        
        // Function to show error message
        const showError = (message) => {
            errorContainer.textContent = message;
            errorContainer.classList.remove('d-none');
        };
        
        // Function to hide error message
        const hideError = () => {
            errorContainer.textContent = '';
            errorContainer.classList.add('d-none');
        };
        
        // Simple email validation
        const validateEmail = (email) => {
            const re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
            return re.test(String(email).toLowerCase());
        };
        
        // Events for real-time validation
        if (emailInput) {
            emailInput.addEventListener('blur', function() {
                if (!validateEmail(this.value.trim())) {
                    this.classList.add('is-invalid');
                    showError('Please enter a valid email address');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    hideError();
                }
            });
        }
        
        if (nameInput) {
            nameInput.addEventListener('blur', function() {
                if (this.value.trim() === '') {
                    this.classList.add('is-invalid');
                    showError('Please enter your name');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    hideError();
                }
            });
        }
        
        if (passwordInput) {
            passwordInput.addEventListener('blur', function() {
                if (this.value.length < 8) {
                    this.classList.add('is-invalid');
                    showError('Password must be at least 8 characters long');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    hideError();
                }
            });
        }
        
        if (passwordConfirmInput && passwordInput) {
            passwordConfirmInput.addEventListener('blur', function() {
                if (this.value !== passwordInput.value) {
                    this.classList.add('is-invalid');
                    showError('Passwords do not match');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                    hideError();
                }
            });
        }
        
        // Form submission
        registerForm.addEventListener('submit', function(e) {
            let isValid = true;
            hideError();
            
            // Validate email
            if (emailInput && !validateEmail(emailInput.value.trim())) {
                emailInput.classList.add('is-invalid');
                showError('Please enter a valid email address');
                isValid = false;
            }
            
            // Validate name
            if (nameInput && nameInput.value.trim() === '') {
                nameInput.classList.add('is-invalid');
                showError('Please enter your name');
                isValid = false;
            }
            
            // Validate password
            if (passwordInput && passwordInput.value.length < 8) {
                passwordInput.classList.add('is-invalid');
                showError('Password must be at least 8 characters long');
                isValid = false;
            }
            
            // Validate password confirmation
            if (passwordConfirmInput && passwordInput && passwordConfirmInput.value !== passwordInput.value) {
                passwordConfirmInput.classList.add('is-invalid');
                showError('Passwords do not match');
                isValid = false;
            }
            
            // Validate terms
            if (termsCheckbox && !termsCheckbox.checked) {
                showError('You must agree to the Terms of Service and Privacy Policy');
                isValid = false;
            }
            
            if (!isValid) {
                e.preventDefault();
            } else {
                // Show loading state
                if (submitButton) {
                    submitButton.disabled = true;
                    submitButton.innerHTML = '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating account...';
                }
            }
        });
    }
});