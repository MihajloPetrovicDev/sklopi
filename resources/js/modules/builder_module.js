import errorService from '../services/error_service';
import builderService from '../services/builder_service';
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


export async function showNewBuyLinkContainer(buyLinksContainerId, addBuyLinkButtonId) {
    const buyLinksContainer = document.getElementById(buyLinksContainerId);
    const addBuyLinkButton = document.getElementById(addBuyLinkButtonId);
    const buildId = addBuyLinkButton.getAttribute('data-build-id');

    const addBuyLinkContainer = await builderService.getAddBuyLinkContainer(buildId);

    buyLinksContainer.appendChild(addBuyLinkContainer);

    //Rerun the setup for delete buy link buttons every time a new buy link is added
    //so that the delete button works on it
    setUpDeleteBuyLinkButtons('buy-link-delete-button');

    //Run the setup for new delivery group buttons each time a new buy link is added so
    //that the new delivery group button works on it
    setUpBuyLinkNewDeliveryGroupButtons('buy-link-new-delivery-group-button', 'new-delivery-group-popup-container');
}


export function setUpBuyLinkNewDeliveryGroupButtons(buyLinkNewDeliveryGroupButtonClass, buyLinkNewDeliveryGroupPopupContainerId) {
    const buyLinkNewDeliveryGroupButtons = document.querySelectorAll(`.${buyLinkNewDeliveryGroupButtonClass}`);
    const buyLinkNewDeliveryGroupPopupWindow = document.getElementById(buyLinkNewDeliveryGroupPopupContainerId);

    buyLinkNewDeliveryGroupButtons.forEach(buyLinkNewDeliveryGroupButton => {
        buyLinkNewDeliveryGroupButton.addEventListener('click', function (e) {
            e.preventDefault();
            
            buyLinkNewDeliveryGroupPopupWindow.classList.remove('d-none');
            buyLinkNewDeliveryGroupPopupWindow.classList.add('d-flex');
        });
    });
}


export async function createNewBuildComponent(typeId, buildId, encodedBuildId, buildComponentNameInputId, buyLinkNameInputClass, buyLinkLinkInputClass, buyLinkPriceInputClass, buyLinkDeliveryGroupSelectClass) {
    const buildComponentNameInput = document.getElementById(buildComponentNameInputId);
    const buyLinkNameInputs = document.querySelectorAll(`.${buyLinkNameInputClass}`);
    const buyLinkLinkInputs = document.querySelectorAll(`.${buyLinkLinkInputClass}`);
    const buyLinkPriceInputs = document.querySelectorAll(`.${buyLinkPriceInputClass}`);
    const buyLinkDeliveryGroupSelects = document.querySelectorAll(`.${buyLinkDeliveryGroupSelectClass}`);
    let buyLinks = [];
    
    //Iterate trough all buy links on the page and push the corresponding input values
    //into the buyLinks array according to the current index, essentially push the buy link
    //info into the buyLinks array
    for(let i = 0; i < buyLinkNameInputs.length; i++) {
        buyLinks.push({
            name: buyLinkNameInputs[i]?.value || '',
            link: buyLinkLinkInputs[i]?.value || '',
            price: buyLinkPriceInputs[i]?.value || null,
            deliveryGroupId: buyLinkDeliveryGroupSelects[i]?.value || null,
        });
    }

    try {
        const response = await axios.post('http://localhost:8000/api/add-new-build-component', {
            buildComponentName: buildComponentNameInput.value,
            buildComponentTypeId: typeId,
            buildComponentBuildId: buildId,
            buildComponentAddBuyLinks: buyLinks,
        });

        window.location.href = '/build/' + encodedBuildId;
    } 
    catch(error) {
        errorService.handleError(error);
    }
}


export function setUpDeleteBuyLinkButtons(deleteBuyLinkButtonClass) {
    const deleteBuyLinkButtons = document.querySelectorAll(`.${deleteBuyLinkButtonClass}`);

    deleteBuyLinkButtons.forEach(deleteBuyLinkButton => {
        deleteBuyLinkButton.addEventListener('click', function (e) {
            e.preventDefault();
            
            let buyLinkContainer = deleteBuyLinkButton.parentElement;
            buyLinkContainer.remove();
        });
    });
}


export async function createNewDeliveryGroup(newDeliveryGroupNameInputId, newDeliveryGroupFreeDeliveryAtInputId, newDeliveryGroupDeliveryCostInputId, buildId) {
    const newDeliveryGroupNameInput = document.getElementById(newDeliveryGroupNameInputId);
    const newDeliveryGroupFreeDeliveryAtInput = document.getElementById(newDeliveryGroupFreeDeliveryAtInputId);
    const newDeliveryGroupDeliveryCostInput = document.getElementById(newDeliveryGroupDeliveryCostInputId);

    try {
        const response = await axios.post('http://localhost:8000/api/create-new-delivery-group', {
            deliveryGroupName: newDeliveryGroupNameInput.value,
            deliveryGroupFreeDeliveryAt: newDeliveryGroupFreeDeliveryAtInput.value,
            deliveryGroupDeliveryCost: newDeliveryGroupDeliveryCostInput.value,
            deliveryGroupBuildId: buildId,
        });

        const deliveryGroups = await builderService.getBuildDeliveryGroups(buildId);

        //After creating the delivery group add it as an option to all the delivery group select elements
        builderService.addNewDeliveryGroupOptionToEverySelect('add-buy-link-delivery-group', deliveryGroups);
    }
    catch(error) {
        errorService.handleError(error);
    }
}


export async function setupDeleteBuildComponentButtons(deleteBuildComponentButtonClass) {
    const deleteBuildComponentButtons = document.querySelectorAll(`.${deleteBuildComponentButtonClass}`);

    for(const deleteBuildComponentButton of deleteBuildComponentButtons) {
        deleteBuildComponentButton.addEventListener('click', async function(e) {
            e.preventDefault;

            let deleteButtonBuildComponentId = deleteBuildComponentButton.getAttribute('build-component-id');

            try {
                const response = await axios.post('http://localhost:8000/api/delete-build-component', {
                    deleteBuildComponentId: deleteButtonBuildComponentId,
                });

                window.location.reload();
            } 
            catch(error) {
                errorService.handleError(error);
            }
        });
    }
}


export async function updateBuildComponent(buildComponentId, encodedBuildId, buildComponentNameInputId, buyLinkClasses, addBuyLinkClasses) {
    const buildComponentNameInput = document.getElementById(buildComponentNameInputId);

    const buyLinkNameInputs = document.querySelectorAll(`.${buyLinkClasses.buyLinkNameInputClass}`);
    const buyLinkLinkInputs = document.querySelectorAll(`.${buyLinkClasses.buyLinkLinkInputClass}`);
    const buyLinkPriceInputs = document.querySelectorAll(`.${buyLinkClasses.buyLinkPriceInputClass}`);
    const buyLinkDeliveryGroupSelects = document.querySelectorAll(`.${buyLinkClasses.buyLinkDeliveryGroupSelectClass}`);

    const addBuyLinkNameInputs = document.querySelectorAll(`.${addBuyLinkClasses.addBuyLinkNameInputClass}`);
    const addBuyLinkLinkInputs = document.querySelectorAll(`.${addBuyLinkClasses.addBuyLinkLinkInputClass}`);
    const addBuyLinkPriceInputs = document.querySelectorAll(`.${addBuyLinkClasses.addBuyLinkPriceInputClass}`);
    const addBuyLinkDeliveryGroupSelects = document.querySelectorAll(`.${addBuyLinkClasses.addBuyLinkDeliveryGroupSelectClass}`);

    let buyLinks = [];
    let addBuyLinks = [];

    //Iterate trough all existing buy links on the page and push the corresponding input values
    //into the buyLinks array according to the current index, essentially push the existing buy link
    //info into the buyLinks array
    for(let i = 0; i < buyLinkNameInputs.length; i++) {
        buyLinks.push({
            id: buyLinkNameInputs[i]?.parentElement?.parentElement?.parentElement?.getAttribute('data-buy-link-id') || '',   //Get the id from the main buy link container
            name: buyLinkNameInputs[i]?.value || '',
            link: buyLinkLinkInputs[i]?.value || '',
            price: buyLinkPriceInputs[i]?.value || 0,
            deliveryGroupId: buyLinkDeliveryGroupSelects[i]?.value || null,
        });
    }
    
    //Iterate trough all new buy links on the page and push the corresponding input values
    //into the addBuyLinks array according to the current index, essentially push the new buy link
    //info into the addBuyLinks array
    for(let i = 0; i < addBuyLinkNameInputs.length; i++) {
        addBuyLinks.push({
            name: addBuyLinkNameInputs[i]?.value || '',
            link: addBuyLinkLinkInputs[i]?.value || '',
            price: addBuyLinkPriceInputs[i]?.value || 0,
            deliveryGroupId: addBuyLinkDeliveryGroupSelects[i]?.value || null,
        });
    }

    try {
        const response = await axios.post('http://localhost:8000/api/update-build-component', {
            buildComponentId: buildComponentId,
            buildComponentName: buildComponentNameInput.value,
            buildComponentBuyLinks: buyLinks,
            buildComponentAddBuyLinks: addBuyLinks,
        });

        window.location.href = '/build/' + encodedBuildId;
    }
    catch(error) {
        errorService.handleError(error);
    }
}