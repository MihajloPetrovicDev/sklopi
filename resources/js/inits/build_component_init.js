import builderModule from "../modules/builder_module";


const addBuyLinkButton = document.getElementById('add-buy-link-button');
const saveBuildComponentButton = document.getElementById('build-component-save-button');
const buyLinkNewDeliveryGroupPopupWindowCancelButton = document.getElementById('add-delivery-group-popup-window-cancel-button');
const buyLinkNewDeliveryGroupPopupWindowCreateButton = document.getElementById('add-delivery-group-popup-window-create-button');


builderModule.setUpDeleteBuyLinkButtons('buy-link-delete-button');


builderModule.setUpBuyLinkNewDeliveryGroupButtons('buy-link-new-delivery-group-button', 'new-delivery-group-popup-container');


addBuyLinkButton.addEventListener('click', function(e) {
    e.preventDefault();

    builderModule.showNewBuyLinkContainer('buy-links-container', 'add-buy-link-button');
});


saveBuildComponentButton.addEventListener('click', function(e) {
    e.preventDefault();

    const encodedBuildId = saveBuildComponentButton.getAttribute('data-encoded-build-id');
    const buildComponentId = saveBuildComponentButton.getAttribute('data-build-component-id');

    const buyLinkClasses = {
        buyLinkNameInputClass: 'buy-link-name',
        buyLinkLinkInputClass: 'buy-link-link',
        buyLinkPriceInputClass: 'buy-link-price',
        buyLinkDeliveryGroupSelectClass: 'buy-link-delivery-group',
    };

    const addBuyLinkClasses = {
        addBuyLinkNameInputClass: 'add-buy-link-name',
        addBuyLinkLinkInputClass: 'add-buy-link-link',
        addBuyLinkPriceInputClass: 'add-buy-link-price',
        addBuyLinkDeliveryGroupSelectClass: 'add-buy-link-delivery-group'
    };

    builderModule.updateBuildComponent(buildComponentId, encodedBuildId, 'component-name', buyLinkClasses, addBuyLinkClasses);
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

    builderModule.createNewDeliveryGroup('delivery-group-name', 'delivery-group-free-delivery-at', 'delivery-group-delivery-cost', buildId);

    buyLinkNewDeliveryGroupPopupWindow.classList.remove('d-flex');
    buyLinkNewDeliveryGroupPopupWindow.classList.add('d-none');

    buyLinkNewDeliveryGroupPopupWindowNameInput.value = "";
    buyLinkNewDeliveryGroupPopupWindowFreeDeliveryAtInput.value = "";
    buyLinkNewDeliveryGroupPopupWindowDeliveryCostInput.value = "";
});