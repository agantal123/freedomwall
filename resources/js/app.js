require('./bootstrap');
require('alpinejs');



import Vue from "vue";
import Form from './form'
import App from "./vue/app";
import VueRouter from 'vue-router';
import { routes } from './routes';
import Swal from 'sweetalert2';


window.Vue = require("vue").default;
window.Form = Form

Vue.component('pagination', require('laravel-vue-pagination'));
Vue.use(VueRouter);

window.Swal = Swal
// const Toast = Swal.mixin({
//   toast: true,
//   position: 'top-center',
//   showConfirmButton: false,
//   timer: 5000,
//   timerProgressBar: true,
//   onOpen: (toast) => {
//     toast.addEventListener('mouseenter', Swal.stopTimer)
//     toast.addEventListener('mouseleave', Swal.resumeTimer)
//   }
// })
// window.Toast = Toast
window.deleteConfirm = function(formId)
{
    Swal.fire({
        text: "are you sure you want to delete this post?",
        showCancelButton: true,
        confirmButtonColor: '#f47f7f',
        cancelButtonColor: '#aeb0b4',
        confirmButtonText: 'Delete'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(formId).submit();
        }
    });
}



Vue.use(require('vue-moment'));

//Vue.component('example-component', require('./vue/viewAllUser.vue').default);

Vue.component('add-newuser', require('./vue/manageUserlayout.vue').default);
//Vue.component('view-dashboard', require('./vue/dashboardlayout.vue').default);
Vue.component('dashboard-all-posts', require('./vue/dashboardposts.vue').default);

Vue.component('post-component', require('./vue/fullpost.vue').default);


const router = new VueRouter({
    mode: 'history',
    routes: routes
});


// const router = new VueRouter({
//     mode: 'history',
//     routes: routes
// });

const app = new Vue({
    el: "#app",
    router: router,
    data: {
        dropdown: false,
    },
    
});