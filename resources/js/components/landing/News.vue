<template>
  <div class="page-top">
    <navbar></navbar>
    <header class="masthead text-center text-white d-flex">
    <div class="container my-auto">
      <div class="row">
        <div class="col-lg-10 mx-auto">
          <h1 class="text-uppercase">
            <strong>Cilegon</strong>
            <h3 class="text-capitalize">Kota Industri Baja</h3>
          </h1>
          <hr>
        </div>
        <div class="col-lg-8 mx-auto">
          <p class="text-faded mb-5">Akur Sedulur Jujur Adil Makmur </p>
          <a class="btn btn-primary btn-xl js-scroll-trigger" href="#about">Mulai Jelajahi</a>
        </div>
      </div>
    </div>
  </header>
  </div>
</template>

<script>

import Navbar from './layouts/Navbar'
import Hero from './layouts/Hero'

export default {
  name: 'NewsLayout',
  components: {
    'navbar': Navbar,
    'main-image': Hero
  }
}

</script>


<style lang="scss" scoped>

a {
  color: #fff;
}

header.masthead {
  padding-top: 10rem;
  padding-bottom: calc(10rem - 56px);
  background-repeat: no-repeat;
  background-position: center center;
  background-image: linear-gradient(to top right, rgba(0, 47, 75, .5), rgba(220, 66, 37, .5)), url('~/img/cover.jpg');
  background-size: cover;
}

header.masthead hr {
  margin-top: 30px;
  margin-bottom: 30px;
}

header.masthead h1 {
  font-size: 2rem;
}

header.masthead p {
  font-weight: 300;
}

@media (min-width: 768px) {
  header.masthead p {
    font-size: 1.15rem;
  }
}

@media (min-width: 992px) {
  header.masthead {
    height: 100vh;
    min-height: 650px;
    padding-top: 0;
    padding-bottom: 0;
  }
  header.masthead h1 {
    font-size: 3rem;
  }
}

@media (min-width: 1200px) {
  header.masthead h1 {
    font-size: 4rem;
  }
}

</style>

