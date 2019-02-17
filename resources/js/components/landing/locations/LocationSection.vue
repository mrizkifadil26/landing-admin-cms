<template>
  <div class="page-top bg-white" >
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="/"><img src="/img/favicon.png" alt="Logo">Cilegon <span>SmartCity</span></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item" v-for="(nav, index) in navs" :key="index">
              <a class="nav-link js-scroll-trigger" :href="'/' + nav.href">{{ nav.name }}</a>
            </li>
            <li class="nav-item ml-3">
              <b-button class="btn btn-warning js-scroll-trigger" @click="logout" v-if="isLoggedIn">Logout</b-button>
              <b-button class="btn btn-warning js-scroll-trigger" :to="{ name: 'Login' }" v-else>Login</b-button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <b-container>
      <b-row>
        <b-col md="12">
          <spinner v-if="loading"></spinner>
          <h1 class="display-4 mb-5 mt-3">{{ location.location }}</h1>
          <b-row>
            <b-col md="1 px-0" sm="2" class="text-center">
              <b-img-lazy rounded="circle" class="mb-3" :src="location.posted_by.link" width="48" />
            </b-col>
            <b-col class="px-0">
              <a class="font-weight-bold" href="#">{{ location.posted_by.name }}</a>
              <p><small>{{ location.created_at }}</small></p>
            </b-col>
          </b-row>
          <h6 class="mb-2 font-weight-light">Tags <i class="fas fa-tag"></i> : <a href="#" class="font-weight-normal"><b-badge variant="dark">{{ location.category.location_category }}</b-badge></a></h6>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <p class="content text-justify text-wrap" v-html="location.description"></p>
          <p class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ location.address }} </p>
        </b-col>  
      </b-row>
      <hr>
      <b-row class="mb-3">
        <b-col md="12" sm="12">
          <h3 class="mb-5">Photos</h3>
        </b-col>
        <b-col v-if="location.photos < 1" class="text-center">
          <h6 class="text-center text-muted">No Photos</h6>
        </b-col>
        <b-col v-else>
          <b-img class="mb-4" :src="location.photos[0].image_link" fluid-grow :alt="location.photos[1].image_name"></b-img>
        </b-col>
      </b-row>
      <hr class="mt-5">
      <b-row>
        <b-col class="mb-3">
          <h2>Write a review:</h2>
        </b-col>
      </b-row>
      <b-container v-if="!isLoggedIn">
        <b-row>
          <b-col class="text-center">
            <h4 class="mb-2">You must login first.</h4>
            <b-button variant="primary" :to="{ path: '/login' }" size="lg">Login</b-button>
          </b-col>
        </b-row>
        <hr>
      </b-container>
      <b-container v-else>
        <b-form @submit.prevent="addReview()">
          <b-row>
            <b-col md="1.5">
              <b-img-lazy
                  rounded
                  class="mb-3" 
                  :src="user.avatar.avatar_link" 
                  width="96" />
            </b-col>
            <b-col class="mb-3">
              <star-rating
                class="mb-3 text-center"
                :show-rating="false"
                v-model="review.rating"></star-rating>
              <b-form-textarea
                id="review"
                v-model="review.review"
                placeholder="Write a review..."
                :rows="4"
                :max-rows="6"></b-form-textarea>
            </b-col>
          </b-row>
          <b-row>
            <b-col class="text-right">
              <b-button type="submit" variant="primary">Add Review</b-button>
            </b-col>
          </b-row>
          <hr>
        </b-form>
      </b-container>
      <review :location="location.id"></review>
    </b-container>
    <the-footer></the-footer>
  </div>
</template>

<script>

import Footer from '../layouts/Footer'
import Review from '../../helpers/Review'
import Rating from 'vue-star-rating'

export default {
  name: 'LocationSection',
  props: ['id'],
  components: {
    'the-footer': Footer,
    Review,
    'star-rating': Rating,
  },
  data () {
    return {
      post: null,
      loading: false,

      paramUrl: this.$route.params.id,

      review: {
        rating: null,
        review: ''
      },

      navs: [
        {
          name: 'Berita',
          href: 'news'
        },
        {
          name: 'Kolom Aduan',
          href: 'complaint'
        },
        {
          name: 'Lokasi Istimewa',
          href: 'location'
        },  
        {
          name: 'Link Penting',
          href: 'links'
        }
      ],

      location: {}
    }
  },
  methods: {
    getLocation (id) {
      
      this.loading = true
      axios.get(`/api/locations/${id}`)
        .then(response => {
          this.loading = false
          this.location = response.data.data
          console.log(this.location)
        })
        .catch(error => {
          this.loading = false
          console.log(error)
        })
    },
    logout: function() {
      Swal.fire({
        title: "Are you sure?",
        text: "You will be logged out.",
        type: 'warning',
        showCancelButton: true,
      }).then((result) => {
        if (result.value) {
          this.$store.dispatch('authentication/logout')
          Swal.fire({
            title: 'Logout Success',
            text: 'Logging out...',
            backdrop: 'rgba(0, 0, 0, 0.5)',
            showConfirmButton: false,
          })
          return this.$router.push('/login')
        } 
      })
    },
    addReview () {
      window.axios.post('/api/ratings', {
        location_id: this.location.id,
        user_id: this.user.id,
        rating: this.review.rating,
        review: this.review.review
      }).then(response => {
          Swal.fire({
            type: 'success',
            title: 'Review Sent!',
            text: 'Your review successfully sent.'
          })
          this.review.rating = ''
          this.review.review = ''
          console.log({
            location_id: this.location.id,
            user_id: this.user.id,
            rating: this.review.rating,
            review: this.review.review
          })
        })
        .catch(error => {
          Swal.fire({
            type: 'error',
            title: 'Error!',
            text: 'Please try again later.'
          })
          console.log(error)
        })
    }
  },
  computed: {
    isLoggedIn () {
      return this.$store.getters['authentication/isLoggedIn']
    },
    user () {
      return this.$store.getters['authentication/currentUser']
    },
  },
  created () {
    this.getLocation(this.paramUrl)
  },
  watch: {
    '$route': 'getPost'
  }
}
</script>

<style lang="scss" scoped>

.btn {
  font-weight: 700;
  text-transform: uppercase;
  border: none;
  border-radius: 200px;
  font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif;
}

.navbar-shrink .btn {
  background-color: #f05f40;
  color: #fff;
}

.navbar-shrink .btn:hover {
  background-color: #2C9DD9;
}

.navbar-shrink .btn:active {
  background-color: #2C9DD9;
}

#mainNav {
  border-bottom: 1px solid rgba(33, 37, 41, 0.1);
  background: #fff;
  font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif;
  -webkit-transition: all 0.2s;
  transition: all 0.2s;
}

#mainNav .navbar-brand {
  font-weight: 700;
  text-transform: uppercase;
  color: #fff;
  font-size: 1rem;
  font-family: 'Open Sans', 'Helvetica Neue', Arial, sans-serif;
}

#mainNav .navbar-brand span {
  color: #ffc107;
}

#mainNav .navbar-brand img {
  max-width: 56px;
  height: 100%;
  width: 100%;
}

#mainNav .navbar-brand:focus, #mainNav .navbar-brand:hover {
  font-size: 1rem;
}

#mainNav .navbar-nav > li.nav-item > a.nav-link,
#mainNav .navbar-nav > li.nav-item > a.nav-link:focus {
  font-size: .9rem;
  font-weight: 700;
  text-transform: uppercase;
  color: #fff;
}

#mainNav .navbar-nav > li.nav-item > a.nav-link.active,
#mainNav .navbar-nav > li.nav-item > a.nav-link:focus.active {
  color: #2C9DD9 !important;
  background: transparent;
}

#mainNav .navbar-nav > li.nav-item > a.nav-link.active:hover,
#mainNav .navbar-nav > li.nav-item > a.nav-link:focus.active:hover {
  background: transparent;
}

@media (min-width: 992px) {
  #mainNav {
    border-color: transparent;
    background-color: transparent;
  }
  #mainNav .navbar-brand {
    color: #fff;
  }
  #mainNav .navbar-brand:focus, #mainNav .navbar-brand:hover {
    color: #fff;
  }
  #mainNav .navbar-nav > li.nav-item > a.nav-link {
    padding: 0.5rem 1rem;
  }
  #mainNav .navbar-nav > li.nav-item > a.nav-link,
  #mainNav .navbar-nav > li.nav-item > a.nav-link:focus {
    color:#fff;;
  }
  #mainNav .navbar-nav > li.nav-item > a.nav-link:hover,
  #mainNav .navbar-nav > li.nav-item > a.nav-link:focus:hover {
    color: #ffc107;;
  }
  #mainNav.navbar-shrink {
    border-bottom: 1px solid rgba(33, 37, 41, 0.1);
    background-color: #fff;
  }
  #mainNav.navbar-shrink .navbar-brand {
    color: #2C9DD9;
  }
  #mainNav.navbar-shrink .navbar-brand span {
    color: #f05f40;
  }
  #mainNav.navbar-shrink .navbar-brand:focus, #mainNav.navbar-shrink .navbar-brand:hover {
    color: #f05f40;
  }
  #mainNav.navbar-shrink .navbar-nav > li.nav-item > a.nav-link,
  #mainNav.navbar-shrink .navbar-nav > li.nav-item > a.nav-link:focus {
    color: #212529;
  }
  #mainNav.navbar-shrink .navbar-nav > li.nav-item > a.nav-link:hover,
  #mainNav.navbar-shrink .navbar-nav > li.nav-item > a.nav-link:focus:hover {
    color: #2C9DD9;
  }
}

#mainNav {
  background-color: #2C9DD9;
}

.content {
  line-height: 1.5rem;
}

.fixed-top {
  position: sticky;
}

</style>