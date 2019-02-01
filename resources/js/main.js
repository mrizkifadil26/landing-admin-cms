import Vue from 'vue'
import BootstrapVue from 'bootstrap-vue'
// import axios from 'axios'

// require('./bootstrap');

import App from './App'
import router from './router'
import store from './store'

Vue.use(BootstrapVue)
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
