import '../app';
import errorService from '../services/error_service';
import builderService from '../services/guest_builder_service';
import guestBuilderService from '../services/guest_builder_service';
import numberFormatService from '../services/number_format_service';
import builderModule from './builder_module';


const guestBuilderModule = {
    loadBuildComponents() {
        const buildComponents = JSON.parse(localStorage.getItem('buildComponents')) || [];
        const buyLinks = JSON.parse(localStorage.getItem('buyLinks')) || [];

        const cheapestBuyLinksCombination = builderService.getCheapestBuyLinksCombination(buildComponents, buyLinks);

        for(let i=1; i<=8; i++) {
            let builderBuildComponentContainer = document.querySelector('[data-build-component-type-id="' + i + '"]');
            let buildComponent = buildComponents.find(buildComponent => buildComponent.typeId == i);
            let cheapestBuyLink = buildComponent ? cheapestBuyLinksCombination.find(buyLink => buyLink.buildComponentId === buildComponent.id) : null;
            let buildComponentContainer;

            if(buildComponent) {
                buildComponentContainer = builderService.getBuildComponentContainer(buildComponent, cheapestBuyLink);
            }
            else {
                buildComponentContainer = builderService.getAddBuildComponentButtonContainer(i);
            }

            builderBuildComponentContainer.appendChild(buildComponentContainer);
        }
    },


    setUpAddBuyLinkButton(addBuyLinkButtonId, buyLinksContainerId) {
        const addBuyLinkButton = document.getElementById(addBuyLinkButtonId);
        const buyLinksContainer = document.getElementById(buyLinksContainerId);

        addBuyLinkButton.addEventListener('click', function(e) {
            e.preventDefault(e);

            const buyLink = guestBuilderService.getAddBuyLinkContainer();

            buyLinksContainer.appendChild(buyLink);

            builderModule.setUpDeleteBuyLinkButtons('buy-link-delete-button');
        });
    },


    setUpCreateBuildComponentButton(createBuildComponentButtonId, buildComponentNameInputId, addBuyLinkNameInputClass, addBuyLinkPriceInputClass, addBuyLinkLinkInputClass) {
        const createBuildComponentButton = document.getElementById(createBuildComponentButtonId);
        const buildComponentTypeId = createBuildComponentButton.getAttribute('data-build-component-type-id');
        const buildComponentNameInput = document.getElementById(buildComponentNameInputId);

        createBuildComponentButton.addEventListener('click', function(e) {
            e.preventDefault();

            const buildComponent = guestBuilderService.createBuildComponent(buildComponentNameInput.value, buildComponentTypeId);
            guestBuilderService.createBuildComponentBuyLinks(buildComponent.id, addBuyLinkNameInputClass, addBuyLinkPriceInputClass, addBuyLinkLinkInputClass);

            window.location.href = '/guest-build';
        });
    },


    setUpDeleteBuildComponentButtons(deleteBuildComponentButtonClass) {
        const deleteBuildComponentButtons = document.querySelectorAll(`.${deleteBuildComponentButtonClass}`);

        deleteBuildComponentButtons.forEach(deleteBuildComponentButton => {
            deleteBuildComponentButton.addEventListener('click', function(e) {
                e.preventDefault();

                let buildComponentToDeleteId = deleteBuildComponentButton.getAttribute('data-build-component-type-id');

                guestBuilderService.deleteBuildComponent(buildComponentToDeleteId);

                window.location.reload();
            });
        });
    },


    loadBuildTotal(buildTotalTextId) {
        const buildTotalText = document.getElementById(buildTotalTextId);

        const buildComponents = JSON.parse(localStorage.getItem('buildComponents')) || [];
        const buyLinks = JSON.parse(localStorage.getItem('buyLinks')) || [];

        const cheapestBuyLinksCombination = guestBuilderService.getCheapestBuyLinksCombination(buildComponents, buyLinks);
        let combinationTotal = guestBuilderService.getBuildComponentBuyLinksCombinationTotal(cheapestBuyLinksCombination);
        combinationTotal = numberFormatService.formatNumberToComaDecimalSeparator(combinationTotal);

        buildTotalText.textContent = buildTotalText.textContent + ' ' + combinationTotal + ' RSD';
    },


    loadBuildComponentInfo(nameInputId, buyLinksContainerId) {
        const urlParams = new URLSearchParams(window.location.search);
        const buildComponentId = urlParams.get('build-component');
        const buildComponents = JSON.parse(localStorage.getItem('buildComponents')) || [];
        const buyLinks = JSON.parse(localStorage.getItem('buyLinks')) || [];
        const buildComponent = buildComponents.find(buildComponent => buildComponent.id == buildComponentId);
        const buildComponentBuyLinks = buyLinks.filter(buyLink => buyLink.buildComponentId == buildComponentId);
        const nameInput = document.getElementById(nameInputId);
        const buyLinksContainer = document.getElementById(buyLinksContainerId);

        nameInput.value = buildComponent.name;

        buildComponentBuyLinks.forEach(buildComponentBuyLink => {
            let buildComponentContainer = guestBuilderService.getBuyLinkContainer(buildComponentBuyLink);

            buyLinksContainer.appendChild(buildComponentContainer);
        });
    },


    setUpSaveBuildComponentButton(saveBuildComponentButtonId, buildComponentNameInputId, buyLinkClasses, addBuyLinkClasses) {
        const saveBuildComponentButton = document.getElementById(saveBuildComponentButtonId);
        const buildComponentNameInput = document.getElementById(buildComponentNameInputId);
        const urlParams = new URLSearchParams(window.location.search);
        const buildComponentId = urlParams.get('build-component');

        saveBuildComponentButton.addEventListener('click', function(e) {
            guestBuilderService.saveBuildComponentName(buildComponentId, buildComponentNameInput.value);

            guestBuilderService.saveBuildComponentBuyLinks(buildComponentId, buyLinkClasses, addBuyLinkClasses);

            window.location.href = '/guest-build'
        });
    }
}


export default guestBuilderModule;