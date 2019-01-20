import Vue from 'vue'
import Router from 'vue-router'

import Layout from '../components/layouts/Layout'
import Dashboard from '../components/Dashboard'
import CreateUser from '../components/users/CreateUser'

Vue.use(Router)

export default new Router({
  mode: 'hash',
  linkActiveClass: 'open active',
  routes: [
    {
      path: '/',
      redirect: '/admin',
      name: 'Dashboard',
      component: Dashboard,
    },
    {
      path: '/admin/users',
      name: 'Users',
      component: CreateUser
    }
  ]
})