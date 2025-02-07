import errorService from '../services/error_service.js';
import messageService from '../services/message_service.js';
import authService from '../services/auth_service.js'; 
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


    async setUpForgotYourPasswordSendButton(emailInputId, sendButtonId) {
        const emailInput = document.getElementById(emailInputId);
        const sendButton = document.getElementById(sendButtonId);

        sendButton.addEventListener('click', async function(e) {
            e.preventDefault();

            await authService.generateAndSendResetPasswordLink(emailInput.value);

            window.location.href = '/login';
        }) 
    },


    async changePassword(newPasswordInputId, confirmNewPasswordInputId, confirmButtonId) {
        const newPasswordInput = document.getElementById(newPasswordInputId);
        const confirmNewPasswordInput = document.getElementById(confirmNewPasswordInputId);
        const confirmButton = document.getElementById(confirmButtonId);
        const passwordResetToken = window.location.pathname.split('/').pop();

        confirmButton.addEventListener('click', async function(e) {
            e.preventDefault();

            try {
                const response = await axios.post(appUrl + '/api/change-password', {
                    newPassword: newPasswordInput.value,
                    confirmNewPassword: confirmNewPasswordInput.value,
                    passwordResetToken: passwordResetToken,
                });

                window.location.href = '/login';
            }
            catch(error) {
                errorService.handleError(error);
            }
        });
    },


    async setUpMyAccountPageChangePassword(EmailTextId, changePasswordButtonId) {
        const emailText = document.getElementById(EmailTextId);
        const changePasswordButton = document.getElementById(changePasswordButtonId);

        changePasswordButton.addEventListener('click', async function(e) {
            e.preventDefault();

            await authService.generateAndSendResetPasswordLink(emailText.textContent);

            messageService.displayMessage(i18next.t('my_account_change_password.email_instructions_sent'), 'message-container-placeholder');
        })
    }
}


export default authModule;