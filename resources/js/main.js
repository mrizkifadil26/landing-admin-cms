import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import VueProgressBar from 'vue-progressbar'
import VueCroppie from 'vue-croppie'
import VeeValidate from 'vee-validate'
import VueLazyload from 'vue-lazyload'

import App from './App'
import router from './router'
import store from './store'

import Spinner from './components/helpers/Spinner'

const options = {
  color: '#1b8eb7',
  failedColor: '#f86c6b',
  thickness: '0.25rem',
  transition: {
    speed: '0.2s',
    opacity: '0.6s',
    termination: 300
  },
  autoRevert: true,
  location: 'top',
  inverse: false
}

Vue.component('spinner', Spinner)
Vue.use(VeeValidate, { fieldsBagName: 'formFields' })
Vue.use(VueLazyload)
Vue.use(VueCroppie)
Vue.use(BootstrapVue)
Vue.use(VueProgressBar, options)
require('./bootstrap')
// axios.defaults.baseURL = 'https://localhost:8000'
// const token = localStorage.getItem('token')
// if (token) {
//   Vue.prototype.$http.defaults.headers.common['Authorization'] = token
// }

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    store,
    template: '<App />',
    components: { App }
});
