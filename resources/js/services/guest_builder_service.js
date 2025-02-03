import { v4 as uuid } from 'uuid';
import i18next from 'i18next';
import numberFormatService from './number_format_service.js';


const guestBuilderService = {
    getBuildComponentTypesIsUniqueArray() {
        const buildComponentTypesIsUnique = {
            1: true,   // CPU
            2: true,   // Motherboard
            3: false,   // Ram
            4: true,   // GPU
            5: false,   // Storage
            6: true,   // PSU
            7: true,   // Case
            8: false,   // Other
        }

        return buildComponentTypesIsUnique;
    },


    getCheapestBuyLinksCombination(buildComponents, buyLinks) {
        let cheapestBuyLinksCombination = [];
        
        buildComponents.forEach(buildComponent => {
            const buildComponentBuyLinks = buyLinks.filter(buyLink => buyLink.buildComponentId === buildComponent.id) || null;

            if(buildComponentBuyLinks.length > 0){ 
                const buildComponentCheapestBuyLink = buildComponentBuyLinks.reduce((currentBuyLink, minBuyLink) => {
                    return currentBuyLink.price < minBuyLink.price ? currentBuyLink : minBuyLink;
                });

                cheapestBuyLinksCombination.push(buildComponentCheapestBuyLink);
            }
        });

        return cheapestBuyLinksCombination;
    },

    
    getAddBuildComponentButtonContainer(componentTypeId) {
        const addBuildButtonContainer = document.createElement('div');
        addBuildButtonContainer.classList.add('h-fc', 'mbl-10px', 'w-100p');

        const addBuildButton = document.createElement('a');
        addBuildButton.classList.add('btn', 'btn-primary', 'md-max-900px-w-fc', 'md-max-900px-d-block', 'md-max-900px-mx-auto');
        addBuildButton.textContent = i18next.t('add_build_component_button.add_component');
        addBuildButton.href = 'add-guest-build-component?component-type=' + componentTypeId;

        addBuildButtonContainer.appendChild(addBuildButton);

        return addBuildButtonContainer;
    },


    getAddBuyLinkNameContainer() {
        let nameDiv = document.createElement('div');
        nameDiv.classList.add('w-65p')
        
        let nameLabel = document.createElement('label');
        nameLabel.for = 'add-buy-link-name';
        nameLabel.textContent = i18next.t('add_buy_link.name');

        let nameInput = document.createElement('input');
        nameInput.classList.add('form-control', 'mt-1', 'add-buy-link-name');
        nameInput.id = 'add-buy-link-name';
        nameInput.placeholder = i18next.t('add_buy_link.optional');

        nameDiv.appendChild(nameLabel);
        nameDiv.appendChild(nameInput);

        return nameDiv;
    },


    getAddBuyLinkLinkContainer() {
        let linkDiv = document.createElement('div');
        linkDiv.classList.add('w-100p')
        
        let linkLabel = document.createElement('label');
        linkLabel.for = 'add-buy-link-link';
        linkLabel.textContent = i18next.t('add_buy_link.link');

        let linkInput = document.createElement('input');
        linkInput.classList.add('form-control', 'mt-1', 'add-buy-link-link');
        linkInput.id = 'add-buy-link-link';

        linkDiv.appendChild(linkLabel);
        linkDiv.appendChild(linkInput);

        return linkDiv;
    },


    getAddBuyLinkPriceContainer() {
        let priceDiv = document.createElement('div');
        priceDiv.classList.add('w-30p', 'ml-5p');
        
        let priceLabel = document.createElement('label');
        priceLabel.for = 'add-buy-link-price';
        priceLabel.textContent = i18next.t('add_buy_link.price');

        let priceInput = document.createElement('input');
        priceInput.classList.add('form-control', 'mt-1', 'add-buy-link-price');
        priceInput.id = 'add-buy-link-price';
        priceInput.placeholder = i18next.t('add_buy_link.optional');

        priceDiv.appendChild(priceLabel);
        priceDiv.appendChild(priceInput);

        return priceDiv;
    },


    getAddBuyLinkContainer() {
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


        const addBuyLinkNameContainer = this.getAddBuyLinkNameContainer();
        const addBuyLinkLinkContainer = this.getAddBuyLinkLinkContainer();
        const addBuyLinkPriceContainer = this.getAddBuyLinkPriceContainer();

        addBuyLinkContainerTopRow.appendChild(addBuyLinkNameContainer);
        addBuyLinkContainerTopRow.appendChild(addBuyLinkPriceContainer);
        addBuyLinkContainerBottomRow.appendChild(addBuyLinkLinkContainer);

        addBuyLinkContainer.appendChild(addBuyLinkContainerTopRow);
        addBuyLinkContainer.appendChild(addBuyLinkContainerBottomRow);

        addBuyLinkDeleteButton.appendChild(addBuyLinkDeleteButtonSpan);
        addBuyLinkContainer.appendChild(addBuyLinkDeleteButton);

        return addBuyLinkContainer;
    },


    createBuildComponent(buildComponentName, buildComponentTypeId) {
        const buildComponentTypesIsUnique = this.getBuildComponentTypesIsUniqueArray();

        const buildComponent = {
            id: uuid(),
            name: buildComponentName,
            typeId: buildComponentTypeId,
        };

        let buildComponents = JSON.parse(localStorage.getItem('buildComponents')) || [];

        console.log(buildComponents);
        console.log(buildComponents.find(buildComponent => buildComponent.typeId == buildComponentTypeId));

        if(buildComponentTypesIsUnique[buildComponentTypeId] && buildComponents.find(buildComponent => buildComponent.typeId == Number(buildComponentTypeId))) {
            return;
        }

        buildComponents.push(buildComponent);

        localStorage.setItem('buildComponents', JSON.stringify(buildComponents));

        return buildComponent;
    },


    createBuildComponentBuyLinks(buildComponentId, addBuyLinkNameInputClass, addBuyLinkPriceInputClass, addBuyLinkLinkInputClass) {
        const addBuyLinksToAdd = this.getAddBuyLinkInputElementsToArray(addBuyLinkNameInputClass, addBuyLinkPriceInputClass, addBuyLinkLinkInputClass);

        let buyLinks = JSON.parse(localStorage.getItem('buyLinks')) || [];

        addBuyLinksToAdd.forEach(buyLinkToAdd => {
            let buyLink = {
                id: uuid(),
                name: buyLinkToAdd['name'],
                price: buyLinkToAdd['price'],
                link: buyLinkToAdd['link'],
                buildComponentId: buildComponentId,
            };

            buyLinks.push(buyLink);
        });

        localStorage.setItem('buyLinks', JSON.stringify(buyLinks));

        return buyLinks;
    },


    getAddBuyLinkInputElementsToArray(buyLinkNameInputClass, buyLinkPriceInputClass, buyLinkLinkInputClass) {
        const buyLinkNameInputs = document.querySelectorAll(`.${buyLinkNameInputClass}`);
        const buyLinkPriceInputs = document.querySelectorAll(`.${buyLinkPriceInputClass}`);
        const buyLinkLinkInputs = document.querySelectorAll(`.${buyLinkLinkInputClass}`);
        let buyLinks = [];

        for(let i = 0; i < buyLinkNameInputs.length; i++) {
            buyLinks.push({
                name: buyLinkNameInputs[i]?.value || i18next.t('default_values.buy_link_name'),
                price: buyLinkPriceInputs[i]?.value || null,
                link: buyLinkLinkInputs[i]?.value || '',
            });
        }

        return buyLinks;
    },


    getBuyLinkInputElementsToArray(buildComponentId, buyLinkNameInputClass, buyLinkPriceInputClass, buyLinkLinkInputClass) {
        const buyLinkNameInputs = document.querySelectorAll(`.${buyLinkNameInputClass}`);
        const buyLinkPriceInputs = document.querySelectorAll(`.${buyLinkPriceInputClass}`);
        const buyLinkLinkInputs = document.querySelectorAll(`.${buyLinkLinkInputClass}`);
        let buyLinks = [];

        for(let i = 0; i < buyLinkNameInputs.length; i++) {
            buyLinks.push({
                id: buyLinkNameInputs[i]?.parentElement?.parentElement?.parentElement?.getAttribute('data-buy-link-id'),
                name: buyLinkNameInputs[i]?.value || i18next.t('default_values.buy_link_name'),
                price: buyLinkPriceInputs[i]?.value || null,
                link: buyLinkLinkInputs[i]?.value || '',
                buildComponentId: buildComponentId,
            });
        }

        return buyLinks;
    },


    getBuildComponentContainer(buildComponent, cheapestBuyLink) {
        const buildComponentContainer = document.createElement('div');
        buildComponentContainer.classList.add('h-fc', 'mbl-10px', 'w-100p');

        const buildComponentMainContainer = document.createElement('div');
        buildComponentMainContainer.classList.add('d-flex', 'section-2', 'w-100p', 'md-max-900px-d-block');

        const buildComponentNameContainer = this.getBuildComponentNameContainer(buildComponent.name);
        const buildComponentBuyLinkContainer = this.getBuildComponentBuyLinkContainer(cheapestBuyLink);
        const buildComponentControlsContainer = this.getBuildComponentControlsContainer(buildComponent);

        buildComponentMainContainer.appendChild(buildComponentNameContainer);
        buildComponentMainContainer.appendChild(buildComponentBuyLinkContainer);
        buildComponentMainContainer.appendChild(buildComponentControlsContainer);

        buildComponentContainer.appendChild(buildComponentMainContainer);

        return buildComponentContainer;
    },


    getBuildComponentNameContainer(buildComponentName) {
        const buildComponentNameContainer = document.createElement('div');
        buildComponentNameContainer.classList.add('w-50p', 'md-max-900px-w-100p');
        
        const buildComponentNameText = document.createElement('p');
        buildComponentNameText.classList.add('mb-0px');
        buildComponentNameText.textContent = buildComponentName;

        buildComponentNameContainer.appendChild(buildComponentNameText);

        return buildComponentNameContainer;
    },


    getBuildComponentBuyLinkContainer(buyLink) {
        const buyLinkContainer = document.createElement('div');
        buyLinkContainer.classList.add('w-40p', 'd-flex', 'md-max-900px-d-block', 'md-max-900px-w-100p');

        if(buyLink) {
            const buyLinkLinkValue = buyLink.link.startsWith('http') ? buyLink.link : '//' + buyLink.link;

            const buyLinkLinkContainer = document.createElement('div');
            buyLinkLinkContainer.classList.add('w-50p', 'md-max-900px-mt-5px', 'md-max-900px-w-100p');

            const buyLinkLink = document.createElement('a');
            buyLinkLink.href = buyLinkLinkValue;
            buyLinkLink.title = buyLink.link;
            buyLinkLink.target = '_blank';
            buyLinkLink.textContent = buyLink.name;

            const buyLinkPriceContainer = document.createElement('div');
            buyLinkPriceContainer.classList.add('w-50p', 'md-max-900px-mt-5px', 'md-max-900px-w-100p');

            const buyLinkPrice = document.createElement('p');
            buyLinkPrice.classList.add('mb-0px');
            buyLinkPrice.textContent = (buyLink.price == null ? '--' : numberFormatService.formatNumberToComaDecimalSeparator(Number(buyLink.price))) + ' RSD';

            buyLinkLinkContainer.appendChild(buyLinkLink);

            buyLinkPriceContainer.appendChild(buyLinkPrice);

            buyLinkContainer.appendChild(buyLinkLinkContainer);
            buyLinkContainer.appendChild(buyLinkPriceContainer);
        }

        return buyLinkContainer
    },


    getBuildComponentControlsContainer(buildComponent) {
        const buyLinkControlsContainer = document.createElement('div');
        buyLinkControlsContainer.classList.add('d-flex', 'w-10p', 'md-max-900px-w-20p', 'md-max-900px-mt-20px');
          
        const buyLinkSettingsLink = document.createElement('a');
        buyLinkSettingsLink.classList.add('span-button-black', 'h-24px', 'build-component-settings-button');
        buyLinkSettingsLink.href = '/guest-build-component?build-component=' + buildComponent.id + '&build-component-type=' + buildComponent.typeId;

        const buyLinkSettingsSpan = document.createElement('span');
        buyLinkSettingsSpan.classList.add('material-symbols-outlined', 'mx-auto');
        buyLinkSettingsSpan.textContent = 'settings';

        const deleteBuyLinkButton = document.createElement('button');
        deleteBuyLinkButton.classList.add('span-button-red', 'h-24px', 'build-component-delete-button', 'ms-auto', 'pin-0px');
        deleteBuyLinkButton.setAttribute('data-build-component-type-id', buildComponent.id);

        const deleteBuyLinkButtonSpan = document.createElement('span');
        deleteBuyLinkButtonSpan.classList.add('material-symbols-outlined');
        deleteBuyLinkButtonSpan.textContent = 'delete';

        buyLinkSettingsLink.appendChild(buyLinkSettingsSpan);
        deleteBuyLinkButton.appendChild(deleteBuyLinkButtonSpan);

        buyLinkControlsContainer.appendChild(buyLinkSettingsLink);
        buyLinkControlsContainer.appendChild(deleteBuyLinkButton);

        return buyLinkControlsContainer;
    },


    deleteBuildComponent(buildComponentId) {
        const buildComponents = JSON.parse(localStorage.getItem('buildComponents')) || [];
        const buyLinks = JSON.parse(localStorage.getItem('buyLinks')) || [];

        const filteredBuildComponents = buildComponents.filter(buildComponent => buildComponent.id != buildComponentId);
        const filteredBuyLinks = buyLinks.filter(buyLink => buyLink.buildComponentId != buildComponentId);
        
        console.log(buildComponentId);

        localStorage.setItem('buildComponents', JSON.stringify(filteredBuildComponents));
        localStorage.setItem('buyLinks', JSON.stringify(filteredBuyLinks));
    },


    getBuildComponentBuyLinksCombinationTotal(buyLinksCombination) {
        let buildTotal = 0;

        buyLinksCombination.forEach(buyLink => {
            buildTotal += Number(buyLink.price);
        });

        return buildTotal;
    },


    getBuyLinkNameContainer(buyLinkName) {
        let nameDiv = document.createElement('div');
        nameDiv.classList.add('w-65p')
        
        let nameLabel = document.createElement('label');
        nameLabel.for = 'add-buy-link-name';
        nameLabel.textContent = i18next.t('add_buy_link.name');

        let nameInput = document.createElement('input');
        nameInput.classList.add('form-control', 'mt-1', 'buy-link-name');
        nameInput.id = 'add-buy-link-name';
        nameInput.placeholder = i18next.t('add_buy_link.optional');
        nameInput.value = buyLinkName;

        nameDiv.appendChild(nameLabel);
        nameDiv.appendChild(nameInput);

        return nameDiv;
    },


    getBuyLinkLinkContainer(buyLinkLink) {
        let linkDiv = document.createElement('div');
        linkDiv.classList.add('w-100p')
        
        let linkLabel = document.createElement('label');
        linkLabel.for = 'add-buy-link-link';
        linkLabel.textContent = i18next.t('add_buy_link.link');

        let linkInput = document.createElement('input');
        linkInput.classList.add('form-control', 'mt-1', 'buy-link-link');
        linkInput.id = 'add-buy-link-link';
        linkInput.value = buyLinkLink;

        linkDiv.appendChild(linkLabel);
        linkDiv.appendChild(linkInput);

        return linkDiv;
    },


    getBuyLinkPriceContainer(buyLinkPrice) {
        let priceDiv = document.createElement('div');
        priceDiv.classList.add('w-30p', 'ml-5p');
        
        let priceLabel = document.createElement('label');
        priceLabel.for = 'add-buy-link-price';
        priceLabel.textContent = i18next.t('add_buy_link.price');

        let priceInput = document.createElement('input');
        priceInput.classList.add('form-control', 'mt-1', 'buy-link-price');
        priceInput.id = 'add-buy-link-price';
        priceInput.placeholder = i18next.t('add_buy_link.optional');
        priceInput.value = buyLinkPrice;

        priceDiv.appendChild(priceLabel);
        priceDiv.appendChild(priceInput);

        return priceDiv;
    },


    getBuyLinkContainer(buyLink) {
        const buyLinkContainer = document.createElement('div');
        buyLinkContainer.classList.add('section-2', 'gap-5', 'w-100p', 'mt-3', 'pb-0px');
        buyLinkContainer.setAttribute('data-buy-link-id', buyLink.id);

        const buyLinkDeleteButton = document.createElement('button');
        buyLinkDeleteButton.classList.add('buy-link-delete-button');

        const buyLinkDeleteButtonSpan = document.createElement('span');
        buyLinkDeleteButtonSpan.classList.add('material-symbols-outlined');
        buyLinkDeleteButtonSpan.textContent = 'delete';

        const buyLinkContainerTopRow = document.createElement('div');
        buyLinkContainerTopRow.classList.add('d-flex', 'mt-1');

        const buyLinkContainerBottomRow = document.createElement('div');
        buyLinkContainerBottomRow.classList.add('d-flex', 'mt-3');

        const buyLinkNameContainer = this.getBuyLinkNameContainer(buyLink.name);
        const buyLinkLinkContainer = this.getBuyLinkLinkContainer(buyLink.link);
        const buyLinkPriceContainer = this.getBuyLinkPriceContainer(buyLink.price);

        buyLinkContainerTopRow.appendChild(buyLinkNameContainer);
        buyLinkContainerTopRow.appendChild(buyLinkPriceContainer);
        buyLinkContainerBottomRow.appendChild(buyLinkLinkContainer);

        buyLinkContainer.appendChild(buyLinkContainerTopRow);
        buyLinkContainer.appendChild(buyLinkContainerBottomRow);

        buyLinkDeleteButton.appendChild(buyLinkDeleteButtonSpan);
        buyLinkContainer.appendChild(buyLinkDeleteButton);

        return buyLinkContainer;
    },


    saveBuildComponentName(buildComponentId, newbuildComponentName) {
        const buildComponents = JSON.parse(localStorage.getItem('buildComponents') || []);
        const buildComponent = buildComponents.find(buildComponent => buildComponent.id == buildComponentId);

        buildComponent.name = newbuildComponentName;

        const updatedBuildComponents = buildComponents.filter(buildComponent => buildComponent.id != buildComponentId);
        updatedBuildComponents.push(buildComponent);

        localStorage.setItem('buildComponents', JSON.stringify(updatedBuildComponents));
    },


    saveBuildComponentBuyLinks(buildComponentId, buyLinkClasses, addBuyLinkClasses) {
        const buyLinks = this.getBuyLinkInputElementsToArray(buildComponentId, buyLinkClasses.buyLinkNameInputClass, buyLinkClasses.buyLinkPriceInputClass, buyLinkClasses.buyLinkLinkInputClass);
        const localStorageBuyLinks = JSON.parse(localStorage.getItem('buyLinks')) || [];
        const localStorageOtherBuyLinks = localStorageBuyLinks.filter(localStorageBuyLink => localStorageBuyLink.buildComponentId != buildComponentId);

        localStorage.setItem('buyLinks', JSON.stringify(buyLinks.concat(localStorageOtherBuyLinks)));

        this.createBuildComponentBuyLinks(buildComponentId, addBuyLinkClasses.buyLinkNameInputClass, addBuyLinkClasses.buyLinkPriceInputClass, addBuyLinkClasses.buyLinkLinkInputClass)
    },
}


export default guestBuilderService;