import { createApp } from "vue";
import { createPinia } from "pinia";
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import "../css/app.css"; // Correction du chemin d'importation
import App from "./App.vue";
import router from "./router";

const app = createApp(App);

app.use(createPinia());
app.use(router);
app.use(autoAnimatePlugin);
app.mount("#app");
