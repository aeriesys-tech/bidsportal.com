import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
// import {LoadingPlugin} from 'vue-loading-overlay';
// import 'vue-loading-overlay/dist/css/index.css';
// import VueLoading from 'vue-loading-overlay';
// import 'vue-loading-overlay/dist/vue-loading.css';


createApp(App).use(store).use(router).mount('#app')
