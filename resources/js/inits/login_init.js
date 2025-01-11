import { login } from '../modules/auth_module';


const loginForm = document.getElementById('login-form');


loginForm.addEventListener('submit', function(e) {
    e.preventDefault();

    login('email', 'password');
});