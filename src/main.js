import {createApp} from 'vue'
import App from './App.vue'
import store from './store'
import router from './router'
import vuetify from './plugins/vuetify'
import './styles.css'
import './print.css'

createApp(App)
    .use(store)
    .use(router)
    .use(vuetify)
    .mount('#app')
