import { register } from '../modules/auth_module';


const registerForm = document.getElementById('register-form');


registerForm.addEventListener('submit', function(e) {
    e.preventDefault();

    register('username', 'email', 'password', 'confirm-password');
});