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
            <b-button class="btn btn-warning js-scroll-trigger" :to="{ name: 'Login' }">Login</b-button>
            </li>
          </ul>
        </div>
      </div>
    </nav>
    <b-container>
      <b-row>
        <b-col md="12">
          <spinner v-if="loading"></spinner>
          <h1 class="display-4 mb-5 mt-3">{{ post.title }}</h1>
          <b-row>
            <b-col md="1 px-0" sm="2" class="text-center">
              <b-img-lazy rounded="circle" class="mb-3" :src="post.posted_by.link" width="48" />
            </b-col>
            <b-col class="px-0">
              <a class="font-weight-bold" href="#">{{ post.posted_by.name }}</a>
              <p><small>{{ post.created_at }}</small></p>
            </b-col>
          </b-row>
          <h6 class="mb-2 font-weight-light">Tags <i class="fas fa-tag"></i> : <a href="#" class="font-weight-normal"><b-badge variant="dark">{{ post.category.post_category }}</b-badge></a></h6>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <b-img class="mb-4" :src="post.image.image_link" fluid-grow :alt="post.title"></b-img>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <p class="content text-justify text-wrap" v-html="post.content"></p>
        </b-col>  
      </b-row>
      <comments :post="post.id"></comments>
    </b-container>
    <the-footer></the-footer>
  </div>
</template>

<script>

import Footer from '../layouts/Footer'
import Comments from '../../helpers/Comments'

export default {
  name: 'NewsSection',
  props: ['id'],
  components: {
    'the-footer': Footer,
    Comments
  },
  data () {
    return {
      post: null,
      loading: false,
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
      ]
    }
  },
  methods: {
    getPost: function () {
      const paramUrl = this.$route.params.slug
      const postId = this.id
      this.loading = true
      axios.get(`/api/posts/${postId}`)
        .then(response => {
          this.loading = false
          this.post = response.data.data
        })
        .catch(error => {
          this.loading = false
          console.log(error)
        })
    }
  },
  created () {
    this.getPost()
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


