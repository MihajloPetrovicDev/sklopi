import { showNewDeliveryGroupContainer } from '../modules/builder_module';


const newDeliveryGroupPopupWindow = document.getElementById('new-delivery-group-popup-container');
const newDeliveryGroupButton = document.getElementById('new-delivery-group-button');
const newDeliveryGroupPopupWindowCancelButton = document.getElementById('add-delivery-group-popup-window-cancel-button');
const newDeliveryGroupPopupWindowCreateButton = document.getElementById('add-delivery-group-popup-window-create-button');


newDeliveryGroupButton.addEventListener('click', function(e) {
    newDeliveryGroupPopupWindow.classList.remove('d-none');
    newDeliveryGroupPopupWindow.classList.add('d-flex');
});


newDeliveryGroupPopupWindowCancelButton.addEventListener('click', function(e) {
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


newDeliveryGroupPopupWindowCreateButton.addEventListener('click', async function(e) {
    e.preventDefault();

    const buildId = newDeliveryGroupPopupWindowCreateButton.getAttribute('data-build-id');
    const deliveryGroupsContainer = document.getElementById('delivery-groups-container');
    const buyLinkNewDeliveryGroupPopupWindow = document.getElementById('new-delivery-group-popup-container');
    const buyLinkNewDeliveryGroupPopupWindowNameInput = document.getElementById('delivery-group-name');
    const buyLinkNewDeliveryGroupPopupWindowFreeDeliveryAtInput = document.getElementById('delivery-group-free-delivery-at');
    const buyLinkNewDeliveryGroupPopupWindowDeliveryCostInput = document.getElementById('delivery-group-delivery-cost');

    const newDeliveryGroupContainer = showNewDeliveryGroupContainer(buyLinkNewDeliveryGroupPopupWindowNameInput.value, buyLinkNewDeliveryGroupPopupWindowFreeDeliveryAtInput.value, buyLinkNewDeliveryGroupPopupWindowDeliveryCostInput.value, 'RSD');

    deliveryGroupsContainer.appendChild(newDeliveryGroupContainer);

    buyLinkNewDeliveryGroupPopupWindow.classList.remove('d-flex');
    buyLinkNewDeliveryGroupPopupWindow.classList.add('d-none');

    buyLinkNewDeliveryGroupPopupWindowNameInput.value = "";
    buyLinkNewDeliveryGroupPopupWindowFreeDeliveryAtInput.value = "";
    buyLinkNewDeliveryGroupPopupWindowDeliveryCostInput.value = "";
});