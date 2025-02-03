import guestBuilderModule from '../modules/guest_builder_module.js';
import builderModule from '../modules/builder_module.js';


guestBuilderModule.loadBuildComponentInfo('component-name', 'buy-links-container');


guestBuilderModule.setUpAddBuyLinkButton('add-buy-link-button', 'buy-links-container');


const buyLinkClasses = {
    buyLinkNameInputClass: 'buy-link-name',
    buyLinkPriceInputClass: 'buy-link-price',
    buyLinkLinkInputClass: 'buy-link-link',
};
const addBuyLinkClasses = {
    buyLinkNameInputClass: 'add-buy-link-name',
    buyLinkPriceInputClass: 'add-buy-link-price',
    buyLinkLinkInputClass: 'add-buy-link-link',
};
guestBuilderModule.setUpSaveBuildComponentButton('build-component-save-button', 'component-name', buyLinkClasses, addBuyLinkClasses);


builderModule.setUpDeleteBuyLinkButtons('buy-link-delete-button');