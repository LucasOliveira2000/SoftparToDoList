import '../css/app.css';
import './bootstrap';
import 'quasar/dist/quasar.css';
import '@quasar/extras/material-icons/material-icons.css';

import { Quasar, Notify } from 'quasar';
import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';
import Toast from '@/Components/Toast.vue';

console.log('Quasar Loaded:', Notify);
const appName = import.meta.env.VITE_APP_NAME || 'Laravel';

createInertiaApp({
    title: (title) => `${title} - ${appName}`,
    resolve: (name) =>
        resolvePageComponent(
            `./Pages/${name}.vue`,
            import.meta.glob('./Pages/**/*.vue'),
        ),
    setup({ el, App, props, plugin }) {
        return createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(ZiggyVue)
            .use(Quasar, {
                plugins: [Notify],

        }).component('Toast', Toast)
        .mount(el);
    },
    progress: {
        color: '#4B5563',
    },

});
