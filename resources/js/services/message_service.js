const messageService = {
    displayMessage(message, containerToAttachId) {
        const containerToAttach = document.getElementById(containerToAttachId);
        const existingMessageContainer = document.getElementById('message-container');

        if(existingMessageContainer) {
            containerToAttach.removeChild(existingMessageContainer);
        }

        let messageContainer = document.createElement('div');
        messageContainer.classList.add('h-fc', 'w-100', 'message-container', 'mx-auto', 'mt-4');
        messageContainer.id = 'message-container';

        let messageText = document.createElement('p');
        messageText.innerHTML = message;
        messageText.classList.add('mb-0px');

        messageContainer.appendChild(messageText);
        containerToAttach.appendChild(messageContainer);
    }
}


export default messageService;