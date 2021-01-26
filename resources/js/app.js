require('./bootstrap');

// Import modules...
import Vue from 'vue';
import { App as InertiaApp, plugin as InertiaPlugin } from '@inertiajs/inertia-vue';
import PortalVue from 'portal-vue';
import Lang from 'lang.js';
import Messages from './messages.js';
import {i18n} from './Plugin/I18n.js';
import flag from 'vue-flag-icon';

Vue.mixin({ methods: { route } });
Vue.use(InertiaPlugin);
Vue.use(PortalVue);
// gerer l'internationlisation
const lang = new Lang({
    messages:Messages
});
const app = document.getElementById('app');

window.eventBus = new Vue(); // accessible dans tous mes composants pour emettre les evenements

Vue.use(flag);
new Vue({
    flag,
    i18n,
    render: (h) =>
        h(InertiaApp, {
            props: {
                initialPage: JSON.parse(app.dataset.page),
                resolveComponent: (name) => require(`./Pages/${name}`).default,
            },
        }),
}).$mount(app);

// permet de partager des methodes dans mes composants
Vue.mixin({
    methods:{
        __(...args) // tous les argument seront les bienvenu
        {
            return lang.get(...args);
        }
    }
})

