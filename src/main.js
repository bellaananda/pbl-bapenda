import  { createApp }  from "vue";
import App from "./App.vue";
import router from "./router";
import store from "./store";
// import axios from "axios";

import "jquery/dist/jquery.min";
import "popper.js/dist/popper.min";
import "bootstrap/dist/js/bootstrap.min";

const app = createApp(App);
app.config.productionTip = false;
app.use(router);
app.use(store);
app.mount("#app");

// createApp(App).use(store).use(store).use(router).use(router).mount("#app");
// new Vue({
//     router,
//     store,
//     render: h => h(App)
// }).$mount("#app");