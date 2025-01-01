import { addNewBuildComponent } from "../modules/builder_module";

const addBuyLinkButton = document.getElementById('add-buy-link-button');

addBuyLinkButton.addEventListener('click', function(e) {
    e.preventDefault();

    addNewBuildComponent('buy-links-container', 'add-buy-link-button');
});