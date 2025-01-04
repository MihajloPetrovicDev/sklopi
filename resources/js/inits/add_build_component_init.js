import { showNewBuyLinkContainer, addNewBuildComponent, setUpDeleteBuyLinkButtons, createNewDeliveryGroup } from "../modules/builder_module";


const addBuyLinkButton = document.getElementById('add-buy-link-button');
const addBuildComponentButton = document.getElementById('add-build-component-submit-button');
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

    addNewBuildComponent(typeId, buildId, encodedBuildId, 'component-name', 'add-buy-link-name', 'add-buy-link-link', 'add-buy-link-price', 'add-buy-link-delivery-group');
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


buyLinkNewDeliveryGroupPopupWindowCreateButton.addEventListener('click', function(e) {
    e.preventDefault();

    const buildId = buyLinkNewDeliveryGroupPopupWindowCreateButton.getAttribute('data-build-id');
    const buyLinkNewDeliveryGroupPopupWindow = document.getElementById('new-delivery-group-popup-container');
    const buyLinkNewDeliveryGroupPopupWindowNameInput = document.getElementById('delivery-group-name');
    const buyLinkNewDeliveryGroupPopupWindowFreeDeliveryAtInput = document.getElementById('delivery-group-free-delivery-at');
    const buyLinkNewDeliveryGroupPopupWindowDeliveryCostInput = document.getElementById('delivery-group-delivery-cost');

    createNewDeliveryGroup('delivery-group-name', 'delivery-group-free-delivery-at', 'delivery-group-delivery-cost', buildId);

    buyLinkNewDeliveryGroupPopupWindow.classList.remove('d-flex');
    buyLinkNewDeliveryGroupPopupWindow.classList.add('d-none');

    buyLinkNewDeliveryGroupPopupWindowNameInput.value = "";
    buyLinkNewDeliveryGroupPopupWindowFreeDeliveryAtInput.value = "";
    buyLinkNewDeliveryGroupPopupWindowDeliveryCostInput.value = "";
});
