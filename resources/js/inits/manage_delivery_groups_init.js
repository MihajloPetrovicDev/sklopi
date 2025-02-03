import builderModule from "../modules/builder_module.js";


const newDeliveryGroupPopupWindow = document.getElementById('new-delivery-group-popup-container');
const newDeliveryGroupButton = document.getElementById('new-delivery-group-button');
const newDeliveryGroupPopupWindowCancelButton = document.getElementById('add-delivery-group-popup-window-cancel-button');
const newDeliveryGroupPopupWindowCreateButton = document.getElementById('add-delivery-group-popup-window-create-button');
const saveDeliveryGroupsButton = document.getElementById('save-delivery-groups-button');


builderModule.setUpDeleteDeliveryGroupButtons('delete-delivery-group-button');


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

    const newDeliveryGroupContainer = builderModule.showNewDeliveryGroupContainer(buyLinkNewDeliveryGroupPopupWindowNameInput.value, buyLinkNewDeliveryGroupPopupWindowFreeDeliveryAtInput.value, buyLinkNewDeliveryGroupPopupWindowDeliveryCostInput?.value || 0, 'RSD');

    deliveryGroupsContainer.appendChild(newDeliveryGroupContainer);

    builderModule.setUpDeleteDeliveryGroupButtons('delete-delivery-group-button');

    buyLinkNewDeliveryGroupPopupWindow.classList.remove('d-flex');
    buyLinkNewDeliveryGroupPopupWindow.classList.add('d-none');

    buyLinkNewDeliveryGroupPopupWindowNameInput.value = "";
    buyLinkNewDeliveryGroupPopupWindowFreeDeliveryAtInput.value = "";
    buyLinkNewDeliveryGroupPopupWindowDeliveryCostInput.value = "";
});


saveDeliveryGroupsButton.addEventListener('click', function(e) {
    const buildId = saveDeliveryGroupsButton.getAttribute('data-build-id');
    const encodedBuildId = saveDeliveryGroupsButton.getAttribute('data-encoded-build-id');

    const deliveryGroupClasses = {
        deliveryGroupNameInputClass: 'delivery-group-name',
        deliveryGroupFreeDeliveryAtInputClass: 'delivery-group-free-delivery-at',
        deliveryGroupDeliveryCostInputClass: 'delivery-group-delivery-cost',
    }
    const addDeliveryGroupClasses = {
        addDeliveryGroupNameInputClass: 'add-delivery-group-name',
        addDeliveryGroupFreeDeliveryAtInputClass: 'add-delivery-group-free-delivery-at',
        addDeliveryGroupDeliveryCostInputClass: 'add-delivery-group-delivery-cost',
    }

    builderModule.updateDeliveryGroups(deliveryGroupClasses, addDeliveryGroupClasses, buildId, encodedBuildId);
});