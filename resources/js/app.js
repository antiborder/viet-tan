import './bootstrap'
import Vue from 'vue'

import Measure from './components/Measure'
import Learn from './components/Learn'

const app = new Vue({
  el: '#app',
  components: {
    Learn,
    Measure,    
  },

})