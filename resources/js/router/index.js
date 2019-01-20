import Vue from 'vue'
import Router from 'vue-router'

import Layout from '../components/layouts/Layout'
import Dashboard from '../components/Dashboard'
import CreateUser from '../components/users/CreateUser'

Vue.use(Router)

export default new Router({
  mode: 'history',
  linkActiveClass: 'open active',
  routes: [
    {
      path: '/admin',
      redirect: '/admin/dashboard',
      name: 'Home',
      component: Layout,
      children: [
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard
        },
        {
          path: 'users',
          name: 'Users',
          component: CreateUser
        }
      ]
    }
  ]
})