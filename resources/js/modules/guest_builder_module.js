import '../app';
import errorService from '../services/error_service';
import builderService from '../services/guest_builder_service';
import guestBuilderService from '../services/guest_builder_service';


const guestBuilderModule = {
    showBuildComponents() {
        const buildComponents = JSON.parse(localStorage.getItem('buildComponents')) || [];
        const buyLinks = JSON.parse(localStorage.getItem('buyLinks')) || [];

        const cheapestBuyLinksCombination = builderService.getCheapestBuyLinksCombination(buildComponents, buyLinks);

        for(let i=1; i<=8; i++) {
            let builderBuildComponentContainer = document.querySelector('[data-build-component-type-id="' + i + '"]');
            let buildComponent = buildComponents.find(buildComponent => buildComponent.typeId == i);
            let cheapestBuyLink = buildComponent ? cheapestBuyLinksCombination.find(buyLink => buyLink.buildComponentId === buildComponent.id) : null;
            let buildComponentContainer;

            console.log(buildComponents);

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
    }
}


export default guestBuilderModule;