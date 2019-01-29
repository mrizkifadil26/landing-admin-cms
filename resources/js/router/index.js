import Vue from 'vue'
import Router from 'vue-router'

import Layout from '../components/layouts/Layout'

import Landing from '../components/landing/Landing'
import News from '../components/landing/News'

import Login from '../components/auth/Login'
import Logout from '../components/auth/Logout'

import Dashboard from '../components/Dashboard'

import CreateUser from '../components/users/CreateUser'
import UsersList from '../components/users/UsersList'
import UpdateUser from '../components/users/UpdateUser'
import ShowUser from '../components/users/ShowUser'

import CreatePost from '../components/news/CreatePost'
import PostList from '../components/news/PostList'
import ShowPost from '../components/news/ShowPost'
import UpdatePost from '../components/news/UpdatePost'

import ComplaintList from '../components/complaint/ComplaintList'
import ShowComplaint from '../components/complaint/ShowComplaint'

import CreateLocation from '../components/location/CreateLocation'
import LocationList from '../components/location/LocationList'
import ShowLocation from '../components/location/ShowLocation'
import UpdateLocation from '../components/location/UpdateLocation'
import store from '../store';


Vue.use(Router)

let router =  new Router({
  mode: 'history',
  linkActiveClass: 'open active',
  routes: [
    {
      path: '/',
      name: 'Landing',
      component: {
        render(c) {
          return c('router-view')
        }
      },
      children: [
        {
          path: '',
          component: Landing
        },
        {
          path: '/news',
          component: News
        },
        {
          path: '/location',
          component: {}
        },
        {
          path: '/complaint',
          component: {}
        }
      ]
    },
    {
      path: '/admin',
      redirect: '/admin/dashboard',
      name: 'Home',
      meta: { requiresAuth: true },
      component : Layout,
      children: [
        {
          path: 'dashboard',
          name: 'Dashboard',
          meta: { auth: true },
          component: Dashboard
        },
        {
          path: 'news',
          name: 'News',
          component: {
            render(c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: PostList            
            },
            {
              path: 'create',
              name: 'Add Post',
              component: CreatePost
            },
            {
              path: 'show',
              name: 'Show Post',
              component: ShowPost
            },
            {
              path: 'edit',
              name: 'Edit Post',
              component: UpdatePost
            }
          ]
        },
        {
          path: 'locations',
          name: 'Locations',
          component: {
            render(c) { return c('router-view') }
          },      
          children: [
            {
              path: '/',
              component: LocationList
            },
            {
              path: 'create',
              name: 'Add Location',
              component: CreateLocation
            },
            {
              path: 'show',
              name: 'Show Location',
              component: ShowLocation
            },
            {
              path: 'edit',
              name: 'Edit Location',
              component: UpdateLocation
            }
          ]
        },
        {
          path: 'complaints',
          name: 'Complaints',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: ComplaintList
            },
            {
              path: 'show',
              name: 'Complaint Details',
              component: ShowComplaint
            },
          ]
        },
        {
          path: 'users',
          name: 'Users',
          component: {
            render (c) { return c('router-view') }
          },
          children: [
            {
              path: '',
              component: UsersList
            },
            {
              path: 'create',
              name: 'Add User',
              component: CreateUser,
            },
            {
              path: 'show',
              name: 'Show User',
              component: ShowUser
            },
            {
              path: 'edit',
              name: 'Edit User',
              component: UpdateUser
            }
          ]
        },
      ]
    },
    {
      path: '/login',
      name: 'Login',
      component: {
        render(c) {
          return c('router-view')
        }
      },
      children: [
        {
          path: '',
          meta: { auth: false },
          component: Login
        }
      ]
    },
    {
      path: '/logout',
      name: 'Logout',
      component: Logout
    }
  ]
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters.isLoggedIn) {
      next()
      return
    }
    next('/login')
  } else {
    next()
  }
})

export default router;