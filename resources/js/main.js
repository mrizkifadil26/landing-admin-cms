import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
import Axios from 'axios'

// require('./bootstrap');

import App from './App'
import router from './router'
import store from './store'

Vue.use(BootstrapVue)

Vue.prototype.$http = Axios;
const token = localStorage.getItem('token')
if (token) {
  Vue.prototype.$http.defaults.headers.common['Authorization'] = token
}

/* eslint-disable no-new */
new Vue({
    el: '#app',
    router,
    store,
    template: '<App />',
    components: { App }
});
