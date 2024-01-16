import {createApp} from "vue";
import App from "./App.vue";
import {createPinia} from "pinia";
import router from "@/routes";

// Icons and Styles
import FontAwesomePlugin from "./plugins/FontAwesome";
import "izitoast/dist/css/iziToast.min.css"
import "./assets/main.pcss";

// App Wide Components
import AppButton from "./components/AppButton.vue";
import AppCountInput from "./components/AppCountInput.vue";
import AppModalOverlay from "./components/AppModalOverlay.vue";

// Init App
createApp(App)
    .use(FontAwesomePlugin)
    .use(createPinia())
    .use(router)
    .component("AppButton", AppButton)
    .component("AppCountInput", AppCountInput)
    .component("AppModalOverlay", AppModalOverlay)
    .mount("#app");
