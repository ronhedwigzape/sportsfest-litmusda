export default {
    namespaced: true,

    state: {
        user: null
    },

    getters: {
        getUser(state) {
            return state.user;
        }
    },

    mutations: {
        setUser(state, payload) {
            state.user = payload;
        },
        setUserPingTimestamp: (state, timestamp) => {
            state.user.pingTimestamp = timestamp;
        },
        setUserCurrentTimestamp: (state, timestamp) => {
            state.user.currentTimestamp = timestamp;
        }
    }
};