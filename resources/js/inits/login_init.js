import authModule from '../modules/auth_module.js';


const loginForm = document.getElementById('login-form');


loginForm.addEventListener('submit', function(e) {
    e.preventDefault();

    authModule.login('email', 'password');
});