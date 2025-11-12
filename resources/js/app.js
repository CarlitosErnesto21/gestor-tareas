import '../css/app.css';
import './bootstrap';

import { createInertiaApp } from '@inertiajs/vue3';
import { resolvePageComponent } from 'laravel-vite-plugin/inertia-helpers';
import { createApp, h } from 'vue';
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome';
import { library } from '@fortawesome/fontawesome-svg-core';
import { faUser, faUserPlus, faLock, faEnvelope, faKey, faPaperPlane, faEye, faEyeSlash, faUserPen, faUserXmark, faArrowLeft, faSpinner, faFloppyDisk } from '@fortawesome/free-solid-svg-icons';
import { ZiggyVue } from '../../vendor/tightenco/ziggy';


// Registrar los íconos usados en los formularios
library.add(faUser, faUserPlus, faLock, faEnvelope, faKey, faPaperPlane, faEye, faEyeSlash, faUserPen, faUserXmark, faArrowLeft, faSpinner, faFloppyDisk);

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
            .component('FontAwesomeIcon', FontAwesomeIcon)
            .use(plugin)
            .use(ZiggyVue)
            .mount(el);
    },
    progress: {
        color: '#4B5563',
    },
});
