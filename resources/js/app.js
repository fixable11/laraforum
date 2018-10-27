"use strict";
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');
import Common from "./Common";

// window.Vue = require('vue');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

// Vue.component('example-component', require('./components/ExampleComponent.vue'));

// const app = new Vue({
//     el: '#app'
// });


$(document).ready(function(){

    

    let common = new Common();

    $('.app-alert-success,.app-alert-error').css('display', 'none').removeClass('d-n');

    common.flashFadeOut($('.alert-flash'));

    //REPLY
    $('.reply__btnEdit').on('click', function (e) {
        e.preventDefault();
        
        let closest = $(this).closest('.reply');
        let body = closest.find('.reply__body');
        let bodyText = body.text();

        body.hide();
        
        let editArea = closest.find('.reply__editArea');
        let form = closest.find('.reply__form');
        editArea.val(bodyText);

        form.removeClass('d-n');
    
    });

    $('.reply__btnCancel').on('click', function (e) {
        e.preventDefault();
        
        let closest = $(this).closest('.reply');
        let body = closest.find('.reply__body');

        body.show();

        let editArea = closest.find('.reply__editArea');
        let form = closest.find('.reply__form');
        editArea.val('');

        form.addClass('d-n');
    
    });
    
    $('.reply__btnUpdate').on('click', function (e) {
        e.preventDefault();
        
        let closest = $(this).closest('.reply');
        let form = closest.find('.reply__form');
        let body = closest.find('.reply__body');

        common.ajax(form, form.attr('action'), function(result){
            
            if(result.success){
                form.addClass('d-n');
                body.text(result.content);
                body.show();
                let statusBar = $('.app-alert-success').html(result.status);
                common.flashShow(statusBar);
                common.flashFadeOut(statusBar);
            }
        }, function(){
            form.addClass('d-n');
            body.show();
            let statusBar = $('.app-alert-error').html('Reply hasn\'t been updated');
            common.flashShow(statusBar);
            common.flashFadeOut(statusBar);
        });
 
    });

    $('.reply__btnDelete').on('click', function (e) {
        e.preventDefault();
        
        let closest = $(this).closest('.reply');
        let form = closest.find('.reply__form_delete');

        common.ajax(form, form.attr('action'), function(result){ 
            if(result.success){
                form.closest('.replyWrap').fadeOut();
                let statusBar = $('.app-alert-success').html(result.status);
                common.flashShow(statusBar);
                common.flashFadeOut(statusBar);
            }
        }, function(){
            form.addClass('d-n');
            body.show();
            let statusBar = $('.app-alert-error').html('Reply hasn\'t been deleted');
            common.flashShow(statusBar);
            common.flashFadeOut(statusBar);
        });
 
    });

  
    //REPLY END


  

});