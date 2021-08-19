/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

 const { default: VueRouter } = require('vue-router');


 require('./bootstrap');

 window.Vue = require('vue').default;

 import Vue from 'vue';
 /**
  * The following block of code may be used to automatically register your
  * Vue components. It will recursively scan this directory for the Vue
  * components and automatically register them with their "basename".
  *
  * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
  */

 // const files = require.context('./', true, /\.vue$/i)
 // files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

 //Vue.component('example-component', require('./components/ExampleComponent.vue').default);
 // Vue.component('selecaoindicadores-component',require('./components/SelecaoIndicadores.vue'));
 // Vue.component('selecaoequipe-component',require('./components/SelecaoIndicadores.vue'));
 /**
  * Next, we will create a fresh Vue application instance and attach it to
  * the page. Then, you may begin adding components to this application
  * or customize the JavaScript scaffolding to fit your unique needs.
  */


 //import Vue from 'vue';
 import { routes } from './router/routes';
 import App from './view/App.vue';
 import App_blank from './view/App_blank.vue'
 import VueAxios from 'vue-axios';
 import axios from 'axios';
 import vuetify from '../plugins/vuetify'

 // import axios from 'axios';
 Vue.use(vuetify)
 Vue.use(VueRouter);
 Vue.use(VueAxios,axios);
 const router = new VueRouter({
     routes
 });

 function loggedIn(){
     return localStorage.getItem('token')
 }

 router.beforeEach((to, from, next) => {
     if (to.matched.some(record => record.meta.requiresAuth)) {
         // this route requires auth, check if logged in
         // if not, redirect to login page.
         if (!loggedIn()) {
             next({
             path: '/login',
             query: { redirect: to.fullPath }
             })
         }
         else {
             next()
         }
     } else if(to.matched.some(record => record.meta.guest)) {
         if (loggedIn()) {
             next({
             path: '/',
             query: { redirect: to.fullPath },
             })
         }
         else {
             next()
         }
     }
     else {
         next() // make sure to always call next()!
     }
 })


if (loggedIn()){
  const app = new Vue({
      el: '#app',
      router,
      vuetify,
      render: h=>h(App),

  })

}
else{
  const app = new Vue({
      el: '#app',
      router,
      vuetify,
      render: h=>h(App_blank),

  })
}
