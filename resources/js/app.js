import './bootstrap'
import Vue from 'vue'

import Measure from './components/Measure'
import Learn from './components/Learn'
import TagSwitch from './components/TagSwitch'

//vue-google-adsense
import Ads from 'vue-google-adsense'
Vue.use(require('vue-script2'))
Vue.use(Ads.Adsense)

const app = new Vue({
  el: '#app',
  components: {
    Learn,
    Measure,    
    TagSwitch,
  },

})