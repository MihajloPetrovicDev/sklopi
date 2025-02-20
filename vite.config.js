import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    build: {
        target: 'es2022',
    },
    plugins: [
        laravel({
            input: [
                'resources/css/app.css', 
                'resources/js/app.js',
                'resources/js/bootstrap.js',
                'resources/js/env.js',
                'resources/js/services/builder_service.js',
                'resources/js/services/error_service.js',
                'resources/js/services/guest_builder_service.js',
                'resources/js/services/number_format_service.js',
                'resources/js/services/auth_service.js',
                'resources/js/services/message_service.js',
                'resources/js/modules/auth_module.js',
                'resources/js/modules/builder_module.js',
                'resources/js/modules/guest_builder_module.js',
                'resources/js/inits/add_build_component_init.js',
                'resources/js/inits/add_guest_build_component_init.js',
                'resources/js/inits/build_component_init.js',
                'resources/js/inits/build_init.js',
                'resources/js/inits/create_new_build_init.js',
                'resources/js/inits/guest_build_component_init.js',
                'resources/js/inits/guest_build_init.js',
                'resources/js/inits/login_init.js',
                'resources/js/inits/manage_delivery_groups_init.js',
                'resources/js/inits/register_init.js',
                'resources/js/inits/forgot_your_password_init.js',
                'resources/js/inits/change_password_init.js',
                'resources/js/inits/my_account_init.js',
                'resources/js/inits/change_email_init.js',
                'resources/js/inits/change_email_verification_init.js',
            ],
            refresh: true,
        }),
    ],
});
