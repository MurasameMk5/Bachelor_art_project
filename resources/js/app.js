import { createInertiaApp } from "@inertiajs/vue3";
import { createApp, h } from "vue";
import { createPinia } from "pinia";
import { autoAnimatePlugin } from '@formkit/auto-animate/vue'
import "../css/app.css"; // Correction du chemin d'importation

createInertiaApp({
    withApp(app) {
        app.use(createPinia());
        app.use(autoAnimatePlugin);
    }
});
