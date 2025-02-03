import './bootstrap.js';
import i18next from 'i18next';
import i18nextHttpBackend from 'i18next-http-backend';

async function initialiseApp() {
    await i18next
    .use(i18nextHttpBackend)  // Use backend for external JSON files
    .init({
        lng: 'sr',  // Set default language
        fallbackLng: 'sr',
        backend: {
            loadPath: '/locales/{{lng}}/translation.json',
        },
    });

    window.i18next = i18next;
}

await initialiseApp();