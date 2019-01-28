<template>
  <section id="links" class="bg-white">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading">Link Penting</h2>
          <hr class="my-4">
        </div>
      </div>

      <div class="container">
        <div class="row">
          <swiper :options="swiperOption">
            <swiper-slide class="service-box text-center" v-for="(link, index) in links" :key="index">
              <img :src="link.src" :alt="link.name" height="64" class="mb-3">
              <h6><a :href="link.href">{{ link.name }}</a></h6>
              <span class="text-muted mb-0">{{ link.alias }}</span>
            </swiper-slide>
            <div class="swiper-button-prev" slot="button-prev"></div>
            <div class="swiper-button-next" slot="button-next"></div>
          </swiper>
        </div>
      </div>

    </div>
  </section>
</template>

<script>

import {  swiper, swiperSlide } from 'vue-awesome-swiper'

export default {
  name: 'Links',
  components: {
    'swiper': swiper,
    'swiper-slide': swiperSlide
  },
  data () {
    return {
      links: [
        {
          name: 'Layanan Perizinan',
          alias: 'Licensing Service',
          src: 'img/perizinan.png',
          href: 'https://dpmptsp.cilegon.go.id',
        },
        {
          name: 'Data Statistik Cilegon',
          alias: 'Cilegon Statistics',
          src: 'img/bps.png',
          href: 'https://cilegonkota.bps.go.id',
        },
        {
          name: 'Data Statistik Cilegon',
          alias: 'Cilegon Statistics',
          src: 'img/bps.png',
          href: 'https://cilegonkota.bps.go.id',
        },
        {
          name: 'Data Statistik Cilegon',
          alias: 'Cilegon Statistics',
          src: 'img/bps.png',
          href: 'https://cilegonkota.bps.go.id',
        },
        {
          name: 'Data Statistik Cilegon',
          alias: 'Cilegon Statistics',
          src: 'img/bps.png',
          href: 'https://cilegonkota.bps.go.id',
        },
        {
          name: 'Data Statistik Cilegon',
          alias: 'Cilegon Statistics',
          src: 'img/bps.png',
          href: 'https://cilegonkota.bps.go.id',
        },
        {
          name: 'Data Statistik Cilegon',
          alias: 'Cilegon Statistics',
          src: 'img/bps.png',
          href: 'https://cilegonkota.bps.go.id',
        },
        {
          name: 'Data Statistik Cilegon',
          alias: 'Cilegon Statistics',
          src: 'img/bps.png',
          href: 'https://cilegonkota.bps.go.id',
        },
        {
          name: 'Data Statistik Cilegon',
          alias: 'Cilegon Statistics',
          src: 'img/bps.png',
          href: 'https://cilegonkota.bps.go.id',
        },
        {
          name: 'Data Statistik Cilegon',
          alias: 'Cilegon Statistics',
          src: 'img/bps.png',
          href: 'https://cilegonkota.bps.go.id',
        },

      ],
      swiperOption: {
        autoplay: true,
        slidesPerView: '4',
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        }

      }
    }
  }
}
</script>

<style lang="scss" scoped>

@import '../../../../sass/landing.scss';

</style>