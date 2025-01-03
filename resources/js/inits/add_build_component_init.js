import { showNewBuyLinkContainer, addNewBuildComponent, setUpDeleteBuyLinkButtons } from "../modules/builder_module";


const addBuyLinkButton = document.getElementById('add-buy-link-button');
const addBuildComponentButton = document.getElementById('add_build_component_submit_button');
const buyLinkNewDeliveryGroupPopupWindowCancelButton = document.getElementById('add-buy-link-popup-window-cancel-button');
const buyLinkNewDeliveryGroupPopupWindowCreateButton = document.getElementById('add-buy-link-popup-window-create-button');


setUpDeleteBuyLinkButtons('buy-link-delete-button');


addBuyLinkButton.addEventListener('click', function(e) {
    e.preventDefault();

    showNewBuyLinkContainer('buy-links-container', 'add-buy-link-button');
});


addBuildComponentButton.addEventListener('click', function(e) {
    e.preventDefault();

    const typeId = addBuildComponentButton.getAttribute('data-type-id');
    const buildId = addBuildComponentButton.getAttribute('data-build-id');
    const encodedBuildId = addBuildComponentButton.getAttribute('data-encoded-build-id');

    addNewBuildComponent(typeId, buildId, encodedBuildId);
});


buyLinkNewDeliveryGroupPopupWindowCancelButton.addEventListener('click', function(e) {
    e.preventDefault();

    const buyLinkNewDeliveryGroupPopupWindow = document.getElementById('new-delivery-group-popup-container');
    const buyLinkNewDeliveryGroupPopupWindowNameInput = document.getElementById('delivery-group-name');
    const buyLinkNewDeliveryGroupPopupWindowFreeDeliveryAtInput = document.getElementById('delivery-group-free-delivery-at');
    const buyLinkNewDeliveryGroupPopupWindowDeliveryCostInput = document.getElementById('delivery-group-delivery-cost');

    buyLinkNewDeliveryGroupPopupWindow.classList.remove('d-flex');
    buyLinkNewDeliveryGroupPopupWindow.classList.add('d-none');

    buyLinkNewDeliveryGroupPopupWindowNameInput.value = "";
    buyLinkNewDeliveryGroupPopupWindowFreeDeliveryAtInput.value = "";
    buyLinkNewDeliveryGroupPopupWindowDeliveryCostInput.value = "";
});