import authModule from '../modules/auth_module';


const registerForm = document.getElementById('register-form');


registerForm.addEventListener('submit', function(e) {
    e.preventDefault();

    authModule.register('username', 'email', 'password', 'confirm-password');
});