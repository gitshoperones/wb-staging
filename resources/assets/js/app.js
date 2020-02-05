/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('chat', require('./components/ChatComponent.vue'));

// Vue.component('chat-new-message', require('./components/ChatNewMessage.vue'));

Vue.component('vendorServices', require('./components/VendorServicesComponent.vue'));

Vue.component('favoriteVendor', require('./components/FavoriteVendorComponent.vue'));

Vue.component('multiSelect', require('./components/multiSelectComponent.vue'));

Vue.component('selectLocations', require('./components/SelectLocationsComponent.vue'));
Vue.component('vendorServiceLocations', require('./components/VendorServiceLocationsComponent.vue'));

Vue.component('savedJob', require('./components/SavedJobComponent.vue'));
Vue.component('specifications', require('./components/SpecificationsComponent.vue'));
Vue.component('quotesModal', require('./components/QuotesModalComponent.vue'));
Vue.component('milestones', require('./components/MilestonesComponent.vue'));

const app = new Vue({
    el: '#app'
});

window.setTimeout(function() {
    $(".alert.alert-dismissable").fadeTo(500, 0).slideUp(500, function(){
        $(this).remove();
    });
}, 8000);

//$('.wb-datepicker').datepicker({todayHighlight: true});