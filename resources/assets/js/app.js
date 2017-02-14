
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


import ImageGallery from './components/ImageGallery.vue';
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

window.app = new Vue({
  el: '#app',
  components: {
   ImageGallery
  },
});


window.Echo.channel('images').listen('ImageUploaded', function(data){
   console.log('received image' + data);
   window.app.$refs.gallery.addImage(data.image);
});  
