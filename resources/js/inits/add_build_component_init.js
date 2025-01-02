import { showBuyLinksContainer, addNewBuildComponent, setUpDeleteBuyLinkButtons } from "../modules/builder_module";

const addBuyLinkButton = document.getElementById('add-buy-link-button');
const addBuildComponentButton = document.getElementById('add_build_component_submit_button');

setUpDeleteBuyLinkButtons('buy-link-delete-button');

addBuyLinkButton.addEventListener('click', function(e) {
    e.preventDefault();

    showBuyLinksContainer('buy-links-container', 'add-buy-link-button');
});

addBuildComponentButton.addEventListener('click', function(e) {
    e.preventDefault();

    const typeId = addBuildComponentButton.getAttribute('data-type-id');
    const buildId = addBuildComponentButton.getAttribute('data-build-id');
    const encodedBuildId = addBuildComponentButton.getAttribute('data-encoded-build-id');

    addNewBuildComponent(typeId, buildId, encodedBuildId);
})