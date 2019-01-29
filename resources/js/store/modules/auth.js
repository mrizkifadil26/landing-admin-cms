function initialState() {

}

const mutations = {

}

const actions = {
  getLoggedInUser() {
    const userStr = localStorage.getItem('user');
    if (!userStr) {
      return null
    }

    return JSON.parse(userStr)
  }
}

const getters = {
  
}

export default {
  namespaced: true,
  state: initialState,
  mutations,
  actions,
  getters
}