const user = JSON.parse(localStorage.getItem('user') || null)

const initialState = {
  currentUser: user,
  isLoggedIn: !!user,
  loading: false,
  auth_error: null,
  registration_error: null,
  registeredUser: null,
}

const mutations = {
  AUTH_REQUEST (state) {
    state.loading = true
    state.auth_error = null
  },

  AUTH_SUCCESS(state, payload) {
    state.auth_error = null
    state.isLoggedIn = true
    state.loading = false
    state.currentUser = Object.assign({}, payload.user, { token: payload.access_token })

    localStorage.setItem('user', JSON.stringify(state.currentUser))
  },

  AUTH_ERROR(state, payload) {
    state.loading = false
    state.auth_error = payload.error
  },

  LOGOUT(state) {
    localStorage.removeItem('user')
    state.isLoggedIn = false
    state.currentUser = null
  },

  REGISTER_SUCCESS(state, payload) {
    state.registration_error = null
    state.registeredUser = payload.user
  },

  REGISTER_ERROR(state, payload) {
    state.registration_error = payload.error
  }

}

const actions = {
  login ({ commit }, payload) { 
    return new Promise((resolve, reject) => {
      commit('AUTH_REQUEST')
      window.axios.post('/api/auth/login', payload)
        .then(response => {
          commit('AUTH_SUCCESS', response.data)
          resolve(response.data)
        })
        .catch(error => {
          commit('AUTH_ERROR', error)
          reject("Error Authentication.")
        })
    })
  },

  register ({ commit }, payload) {
    commit('AUTH_REQUEST')
    return new Promise((resolve, reject) => {
      window.axios.post('/api/auth/register', payload)
        .then(response => {
          resolve(response.data)
        })
        .catch(error => {
          reject("An error occured... please try again later.")
        })
    })
  },

  logout ({ commit }) {
    return new Promise((resolve, reject) => {
      commit('LOGOUT')
      localStorage.removeItem('token')
      delete window.axios.defaults.headers.common['Authorization']
      resolve()
    })
  }

}

const getters = {
  isLoading: state => state.loading,
  isLoggedIn: state => state.isLoggedIn,
  authStatus: state => state.status,
  currentUser: state => state.currentUser,
  authError: state => state.auth_error,
  registrationUser: state => state.registration_error,
  registeredUser: state => state.registeredUser
}

export default {
  namespaced: true,
  state: initialState,
  mutations,
  actions,
  getters
}