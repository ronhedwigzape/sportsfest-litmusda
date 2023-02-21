export default {
    namespaced: true,

    state: {
        teams: {
            red: {
                name: 'Fearless Dragons',
                logo: null
            },
            green: {
                name: 'Furious Elves',
                logo: null
            },
            blue: {
                name: 'Wise Wizards',
                logo: null
            }
        }
    },

    getters: {
        getTeam(state) {
            return state.teams;
        }
    },

};