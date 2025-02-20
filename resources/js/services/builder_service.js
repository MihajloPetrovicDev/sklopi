import { appUrl } from '../env';

const builderService = {
    getAddBuyLinkNameContainer() {
        let nameDiv = document.createElement('div');
        nameDiv.classList.add('w-48p', 'md-max-1200px-w-90p')
        
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
        linkDiv.classList.add('w-47p', 'ml-5p', 'md-max-1200px-w-90p', 'md-max-1200px-ml-0px', 'md-max-1200px-mt-5px')
        
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
        priceDiv.classList.add('w-20p', 'md-max-1200px-w-90p');
        
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


    async getAddBuyLinkDeliveryGroupContainer(buildId) {
        let deliveryGroupDiv = document.createElement('div');
        deliveryGroupDiv.classList.add('d-flex', 'w-75p', 'ml-5p', 'md-max-1200px-d-block', 'md-max-1200px-w-90p', 'md-max-1200px-ml-0px', 'md-max-1200px-mt-5px');

        let deliveryGroupDivLeft = document.createElement('div');
        deliveryGroupDivLeft.classList.add('w-60p', 'pr-10px', 'md-max-1200px-w-100p', 'md-max-1200px-pr-0px');

        let deliveryGroupDivRight = document.createElement('div');
        deliveryGroupDivRight.classList.add('w-40p', 'md-max-1200px-w-40p', 'md-max-600px-w-100p');
        
        let deliveryGroupLabel = document.createElement('label');
        deliveryGroupLabel.for = 'add-buy-link-delivery-group-select';
        deliveryGroupLabel.textContent = i18next.t('add_buy_link.delivery_group');

        let deliveryGroupSelect = document.createElement('select');
        deliveryGroupSelect.classList.add('form-select', 'h-38px', 'mt-1', 'add-buy-link-delivery-group', 'buy-link-delivery-group-select');
        deliveryGroupSelect.id = 'add-buy-link-delivery-group-select'

        const deliveryGroups = await this.getBuildDeliveryGroups(buildId);

        // Setting an empty delivery group option first
        let deliveryGroupSelectOption = document.createElement('option');
        deliveryGroupSelect.appendChild(deliveryGroupSelectOption);

        // Fill in the select options with delivery groups
        deliveryGroups.forEach(deliveryGroup => {
            let deliveryGroupSelectOption = document.createElement('option');
            deliveryGroupSelectOption.text = deliveryGroup.name;
            deliveryGroupSelectOption.value = deliveryGroup.id;

            deliveryGroupSelect.appendChild(deliveryGroupSelectOption);
        });

        let deliveryGroupButton = document.createElement('button');
        deliveryGroupButton.classList.add('btn', 'btn-primary', 'h-38px', 'mt-28px', 'w-100p', 'buy-link-new-delivery-group-button', 'btn-text-truncate');
        deliveryGroupButton.textContent = i18next.t('add_buy_link.new_delivery_group');
        deliveryGroupButton.type = 'button';

        deliveryGroupDivLeft.appendChild(deliveryGroupLabel);
        deliveryGroupDivLeft.appendChild(deliveryGroupSelect);
        deliveryGroupDivRight.appendChild(deliveryGroupButton);

        deliveryGroupDiv.appendChild(deliveryGroupDivLeft);
        deliveryGroupDiv.appendChild(deliveryGroupDivRight);

        return deliveryGroupDiv;
    },


    async getBuildDeliveryGroups(buildId) {
        try {
            const response = await axios.post(appUrl + '/api/get-build-delivery-groups', {
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
    },


    async getAddBuyLinkContainer(buildId) {
        const addBuyLinkContainer = document.createElement('div');
        addBuyLinkContainer.classList.add('section-2', 'gap-5', 'w-100p', 'mt-3', 'pb-0px');

        const addBuyLinkDeleteButton = document.createElement('button');
        addBuyLinkDeleteButton.classList.add('buy-link-delete-button');

        const addBuyLinkDeleteButtonSpan = document.createElement('span');
        addBuyLinkDeleteButtonSpan.classList.add('material-symbols-outlined');
        addBuyLinkDeleteButtonSpan.textContent = 'delete';

        const addBuyLinkContainerTopRow = document.createElement('div');
        addBuyLinkContainerTopRow.classList.add('d-flex', 'mt-1', 'md-max-1200px-d-block');

        const addBuyLinkContainerBottomRow = document.createElement('div');
        addBuyLinkContainerBottomRow.classList.add('d-flex', 'mt-3', 'md-max-1200px-d-block', 'md-max-1200px-mt-5px');


        const addBuyLinkNameContainer = this.getAddBuyLinkNameContainer();
        const addBuyLinkLinkContainer = this.getAddBuyLinkLinkContainer();
        const addBuyLinkPriceContainer = this.getAddBuyLinkPriceContainer();
        const addBuyLinkDeliveryGroupContainer = await this.getAddBuyLinkDeliveryGroupContainer(buildId);

        addBuyLinkContainerTopRow.appendChild(addBuyLinkNameContainer);
        addBuyLinkContainerTopRow.appendChild(addBuyLinkLinkContainer);
        addBuyLinkContainerBottomRow.appendChild(addBuyLinkPriceContainer);
        addBuyLinkContainerBottomRow.appendChild(addBuyLinkDeliveryGroupContainer);

        addBuyLinkContainer.appendChild(addBuyLinkContainerTopRow);
        addBuyLinkContainer.appendChild(addBuyLinkContainerBottomRow);

        addBuyLinkDeleteButton.appendChild(addBuyLinkDeleteButtonSpan);
        addBuyLinkContainer.appendChild(addBuyLinkDeleteButton);

        return addBuyLinkContainer;
    },


    addNewDeliveryGroupOptionToEverySelect(deliveryGroupSelectClass, deliveryGroups) {
        const deliveryGroupSelects = document.querySelectorAll(`.${deliveryGroupSelectClass}`);

        deliveryGroupSelects.forEach(deliveryGroupSelect => {
            deliveryGroupSelect.replaceChildren();

            // Setting an empty delivery group option first
            let deliveryGroupSelectOption = document.createElement('option');
            deliveryGroupSelectOption.value = null;
            deliveryGroupSelect.appendChild(deliveryGroupSelectOption);

            deliveryGroups.forEach(deliveryGroup => {
                let deliveryGroupSelectOption = document.createElement('option');
                deliveryGroupSelectOption.text = deliveryGroup.name;
                deliveryGroupSelectOption.value = deliveryGroup.id;

                deliveryGroupSelect.appendChild(deliveryGroupSelectOption);
            });
        });
    },


    getDeliveryGroupNameContainer(deliveryGroupName) {
        const deliveryGroupNameContainer = document.createElement('div');
        deliveryGroupNameContainer.classList.add('w-30p', 'md-max-1200px-w-95p');

        const deliveryGroupNameLabel = document.createElement('label');
        deliveryGroupNameLabel.for = 'delivery-group-name';
        deliveryGroupNameLabel.textContent = i18next.t('delivery_group.name');

        const deliveryGroupNameInput = document.createElement('input');
        deliveryGroupNameInput.classList.add('form-control', 'mt-1', 'add-delivery-group-name');
        deliveryGroupNameInput.type = 'text';
        deliveryGroupNameInput.value = deliveryGroupName;

        deliveryGroupNameContainer.appendChild(deliveryGroupNameLabel);
        deliveryGroupNameContainer.appendChild(deliveryGroupNameInput);

        return deliveryGroupNameContainer;
    },


    getDeliveryGroupFreeDeliveryAtContainer(deliveryGroupFreeDeliveryAt, currency) {
        const deliveryGroupFreeDeliveryAtContainer = document.createElement('div');
        deliveryGroupFreeDeliveryAtContainer.classList.add('w-30p', 'ml-5p', 'md-max-1200px-ml-0px', 'md-max-1200px-w-95p');

        const deliveryGroupFreeDeliveryAtLabel = document.createElement('label');
        deliveryGroupFreeDeliveryAtLabel.for = 'delivery-group-free-delivery-at';
        deliveryGroupFreeDeliveryAtLabel.textContent = i18next.t('delivery_group.free_delivery_at');

        const deliveryGroupFreeDeliveryAtInputContainer = document.createElement('div');
        deliveryGroupFreeDeliveryAtInputContainer.classList.add('d-flex', 'mt-1');

        const deliveryGroupFreeDeliveryAtInput = document.createElement('input');
        deliveryGroupFreeDeliveryAtInput.classList.add('form-control', 'add-delivery-group-free-delivery-at');
        deliveryGroupFreeDeliveryAtInput.type = 'text';
        deliveryGroupFreeDeliveryAtInput.placeholder = i18next.t('delivery_group.optional');

        if(deliveryGroupFreeDeliveryAt == '') {
            deliveryGroupFreeDeliveryAtInput.value = deliveryGroupFreeDeliveryAt;
        }
        else {
            deliveryGroupFreeDeliveryAtInput.value = Number(deliveryGroupFreeDeliveryAt).toFixed(2);
        }

        const deliveryGroupFreeDeliveryAtInputOverlayContainer = document.createElement('div');
        deliveryGroupFreeDeliveryAtInputOverlayContainer.classList.add('w-80px', 'ml-m-80px', 'h-38px', 'input-fixed-overlay-container', 'br-tl-0px', 'br-bl-0px');

        const deliveryGroupFreeDeliveryAtInputOverlayText = document.createElement('p');
        deliveryGroupFreeDeliveryAtInputOverlayText.classList.add('mb-0px');
        deliveryGroupFreeDeliveryAtInputOverlayText.textContent = currency;

        deliveryGroupFreeDeliveryAtInputOverlayContainer.appendChild(deliveryGroupFreeDeliveryAtInputOverlayText);
        deliveryGroupFreeDeliveryAtInputContainer.appendChild(deliveryGroupFreeDeliveryAtInput);
        deliveryGroupFreeDeliveryAtInputContainer.appendChild(deliveryGroupFreeDeliveryAtInputOverlayContainer);
        deliveryGroupFreeDeliveryAtContainer.appendChild(deliveryGroupFreeDeliveryAtLabel);
        deliveryGroupFreeDeliveryAtContainer.appendChild(deliveryGroupFreeDeliveryAtInputContainer);

        return deliveryGroupFreeDeliveryAtContainer;
    },


    getDeliveryGroupDeliveryCostContainer(deliveryGroupCost, currency) {
        const deliveryGroupDeliveryCostContainer = document.createElement('div');
        deliveryGroupDeliveryCostContainer.classList.add('w-30p', 'ml-5p', 'md-max-1200px-ml-0px', 'md-max-1200px-w-95p');

        const deliveryGroupDeliveryCostLabel = document.createElement('label');
        deliveryGroupDeliveryCostLabel.for = 'delivery-group-delivery-cost';
        deliveryGroupDeliveryCostLabel.textContent = i18next.t('delivery_group.delivery_cost');

        const deliveryGroupDeliveryCostInputContainer = document.createElement('div');
        deliveryGroupDeliveryCostInputContainer.classList.add('d-flex', 'mt-1');

        const deliveryGroupDeliveryCostInput = document.createElement('input');
        deliveryGroupDeliveryCostInput.classList.add('form-control', 'add-delivery-group-delivery-cost');
        deliveryGroupDeliveryCostInput.type = 'text';
        deliveryGroupDeliveryCostInput.value = Number(deliveryGroupCost).toFixed(2);

        const deliveryGroupDeliveryCostInputOverlayContainer = document.createElement('div');
        deliveryGroupDeliveryCostInputOverlayContainer.classList.add('w-80px', 'ml-m-80px', 'h-38px', 'input-fixed-overlay-container', 'br-tl-0px', 'br-bl-0px');

        const deliveryGroupDeliveryCostInputOverlayText = document.createElement('p');
        deliveryGroupDeliveryCostInputOverlayText.classList.add('mb-0px');
        deliveryGroupDeliveryCostInputOverlayText.textContent = currency;

        deliveryGroupDeliveryCostInputOverlayContainer.appendChild(deliveryGroupDeliveryCostInputOverlayText);
        deliveryGroupDeliveryCostInputContainer.appendChild(deliveryGroupDeliveryCostInput);
        deliveryGroupDeliveryCostInputContainer.appendChild(deliveryGroupDeliveryCostInputOverlayContainer);
        deliveryGroupDeliveryCostContainer.appendChild(deliveryGroupDeliveryCostLabel);
        deliveryGroupDeliveryCostContainer.appendChild(deliveryGroupDeliveryCostInputContainer);

        return deliveryGroupDeliveryCostContainer;
    },

    
    getDeleteDeliveryGroupButtonContainer() {
        const deleteDeliveryGroupButtonContainer = document.createElement('div');
        deleteDeliveryGroupButtonContainer.classList.add('w-10p', 'd-flex', 'justify-content-between');

        const deleteDeliveryGroupButton = document.createElement('button');
        deleteDeliveryGroupButton.classList.add('span-button-red', 'ms-auto', 'w-fc', 'pin-0px', 'delete-delivery-group-button');

        const deleteDeliveryGroupButtonSpan = document.createElement('span');
        deleteDeliveryGroupButtonSpan.classList.add('material-symbols-outlined', 'mt-2');
        deleteDeliveryGroupButtonSpan.textContent = 'delete';

        deleteDeliveryGroupButton.appendChild(deleteDeliveryGroupButtonSpan);
        deleteDeliveryGroupButtonContainer.appendChild(deleteDeliveryGroupButton);

        return deleteDeliveryGroupButtonContainer;
    },
}

export default builderService;