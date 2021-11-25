/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('start', require('./components/StartComponent.vue').default);
Vue.component('test', require('./components/Test.vue').default);
Vue.component('test-admin', require('./components/TestAdmin.vue').default);
Vue.component('test-create', require('./components/TestCreate.vue').default);
Vue.component('test-details-create', require('./components/TestDetailsCreate.vue').default);
import Vueditor from 'vueditor'

import 'vueditor/dist/style/vueditor.min.css'

// your config here
let config = {
    toolbar: [
         'elements', 'fontName', 'fontSize', 'foreColor', 'backColor', 'divider',
        'bold', 'italic', 'underline', 'strikeThrough', 'links', 'divider', 'subscript', 'superscript',
        'divider', 'justifyLeft', 'justifyCenter', 'justifyRight', 'justifyFull', '|', 'indent', 'outdent',
        'insertOrderedList', 'insertUnorderedList'
    ],
    fontName: [
        {val: 'arial black'},
        {val: 'times new roman'},
        {val: 'Courier New'},
        {val: 'Courier'},
        {val: 'FreeMono'},
        {val: 'Comic Sans'},
        {val: 'Apple Chancery'},
        {val: 'Impact'},
        {val: 'Optima'},
        {val: 'Didot'},
    ],
    fontSize: [
        '12px', '14px', '16px'
    ],
    uploadUrl: '',
    id: '',
    classList: [],
    placeholder: 'Type here'
};

Vue.use(Vueditor, config);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */





const app = new Vue({
    el: '#app',
});
