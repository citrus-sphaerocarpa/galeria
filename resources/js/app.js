/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

import VueI18n from 'vue-i18n';
Vue.use(VueI18n);

// 言語の設定
Vue.use(VueI18n);
const i18n = new VueI18n({
    locale: window.location.pathname.split('/')[1],
    fallbackLocale: 'en',
    messages: {
        ja : require('../lang/ja.json')
    }
});

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('follow-button', require('./components/FollowButton.vue').default);
Vue.component('favorite-button', require('./components/FavoriteButton.vue').default);
Vue.component('notification-icon', require('./components/NotificationIcon.vue').default);
Vue.component('private-chat-message', require('./components/PrivateChatMessage.vue').default);
Vue.component('infinite-scroll', require('./components/InfiniteScroll.vue').default);
Vue.component('input-tags', require('./components/InputTags.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    i18n: i18n,
});
