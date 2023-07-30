import "./bootstrap";
import { createApp, ref, watch, computed, onMounted } from "vue";
import router from "@/routes/rute.js";

import App from "@/components/App.vue";
import Header from "@/components/Header.vue";
import Footer from "@/components/Footer.vue";

let app = createApp(App);
app.use(router);
app.component("comp-header", Header);
app.component("comp-footer", Footer);
app.mount("#app");

