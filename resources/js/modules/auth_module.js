import errorService from '../services/error_service.js';
import '../app.js';
import { appUrl } from '../env.js';


const authModule = {
    async register(usernameFieldId, emailFieldId, passwordFieldId, confirmPasswordFieldId, tosPrivacyPolicyCheckboxId) {
        const usernameField = document.getElementById(usernameFieldId);
        const emailField = document.getElementById(emailFieldId);
        const passwordField = document.getElementById(passwordFieldId);
        const confirmPasswordField = document.getElementById(confirmPasswordFieldId);
        const tosPrivacyPolicyCheckbox = document.getElementById(tosPrivacyPolicyCheckboxId);

        try {
            const response = await axios.post(appUrl + '/api/register', {
                username: usernameField.value,
                email: emailField.value,
                password: passwordField.value,
                confirmPassword: confirmPasswordField.value,
                tosPrivacyPolicyCheck: tosPrivacyPolicyCheckbox.checked,
            }); 

            window.location.href = '/';
        }
        catch(error) {
            errorService.handleError(error);
        }
    },


    async login(emailFieldId, passwordFieldId) {
        const emailField = document.getElementById(emailFieldId);
        const passwordField = document.getElementById(passwordFieldId);

        try {
            const response = await axios.post(appUrl + '/api/login', {
                email: emailField.value,
                password: passwordField.value,
            });

            window.location.href = '/';
        }
        catch(error) {
            errorService.handleError(error);
        }
    },
}


export default authModule;