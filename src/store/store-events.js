export default {
    namespaced: true,

    state: {
        events: []
    },

    getters: {
        getEvents(state) {
            return state.events;
        },
        getEvent: (state) => (eventKey) => {
            return state.events[eventKey];
        },
    },
    mutations: {
        setEvents(state, payload) {
            state.events = payload;
        }
    }
};