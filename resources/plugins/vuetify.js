// src/plugins/vuetify.js

import Vue from 'vue'
import Vuetify from 'vuetify'
import 'vuetify/dist/vuetify.min.css'

Vue.use(Vuetify)

const vuetify = new Vuetify({
  theme: {
    themes: {
      dark:{
        primary: '#2196f3',
        secondary: '#03a9f4',
        accent: '#673ab7',
        error: '#e91e63',
        warning:'#ffc107',
        info: '#607d8b',
        success: '#4caf50'
      },

    },
  },
})

export default vuetify
