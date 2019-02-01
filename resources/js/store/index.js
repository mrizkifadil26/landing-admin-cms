import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    status: '',
    token: localStorage.getItem('token') || '',
    currentUser: '',
  },
  mutations: {
    auth_request(state) {
      state.status = 'loading'
    },
    auth_success(state, token, user, status) {
      state.token = token
      state.currentUser = user
      state.status = status
    },
    auth_error(state) {
      state.status = 'error'
    },
    logout(state) {
      state.status = ''
      state.token = ''
    }
  },
  actions: {
    login({ commit }, data) {
      return new Promise((resolve, reject) => {
        commit('auth_request')
        axios.post('/api/auth/login', data)
        .then(response => {
          console.log(response)
          const token = response.data.token
          const status = response.data.status
          let userid = response.data.user.id
          const user = response.data.name
          localStorage.setItem('token', token)
          localStorage.setItem('user_id', userid)
          localStorage.setItem('user', user)
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
          commit('auth_success', token, user, status)        
          resolve(response)
        })
        .catch(err => {
          commit('auth_error', err)
          localStorage.removeItem('token')
          localStorage.removeItem('user')
          localStorage.removeItem('user_id')
          reject(err)
        })
      })
    },
    logout({ commit }) {
      return new Promise((resolve, reject) => {
        commit('logout')
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        localStorage.removeItem('user_id')
        delete axios.defaults.headers.common['Authorization']
        resolve()
      })
    }
  },
  getters: {
    isLoggedIn: state => !!state.token,
    authStatus: state => state.status,
    currentUser: state => state.currentUser,
  }
})