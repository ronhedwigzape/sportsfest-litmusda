export default {
    namespaced: true,

    state: {
        events: {
            literary: ["ORATION", "BALAGTASAN", "TIGSIK", "JAZZ CHANT"],
            music: ["VOCAL SOLO (MALE)", "VOCAL SOLO (FEMALE)", "VOCAL DUET", "ACOUSTIC BAND"],
            dance: ["HIP HOP", "JAZZ DANCE"],
            ballGames: ["BASKETBALL","VOLLEYBALL","TABLE TENNIS","BADMINTON","SEPAK TAKRAW"],
            boardGames: ["CHESS","SCIDAMA","GAMES OF THE GENERAL","WORD FACTORY","SUNGKA"],
            athletics: ["","","","","",""]
        }
    },

    getters: {
        getEvents(state) {
            return state.events;
        },
        getEvent: (state) => (eventKey) => {
            return state.events[eventKey];
        }
    },

};