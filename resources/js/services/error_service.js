const errorService = {
    displayError(errorMessage, errorContainerWidth, containerToAttachId) {
        const containerToAttach = document.getElementById(containerToAttachId);
        const existingErrorContainer = document.getElementById('error-container');
        const existingMessageContainer = document.getElementById('message-container');

        if(existingErrorContainer) {
            existingErrorContainer.remove;
        }

        if(existingMessageContainer) {
            existingMessageContainer.remove();
        }

        let errorContainer = document.createElement('div');
        errorContainer.classList.add('h-fc', 'error-container', 'mx-auto', 'mt-4');
        errorContainer.id = 'error-container';
        errorContainer.style.width = errorContainerWidth;

        let errorText = document.createElement('p');
        errorText.innerHTML = errorMessage;
        errorText.classList.add('mb-0px');

        errorContainer.appendChild(errorText);
        containerToAttach.appendChild(errorContainer);
    },
    handleError(error) {
        if(error.response && error.response.data && error.response.data.errors) {
            let finalErrorMessage = '';

            for(const errorField in error.response.data.errors) {
                error.response.data.errors[errorField].forEach(errorMessage => {
                    if(finalErrorMessage == "") {
                        finalErrorMessage = finalErrorMessage + errorMessage;
                    }
                    else {
                        finalErrorMessage = finalErrorMessage + '<br>' + errorMessage;
                    }
                })
            }

            this.displayError(finalErrorMessage, '100%', 'error-container-placeholder');
        }
        else if(error.response) {
            this.displayError(i18next.t('errors.unexpected_error'), '100%', 'error-container-placeholder');
        }
        else if(error.request) {
            this.displayError(i18next.t('errors.error_processing_request'), '100%', 'error-container-placeholder');
        }
        else {
            this.displayError(i18next.t('errors.unexpected_error'), '100%', 'error-container-placeholder');
        }
    }
}

export default errorService;