import { createStore } from "vuex";

export default createStore({
    state: {
        user: {
            loggedIn: false,
            username: null,
        },
    },
    mutations: {
        login(state) {
            state.user.loggedIn = true;
        },
        logout(state) {
            state.user.loggedIn = false;
            state.user.username = null;
        },
        setUsername(state, username) {
            state.user.username = username;
        },
    },
    actions: {
        loginUser(context) {
            context.commit('login');
        },
        logoutUser(context) {
            context.commit('logout');
        },
        setUsername(context, username) {
            context.commit('setUsername', username);
        },
    },
    getters: {
        loggedIn(state) {
            return state.user.loggedIn;
        },
        username(state) {
            return state.user.username;
        },
    },
})