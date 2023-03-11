export default {
    namespaced: true,

    state: {
        categories: [],
        events: []
    },

    getters: {
        getCategories(state) {
            return state.categories;
        },
        getEvents(state) {
            return state.events;
        },
        getCategorizedEvents(state) {
            const categories = [];
            for(let i = 0; i < state.categories.length; i++) {
                const category = state.categories[i];

                // scan category Events
                const categoryEvents = [];
                for(let j = 0; j < state.events.length; j++) {
                    const event = state.events[j];
                    if(event.category_id === category.id)
                        categoryEvents.push(event);
                }

                // push to categories
                if(categoryEvents.length > 0) {
                    categories.push({
                        category,
                        events: categoryEvents
                    });
                }
            }
            return categories;
        }
    },
    mutations: {
        setCategories(state, payload) {
            state.categories = payload;
        },
        setEvents(state, payload) {
            state.events = payload;
        }
    }
};