/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require("./bootstrap");

window.Vue = require("vue");
import VueRouter from "vue-router";
import jsPDF from "jspdf";

import { Form, HasError, AlertError } from "vform";
import moment from "moment";
Vue.use(VueRouter);
//Importing the gate class to be used in thhe application.
//import Gate from "./Gate";
//Vue.prototype.$gate = new Gate(window.user);
import * as VueGoogleMaps from "vue2-google-maps";
Vue.use(VueGoogleMaps, {
    load: {
        key: "AIzaSyD7Rb0j_M5Oq3Im4ml-eIuyHLjaBCuTEGE",
        libraries: "places"
    }
});
//importing sweetalert.
window.jsPDF = "jspdf";
import Swal from "sweetalert2";
window.Swal = Swal;
const Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    onOpen: toast => {
        toast.addEventListener("mouseenter", Swal.stopTimer);
        toast.addEventListener("mouseleave", Swal.resumeTimer);
    }
});
window.Toast = Toast;

//Custome events...registering globally.
window.Fire = new Vue();
window.FileSaver = require("file-saver");
//Importing the vue progressbar.
import VueProgressBar from "vue-progressbar";

Vue.use(VueProgressBar, {
    color: "rgb(143, 255, 199)",
    failedColor: "red",
    height: "3px"
});

window.Form = Form;
Vue.component(HasError.name, HasError);
Vue.component(AlertError.name, AlertError);
Vue.component("pagination", require("laravel-vue-pagination"));
Vue.use(VueRouter);

const routes = [
    {
        path: "/dashboard",
        component: require("./components/Dashboard.vue").default
    },
    {
        path: "/news",
        component: require("./components/News.vue").default
    },
    {
        path: "/userProjects",
        component: require("./components/UserProjects.vue").default
    },
    {
        path: "/mytwallet",
        component: require("./components/Mytwallet.vue").default
    },
    {
        path: "/projects",
        component: require("./components/Projects.vue").default
    },
    {
        path: "/meetup",
        component: require("./components/Meetup.vue").default
    },
    {
        path: "/twallet",
        component: require("./components/Twallet.vue").default
    },
    {
        path: "/post",
        component: require("./components/Posts.vue").default
    },
    {
        path: "/profile",
        component: require("./components/Profile.vue").default
    },
    { path: "/users", component: require("./components/Users.vue").default },
    { path: "/users", component: require("./components/Notfound.vue").default }
];

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component(
    "example-component",
    require("./components/ExampleComponent.vue").default
);

const router = new VueRouter({
    mode: "history",
    routes // short for 'routes: routes'
});

//Registering  a global filter.
Vue.filter("upText", function(text) {
    return text.charAt(0).toUpperCase() + text.slice(1);
});

//for filtering dates.
Vue.filter("myDate", function(created) {
    return moment(created).format("MMMM Do  YYYY");
});

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
window.moment = require("moment");
window.moment = require("moment-timezone");

const app = new Vue({
    el: "#app",
    router,
    data: {
        search: ""
    },
    methods: {
        searchit: _.debounce(() => {
            Fire.$emit("searching");
        }, 1000),

        printme() {
            window.print();
        }
    }
});
