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
        axios.post('http://localhost:8000/api/auth/login', data)
        .then(response => {
          console.log(response)
          const token = response.data.token
          const status = response.data.status
          const user = response.data.user.name
          localStorage.setItem('token', token)
          localStorage.setItem('user', user)
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
          commit('auth_success', token, user, status)        
          resolve(response)
        })
        .catch(err => {
          commit('auth_error', err)
          localStorage.removeItem('token')
          localStorage.removeItem('user')
          reject(err)
        })
      })
    },
    logout({ commit }) {
      return new Promise((resolve, reject) => {
        commit('logout')
        localStorage.removeItem('token')
        localStorage.removeItem('user')
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