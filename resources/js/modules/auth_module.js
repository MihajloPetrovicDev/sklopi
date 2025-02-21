import errorService from '../services/error_service';
import messageService from '../services/message_service';
import authService from '../services/auth_service'; 
import '../app';
import { appUrl } from '../env';
import i18next from 'i18next';


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
        const urlParams = new URLSearchParams(window.location.search);
        const redirectTo = urlParams.get('redirect-to');

        try {
            const response = await axios.post(appUrl + '/api/login', {
                email: emailField.value,
                password: passwordField.value,
                redirectTo: redirectTo,
            });

            window.location.href = response.data.redirectTo;
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


    async setUpMyAccountPageChangePassword(emailTextId, changePasswordButtonId) {
        const emailText = document.getElementById(emailTextId);
        const changePasswordButton = document.getElementById(changePasswordButtonId);

        changePasswordButton.addEventListener('click', async function(e) {
            e.preventDefault();

            await authService.generateAndSendResetPasswordLink(emailText.textContent);

            messageService.displayMessage(i18next.t('my_account_change_password.email_instructions_sent'), 'message-container-placeholder');
        })
    },


    async setUpChangeEmailSendButton(newEmailInputId, changeEmailButtonId) {
        const newEmailInput = document.getElementById(newEmailInputId);
        const changeEmailButton = document.getElementById(changeEmailButtonId);

        changeEmailButton.addEventListener('click', async function(e) {
            try {
                const response = await axios.post(appUrl + '/api/generate-and-send-email-change-link', {
                    newEmail: newEmailInput.value,
                });

                window.location.href = '/my-account';
            }
            catch(error) {
                errorService.handleError(error);
            }
        })
    },


    async setUpChangeEmailVerificationPage() {
        const emailChangeToken = window.location.pathname.split('/').pop();

        try {
            const response = await axios.post(appUrl + '/api/change-email', {
                emailChangeToken: emailChangeToken,
            });

            messageService.displayMessage(i18next.t('change_email_verification.email_change_successful'), 'message-container-placeholder');
        }
        catch(error) {
            errorService.handleError(error);
        }
    },


    async setUpMyAccountPageChangeUsername(usernameInputId, saveUsernameButtonId) {
        const usernameInput = document.getElementById(usernameInputId);
        const saveUsernameButton = document.getElementById(saveUsernameButtonId);

        saveUsernameButton.addEventListener('click', async function(e) {
            e.preventDefault();

            try {
                const response = await axios.patch(appUrl + '/api/change-username', {
                    newUsername: usernameInput.value,
                });

                messageService.displayMessage(i18next.t('my_account_change_username.username_changed_successfully'), 'message-container-placeholder');
            }
            catch(error) {
                errorService.handleError(error);
            }
        })
    }
}


export default authModule;