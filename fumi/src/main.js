import { createApp } from 'vue'
import App from './App.vue'
import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import './styles.css'
import router from './routes/'
import axios from  "axios"
axios.defaults.baseURL = process.env.VUE_APP_ROOT_API

createApp(App)
    .use(ElementPlus)
    .use(router)
    .mount('#app')

