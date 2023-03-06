import { createStore } from 'vuex';

// MODULES
import auth from './store-auth.js';
import events from "./store-events";

export default createStore({
    modules: {
        auth,
        events
    },

    state: {
        app: {
            backendDir: 'app'
        },
        rating: {
            min: 75,
            max: 100
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