
import Vue from 'vue'

import Vuex from 'vuex'
Vue.use(Vuex)

import Driver from './Modules/driver.js'
import Restaurant from './Modules/restaurant.js'
import Promo from './Modules/promo.js'
import SubAdmin from './Modules/subAdmin.js'
import Report from './Modules/report.js'

export default new Vuex.Store({

  modules: {
  	'restaurant': Restaurant, 
    'driver': Driver,
    'promo': Promo,
    'sub-admin': SubAdmin, 
    'report': Report,
  },
  
})
