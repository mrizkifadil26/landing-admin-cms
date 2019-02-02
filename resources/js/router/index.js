import Vue from 'vue'
import Router from 'vue-router'

import Layout from '../components/layouts/Layout'

import Landing from '../components/landing/Landing'
import NewsLayout from '../components/landing/news/NewsLayout'
import NewsSection from '../components/landing/news/NewsSection'

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

import CreateEvent from '../components/event/CreateEvent'
import EventList from '../components/event/EventList'
import ShowEvent from '../components/event/ShowEvent'
import UpdateEvent from '../components/event/UpdateEvent'

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
      component: {
        render(c) {
          return c('router-view')
        }
      },
      children: [
        {
          path: '',
          name: 'Landing',
          component: Landing
        },
        {
          path: 'news',
          meta: { label: 'News Section'},
          component: {
            render(c) {
              return c('router-view')
            }
          },
          children: [
            {
              path: '',
              component: NewsLayout
            },
            {
              path: 'show/:id',
              component: NewsSection,
              props: true
            },
          ]
        },
        {
          path: '/location',
          name: 'Location Section',
          component: {}
        },
        {
          path: '/complaint',
          name: 'Complaint Section',
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
          component: Dashboard
        },
        {
          path: 'news',
          meta: { label: 'News'},
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
              path: 'show/:id',
              name: 'Show Post',
              component: ShowPost
            },
            {
              path: 'edit/:id',
              name: 'Edit Post',
              component: UpdatePost
            }
          ]
        },
        {
          path: 'locations',
          meta: { label: 'Locations'},
          component: {
            render(c) { return c('router-view') }
          },      
          children: [
            {
              path: '',
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
          path: 'events',
          meta: { label: 'Event'},
          component: {
            render(c) { return c('router-view') }
          },      
          children: [
            {
              path: '',
              component: EventList
            },
            {
              path: 'create',
              name: 'Add Event',
              component: CreateEvent
            },
            {
              path: 'show',
              name: 'Show Event',
              component: ShowEvent
            },
            {
              path: 'edit',
              name: 'Edit Event',
              component: UpdateEvent
            }
          ]
        },
        {
          path: 'complaints',
          meta: { label: 'Complaints'},
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
          meta: { label: 'Users'},
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
      component: {
        render(c) {
          return c('router-view')
        }
      },
      children: [
        {
          path: '',
          name: 'Login',
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