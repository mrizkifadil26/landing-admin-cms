<template>
  <b-navbar toggleable="md" type="dark" text-variant="white" variant="primary">
    <b-navbar-brand tag="h1" href="#">
      <img src="img/favicon.png" class="d-inline-block align-top" alt="Logo" width="60"> 
    </b-navbar-brand>
    <span class="h3" align-self="center"><strong class="text-warning">CILEGON</strong>SMARTCITY</span>

    <b-collapse is-nav id="nav_text_collapse">
      <b-navbar-nav class="ml-auto" align-self="center">
        <b-nav-item href="#" variant="" class="mr-4 py-auto text-uppercase" v-for="(nav, index) in navs" :key="index">{{ nav }}</b-nav-item>
        <b-nav-item href="/login">
          <b-button variant="warning" class="text-uppercase">Login</b-button>
        </b-nav-item>
      </b-navbar-nav>
    </b-collapse>

  </b-navbar>
</template>

<script>
export default {
  name: 'Navbar',
  data() {
    return {
      navs: ['News', 'Best Location', 'Complaint', 'About']
    }
  }
}
</script>