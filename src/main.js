import { createApp } from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
// var Vue = require("vue");
// const Vue = window.vue;

// import "bootstrap/dist/css/bootstrap.css";
import "jquery/dist/jquery.min";
import "popper.js/dist/popper.min";
import "bootstrap/dist/js/bootstrap.min";
// Vue.component("pagination-bapenda", require("laravel-vue-pagination"));


createApp(App).use(store).use(store).use(router).use(router).mount("#app");
