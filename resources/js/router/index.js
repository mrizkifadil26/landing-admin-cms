import Vue from 'vue'
import Router from 'vue-router'

import Layout from '../components/layouts/Layout'

import Page404 from '../components/error/Page404'
import Page401 from '../components/error/Page401'
import Page500 from '../components/error/Page500'

import Landing from '../components/landing/Landing'
import NewsLayout from '../components/landing/news/NewsLayout'
import NewsSection from '../components/landing/news/NewsSection'

import Login from '../components/auth/Login'
import Register from '../components/auth/Register'

import Dashboard from '../components/Dashboard'

import Profile from '../components/profile/Profile'

import Gallery from '../components/gallery/Gallery'

import CreateUser from '../components/users/CreateUser'
import UsersList from '../components/users/UsersList'
import UpdateUser from '../components/users/UpdateUser'
import ShowUser from '../components/users/ShowUser'

import CreatePost from '../components/news/CreatePost'
import PostList from '../components/news/PostList'
import ShowPost from '../components/news/ShowPost'
import UpdatePost from '../components/news/UpdatePost'
import PostCategories from '../components/news/PostCategories'

import EventList from '../components/event/EventList'

import ComplaintList from '../components/complaint/ComplaintList'
import ShowComplaint from '../components/complaint/ShowComplaint'
import ComplaintCategories from '../components/complaint/ComplaintCategories'

import CreateLocation from '../components/location/CreateLocation'
import LocationList from '../components/location/LocationList'
import ShowLocation from '../components/location/ShowLocation'
import UpdateLocation from '../components/location/UpdateLocation'
import LocationCategories from '../components/location/LocationCategories'

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
              path: '/news/:slug-p-:id',
              name: 'News Section',
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
      meta: { requiresAuth: true, isAdmin: true },
      component : Layout,
      children: [
        {
          path: 'dashboard',
          name: 'Dashboard',
          component: Dashboard
        },
        {
          path: 'profile',
          name: 'Profile',
          component: Profile
        },
        {
          path: 'gallery',
          name: 'Gallery',
          component: Gallery
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
            },
            {
              path: 'delete/:id',
              name: 'Delete Post',
            },
            {
              path: 'post-categories',
              name: 'Post Categories',
              component: PostCategories
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
              path: 'show/:id',
              name: 'Show Location',
              component: ShowLocation
            },
            {
              path: 'edit/:id',
              name: 'Edit Location',
              component: UpdateLocation
            },
            {
              path: 'edit/:id',
              name: 'Delete Location',
            },
            {
              path: 'location-categories',
              name: 'Location Categories',
              component: LocationCategories
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
              path: 'show/:id',
              name: 'Complaint Details',
              component: ShowComplaint
            },
            {
              path: 'complaint-categories',
              name: 'Complaint Categories',
              component: ComplaintCategories
            }
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
              path: 'show/:id',
              name: 'Show User',
              component: ShowUser
            },
            {
              path: 'edit/:id',
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
      path: '/register',
      name: 'Register',
      component: Register,
      meta: { auth: false },
    },
    {
      path: '/404',
      path: '404 Page',
      component: Page404
    },
    {
      path: '/401',
      name: '401 Page',
      component: Page401
    },
    {
      path: '/500',
      name: '500 Page',
      component: Page500
    },
    {
      path: '*',
      name: '404 Page',
      component: Page404
    }
  ]
});

router.beforeEach((to, from, next) => {
  if (to.matched.some(record => record.meta.requiresAuth)) {
    if (store.getters['authentication/isLoggedIn'] === false) {
      next('/401')
    } else {
      let user = JSON.parse(localStorage.getItem('user'))
      if (to.matched.some(record => record.meta.isAdmin)) {
        if (user.role.id === 1) {
          next()
          return
        } else {
          next({ name: 'Landing' })
        }
      } else {
        next('/401')
      }
    }
  } else {
    next()
  }
})

export default router;