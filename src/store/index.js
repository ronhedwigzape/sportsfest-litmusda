import { createStore } from 'vuex';


// MODULES
import auth from './store-auth.js';


export default createStore({
    modules: {
        auth
    },

    state: {
        app: {
            backendDir: 'app'
        }
    },

    getters: {
        // get app name
        appName(state) {
            return import.meta.env.BASE_URL.replaceAll('/', '');
        },

        // get app url
        appURL(state) {
            const location = window.location;
            if(location.hostname === 'localhost' && location.port === '5176')
                return `http://localhost${import.meta.env.BASE_URL}${state.app.backendDir}`;
            else
                return `${location.protocol}//${location.hostname}${import.meta.env.BASE_URL}${state.app.backendDir}`;
        }
    },

    mutations: {

    },

})