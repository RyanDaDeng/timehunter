require('./bootstrap');
import Api from './utils/api.js';
window.api = new Api();

import Auth from './utils/auth.js';
window.auth = new Auth();

window.Vue = require('vue');
import VueRouter from 'vue-router';
window.Vue.use(VueRouter);




window.Event = new Vue;
import PassportClients from './components/passport/Clients.vue';
import PassportAuthorizedClients from './components/passport/AuthorizedClients.vue';
import PassportPersonalAccessTokens from './components/passport/PersonalAccessTokens.vue';

import VueLayout from './components/Layout.vue';
import router from './routes.js';

import App from './App.vue';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en'

window.Vue.use(ElementUI,{ locale });
//import VueI18n from 'vue-i18n'
//
//window.Vue.use(VueI18n);
//
//const messages = {
//    en: {
//        message: {
//            hello: 'hello world'
//        }
//    },
//    ja: {
//        message: {
//            hello: 'こんにちは、世界'
//        }
//    }
//}
//const i18n = new VueI18n({
//    locale: 'ja', // set locale
//    messages, // set locale messages
//})

//const app = new Vue({
//    router,
//    components: {
//        PassportClients,
//        PassportAuthorizedClients,
//        PassportPersonalAccessTokens,
//        VueLayout
//    }
//}).$mount('#app')

const app = new Vue({
    el: '#app',
    //i18n,
    router,
    template: '<App/>',
    components: { App }
});