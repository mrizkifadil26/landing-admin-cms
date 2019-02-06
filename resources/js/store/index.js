import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

import { getLoggedinUser } from '../helpers/auth'

const user = getLoggedinUser()

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    status: '',
    token: localStorage.getItem('token') || '',
    currentUser: user,
    isLoggedIn: !!user,
    loading: false,
    auth_error: null,
    registration_error: null,
    registeredUser: null,
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
  mutations: {
    login(state) {
      state.loading = true
      state.auth_error = null
    },
    loginSuccess(state, payload) {
      state.auth_error = null
      state.isLoggedIn = true
      state.loading = false
      state.currentUser = Object.assign({}, payload.user, { token: payload.access_token })

      localStorage.setItem('user', JSON.stringify(state.currentUser))
    },
    loginFailed(state, payload) {
      state.loading = false
      state.auth_error = payload.error
    },
    logout(state) {
      localStorage.removeItem('user')
      state.isLoggedIn = false
      state.currentUser = null
    },
    registerSuccess(state, payload) {
      state.registration_error = null
      state.registeredUser = payload.user
    },
    registerFailed(state, payload) {
      state.registration_error = payload.error
    }
  },
  actions: {
    // login({ commit }, data) {
    //   return new Promise((resolve, reject) => {
    //     commit('auth_request')
    //     axios.post('/api/auth/login', data)
    //     .then(response => {
    //       console.log(response)
    //       const token = response.data.token
    //       const status = response.data.status
    //       const userid = response.data.user.id
    //       const user = response.data.name
    //       localStorage.setItem('token', token)
    //       localStorage.setItem('user_id', userid)
    //       localStorage.setItem('user', user)
    //       axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
    //       commit('auth_success', token, response.data.user, status)        
    //       resolve(response)
    //     })
    //     .catch(err => {
    //       commit('auth_error', err)
    //       localStorage.removeItem('token')
    //       localStorage.removeItem('user')
    //       localStorage.removeItem('user_id')
    //       reject(err)
    //     })
    //   })
    // },
    // register({commit}, user){
    //   return new Promise((resolve, reject) => {
    //     commit('auth_request')
    //     axios({url: '/register', data: user, method: 'POST' })
    //     .then(resp => {
    //       const token = resp.data.token
    //       const user = resp.data.user
    //       localStorage.setItem('token', token)
    //       axios.defaults.headers.common['Authorization'] = token
    //       commit('auth_success', token, user)
    //       resolve(resp)
    //     })
    //     .catch(err => {
    //       commit('auth_error', err)
    //       localStorage.removeItem('token')
    //       reject(err)
    //     })
    //   })
    // },
    logout({ commit }) {
      return new Promise((resolve, reject) => {
        commit('logout')
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        localStorage.removeItem('user_id')
        delete axios.defaults.headers.common['Authorization']
        resolve()
      })
    },
    login(context) {
      context.commit('login')
    }
  },
  getters: {
    isLoading: state => state.loading,
    isLoggedIn: state => state.isLoggedIn,
    authStatus: state => state.status,
    currentUser: state => state.currentUser,
    authError: state => state.auth_error,
    registrationUser: state => state.registration_error,
    registeredUser: state => state.registeredUser
  }
})