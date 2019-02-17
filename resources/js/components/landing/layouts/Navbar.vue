<template>
  <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" v-scroll-to="'#page-top'" href="#page-top"><img src="/img/favicon.png" alt="Logo">Cilegon <span>SmartCity</span></a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item" v-for="(nav, index) in navs" :key="index">
            <a class="nav-link js-scroll-trigger" v-scroll-to="nav.href" :href="nav.href">{{ nav.name }}</a>
          </li>
          <li class="nav-item ml-3">
            <b-button class="btn btn-warning js-scroll-trigger" @click="logout" v-if="isLoggedIn">Logout</b-button>
            <b-button class="btn btn-warning js-scroll-trigger" :to="{ name: 'Login' }" v-else>Login</b-button>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>

<script>

import ScrollTo from 'vue-scrollto'
import Swal from 'sweetalert2'

export default {
  name: 'Navbar',
  directives: {
    ScrollTo
  },
  data() {
    return {
      navs: [
        {
          name: 'Berita',
          href: '#news'
        },
        {
          name: 'Kolom Aduan',
          href: '#complaint'
        },
        {
          name: 'Events',
          href: '#events'
        },
        {
          name: 'Lokasi Istimewa',
          href: '#location'
        },  
        {
          name: 'Link Penting',
          href: '#links'
        }
      ]
    }
  },
  methods: {
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
    }
  },
  mounted() {

    this.$nextTick(function() {
      window.addEventListener("scroll", function() {
        var navbar = document.getElementById("mainNav")
        var nav_classes = navbar.classList
        if(document.documentElement.scrollTop >= 150) {
          if (nav_classes.contains("navbar-shrink") === false) {
            nav_classes.toggle("navbar-shrink");
          }
        }
        else {
          if (nav_classes.contains("navbar-shrink") === true) {
            nav_classes.toggle("navbar-shrink");
          }
        }
      })
    })
  },
  computed: {
    isLoggedIn: function () {
      return this.$store.getters['authentication/isLoggedIn']
    }
  }
}

</script>

<style lang="scss" scoped>

// @import '../../../../sass/landing.scss';
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
  color: #2C9DD9;
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
  color: #212529;
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

</style>
