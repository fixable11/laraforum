"use strict";
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
require('@fortawesome/fontawesome-free/js/all.min.js');

import Common from "./Common";



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('thread-view', require('./pages/Thread.vue'));
Vue.component('paginator', require('./components/Paginator.vue'));
Vue.component('user-notifications', require('./components/UserNotifications.vue'));
Vue.component('avatar-form', require('./components/AvatarForm.vue'));
Vue.component('wysiwyg', require('./components/Wysiwyg.vue'));
Vue.component('choose-category', require('./components/ChooseCategory.vue'));

const app = new Vue({
    el: '#app'
});


$(document).ready(function(){

    let common = new Common();
  
    //Category accordion
    $('.categoriesBlock .categoryBlock .card-header').on('click', function (e) {
        $(this).next().slideToggle();
    });

});