export default {
    namespaced: true,

    state: {
        events: null
    },

    getters: {
        getEvents(state) {
            return state.events;
        },
        getEvent: (state) => (eventKey) => {
            return state.events[eventKey];
        },
        eventTitles: state => {
            return Object.values(state.events).map(event => event.title);
        }
    },
    mutations: {
        setEvents(state, payload) {
            state.events = payload;
        }
    }
};