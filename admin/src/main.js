import { createApp } from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'
import {LoadingPlugin} from 'vue-loading-overlay';
import 'vue-loading-overlay/dist/css/index.css';
import CKEditor from '@ckeditor/ckeditor5-vue';

const app = createApp(App);
app.use(store);
app.use(router);
app.use(LoadingPlugin);
app.use(CKEditor);
app.mount('#app');
