import  { createApp }  from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
import axios from "axios";

import "jquery/dist/jquery.min";
import "popper.js/dist/popper.min";
import "bootstrap/dist/js/bootstrap.min";

const axiosInstance = axios.create({
    baseURL: "https://api.klikagenda.com/api",
    timeout: 5000,
    headers: {
        Authorization: "Bearer " + localStorage.getItem("access_token"),
    },
});

const app = createApp(App);
app.config.productionTip = false;
app.config.globalProperties.$axios = axiosInstance;
app.use(router);
app.use(store);
app.mount("#app");

