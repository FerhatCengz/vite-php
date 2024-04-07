import {createApp} from 'vue'
import App from './App.vue'
import axios from 'axios';

import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'

axios.defaults.baseURL = window.location.href;


// eğer token var ise ve süresi bitmemişse bir şey yapma ama token yok ise istek at token olduğu halde süresi bitmişse tekrar istek at
if (!localStorage.getItem('auth-key') && localStorage.getItem('auth-key') === 'undefined') {
    axios.get('/api/auth-key.php').then((response) => {
        localStorage.setItem('auth-key', response.data);
    });
}


const app = createApp(App);
app.config.globalProperties.$axios = axios;
app.use(ElementPlus)
app.mount('#app')
