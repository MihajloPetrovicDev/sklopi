import errorService from '../services/error_service';
import '../app';
import i18next from 'i18next';


export async function createNewBuild(buildNameFieldId, visibilityFieldsName) {
    const buildNameField = document.getElementById(buildNameFieldId);
    const visbilityCheckedRadioButton = document.querySelector(`input[name="${visibilityFieldsName}"]:checked`);
    let buildIsPublic = false;

    if(visbilityCheckedRadioButton.value == 'true') {
        buildIsPublic = true;
    }

    try {
        const response = await axios.post('http://localhost:8000/api/create-new-build', {
            buildName: buildNameField.value,
            buildVisibility: buildIsPublic,
        });

        window.location.href='/my-builds';
    }
    catch(error) {
        errorService.handleError(error);
    }
}


export async function showNewBuyLinkContainer(buyLinksContainerId ,addBuyLinkButtonId) {
    const buyLinksContainer = document.getElementById(buyLinksContainerId);
    const addBuyLinkButton = document.getElementById(addBuyLinkButtonId);
    const buildId = addBuyLinkButton.getAttribute('data-build-id');

    addBuyLinkButton.style.visibility = 'none';

    const addBuyLinkContainer = await getAddBuyLinkContainer(buildId);

    buyLinksContainer.appendChild(addBuyLinkContainer);

    await setUpDeleteBuyLinkButtons('buy-link-delete-button');
    await setUpBuyLinkNewDeliveryGroupButtons('buy-link-new-delivery-group-button');
}


export async function addNewBuildComponent(typeId, buildId, encodedBuildId) {
    const buildComponentNameInput = document.getElementById('component-name');
    const buyLinkNameInputs = document.querySelectorAll('.add-buy-link-name');
    const buyLinkLinkInputs = document.querySelectorAll('.add-buy-link-link');
    const buyLinkPriceInputs = document.querySelectorAll('.add-buy-link-price');
    const buyLinkDeliveryGroupSelects = document.querySelectorAll('.add-buy-link-delivery-group');
    let buyLinks = [];
    
    for (let i = 0; i < buyLinkNameInputs.length; i++) {
        buyLinks.push({
            name: buyLinkNameInputs[i]?.value || '',
            link: buyLinkLinkInputs[i]?.value || '',
            price: buyLinkPriceInputs[i]?.value || 0,
            deliveryGroupId: buyLinkDeliveryGroupSelects[i]?.value || '',
        });
    }

    try {
        const response = await axios.post('http://localhost:8000/api/add-new-build-component', {
            name: buildComponentNameInput.value,
            typeId: typeId,
            buildId: buildId,
            buyLinks: buyLinks,
        });

        window.location.href = '/build/' + encodedBuildId;
    } catch(error) {
        errorService.handleError(error);
    }
}


export async function setUpDeleteBuyLinkButtons(deleteBuyLinkButtonClass) {
    const deleteBuyLinkButtons = document.querySelectorAll(`.${deleteBuyLinkButtonClass}`);

    deleteBuyLinkButtons.forEach(deleteBuyLinkButton => {
        deleteBuyLinkButton.addEventListener('click', function (e) {
            e.preventDefault();
            
            let buyLinkContainer = deleteBuyLinkButton.parentElement;
            buyLinkContainer.remove();
        });
    });
}


export async function setUpBuyLinkNewDeliveryGroupButtons(buyLinkNewDeliveryGroupButtonClass) {
    const buyLinkNewDeliveryGroupButtons = document.querySelectorAll(`.${buyLinkNewDeliveryGroupButtonClass}`);
    const buyLinkNewDeliveryGroupPopupWindow = document.getElementById('new-delivery-group-popup-container');

    buyLinkNewDeliveryGroupButtons.forEach(buyLinkNewDeliveryGroupButton => {
        buyLinkNewDeliveryGroupButton.addEventListener('click', function (e) {
            e.preventDefault();
            
            buyLinkNewDeliveryGroupPopupWindow.classList.remove('d-none');
            buyLinkNewDeliveryGroupPopupWindow.classList.add('d-flex');
        });
    });
}


function getAddBuyLinkNameContainer() {
    let nameDiv = document.createElement('div');
    nameDiv.classList.add('w-48p')
    
    let nameLabel = document.createElement('label');
    nameLabel.for = 'buy-link-name';
    nameLabel.textContent = i18next.t('add_buy_link.name');

    let nameInput = document.createElement('input');
    nameInput.classList.add('form-control', 'mt-1', 'add-buy-link-name');
    nameInput.id = 'buy-link-name';
    nameInput.placeholder = i18next.t('add_buy_link.optional');

    nameDiv.appendChild(nameLabel);
    nameDiv.appendChild(nameInput);

    return nameDiv;
}


function getAddBuyLinkLinkContainer() {
    let linkDiv = document.createElement('div');
    linkDiv.classList.add('w-47p', 'ml-5p')
    
    let linkLabel = document.createElement('label');
    linkLabel.for = 'buy-link-link';
    linkLabel.textContent = i18next.t('add_buy_link.link');

    let linkInput = document.createElement('input');
    linkInput.classList.add('form-control', 'mt-1', 'add-buy-link-link');
    linkInput.id = 'buy-link-link';

    linkDiv.appendChild(linkLabel);
    linkDiv.appendChild(linkInput);

    return linkDiv;
}


function getAddBuyLinkPriceContainer() {
    let priceDiv = document.createElement('div');
    priceDiv.classList.add('w-20p');
    
    let priceLabel = document.createElement('label');
    priceLabel.for = 'buy-link-price';
    priceLabel.textContent = i18next.t('add_buy_link.price');

    let priceInput = document.createElement('input');
    priceInput.classList.add('form-control', 'mt-1', 'add-buy-link-price');
    priceInput.id = 'buy-link-price';
    priceInput.placeholder = i18next.t('add_buy_link.optional');

    priceDiv.appendChild(priceLabel);
    priceDiv.appendChild(priceInput);

    return priceDiv;
}


async function getAddBuyLinkDeliveryGroupContainer(buildId) {
    let deliveryGroupDiv = document.createElement('div');
    deliveryGroupDiv.classList.add('d-flex', 'w-75p', 'ml-5p');

    let deliveryGroupDivLeft = document.createElement('div');
    deliveryGroupDivLeft.classList.add('w-60p', 'pr-10px');

    let deliveryGroupDivRight = document.createElement('div');
    deliveryGroupDivRight.classList.add('w-40p');
    
    let deliveryGroupLabel = document.createElement('label');
    deliveryGroupLabel.for = 'buy-link-delivery-group-select';
    deliveryGroupLabel.textContent = i18next.t('add_buy_link.delivery_group');

    let deliveryGroupSelect = document.createElement('select');
    deliveryGroupSelect.classList.add('form-select', 'h-38px', 'mt-1', 'add-buy-link-delivery-group');
    deliveryGroupSelect.id = 'buy-link-delivery-group-select'

    const deliveryGroups = await getBuildDeliveryGroups(buildId);

    // Setting an empty delivery group option first
    let deliveryGroupSelectOption = document.createElement('option');
    deliveryGroupSelectOption.value = null;
    deliveryGroupSelect.appendChild(deliveryGroupSelectOption);

    // Fill in the select options with delivery groups
    deliveryGroups.forEach(deliveryGroup => {
        let deliveryGroupSelectOption = document.createElement('option');
        deliveryGroupSelectOption.text = deliveryGroup.name;
        deliveryGroupSelectOption.value = deliveryGroup.id;

        deliveryGroupSelect.appendChild(deliveryGroupSelectOption);
    });

    let deliveryGroupButton = document.createElement('button');
    deliveryGroupButton.classList.add('btn', 'btn-primary', 'h-38px', 'mt-28px', 'w-100p', 'buy-link-new-delivery-group-button');
    deliveryGroupButton.textContent = i18next.t('add_buy_link.new_delivery_group');
    deliveryGroupButton.type = 'button';

    deliveryGroupDivLeft.appendChild(deliveryGroupLabel);
    deliveryGroupDivLeft.appendChild(deliveryGroupSelect);
    deliveryGroupDivRight.appendChild(deliveryGroupButton);

    deliveryGroupDiv.appendChild(deliveryGroupDivLeft);
    deliveryGroupDiv.appendChild(deliveryGroupDivRight);

    return deliveryGroupDiv;
}


async function getBuildDeliveryGroups(buildId) {
    try {
        const response = await axios.post('http://localhost:8000/api/get-build-delivery-groups', {
            buildId: buildId
        });
        
        const deliveryGroups = response.data.deliveryGroups;

        return deliveryGroups;
    }
    catch(error) {
        errorService.handleError(error);
        console.log(i18next.t('errors.error_delivery_groups_request'));

        return [];
    }
}


async function getAddBuyLinkContainer(buildId) {
    const addBuyLinkContainer = document.createElement('div');
    addBuyLinkContainer.classList.add('section-2', 'gap-5', 'w-100p', 'mt-3', 'pb-0px');

    const addBuyLinkDeleteButton = document.createElement('button');
    addBuyLinkDeleteButton.classList.add('buy-link-delete-button');

    const addBuyLinkDeleteButtonSpan = document.createElement('span');
    addBuyLinkDeleteButtonSpan.classList.add('material-symbols-outlined');
    addBuyLinkDeleteButtonSpan.textContent = 'delete';

    const addBuyLinkContainerTopRow = document.createElement('div');
    addBuyLinkContainerTopRow.classList.add('d-flex', 'mt-1');

    const addBuyLinkContainerBottomRow = document.createElement('div');
    addBuyLinkContainerBottomRow.classList.add('d-flex', 'mt-3');


    const addBuyLinkNameContainer = getAddBuyLinkNameContainer();
    const addBuyLinkLinkContainer = getAddBuyLinkLinkContainer();
    const addBuyLinkPriceContainer = getAddBuyLinkPriceContainer();
    const addBuyLinkDeliveryGroupContainer = await getAddBuyLinkDeliveryGroupContainer(buildId);

    addBuyLinkContainerTopRow.appendChild(addBuyLinkNameContainer);
    addBuyLinkContainerTopRow.appendChild(addBuyLinkLinkContainer);
    addBuyLinkContainerBottomRow.appendChild(addBuyLinkPriceContainer);
    addBuyLinkContainerBottomRow.appendChild(addBuyLinkDeliveryGroupContainer);

    addBuyLinkContainer.appendChild(addBuyLinkContainerTopRow);
    addBuyLinkContainer.appendChild(addBuyLinkContainerBottomRow);

    addBuyLinkDeleteButton.appendChild(addBuyLinkDeleteButtonSpan);
    addBuyLinkContainer.appendChild(addBuyLinkDeleteButton);

    return addBuyLinkContainer;
}