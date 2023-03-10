// Styles
import '@mdi/font/css/materialdesignicons.css'
import 'vuetify/styles'

// Vuetify
import { createVuetify } from 'vuetify'

export default createVuetify({
    display: {
        mobileBreakpoint: 'sm',
        thresholds: {
            xs: 0,
            sm: 340,
            md: 540,
            lg: 800,
            xl: 1280,
        },
    },
})
