import './bootstrap';
import '../css/app.css';
import 'animate.css';

import { createApp, h } from 'vue';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import { InertiaProgress } from '@inertiajs/progress';

createInertiaApp({
    title: (title) => `${title}`,
    resolve: (name) => resolvePageComponent(`./Pages/${name}.vue`, import.meta.glob('./Pages/**/*.vue')),
    setup({ el, App, props, plugin }) {
        const app = createApp({ render: () => h(App, props) });

        app.config.globalProperties.$baseUrl = baseUrl;

        return app
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
});

InertiaProgress.init({
    delay: 100, // Attends 100ms avant de montrer la barre
    color: '#EA580C', // Couleur de la barre de progression // Redéfini en app.css
    includeCSS: false, // Inclut le CSS de la barre
    showSpinner: false // Désactive le spinner
});
