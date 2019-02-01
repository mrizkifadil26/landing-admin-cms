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
          href: 'http://dpmptsp.cilegon.go.id',
        },
        {
          name: 'Layanan Kesehatan',
          alias: 'Health Service',
          src: 'img/kesehatan.png',
          href: 'https://kotacilegon.epuskesmas.id/',
        },
        {
          name: 'Layanan Pendidikan',
          alias: 'Education Service',
          src: 'img/pendidikan.png',
          href: 'http://sipinterdindikcilegon.web.id/sipinter1/',
        },
        {
          name: 'Layanan Pengadaan',
          alias: 'Procurement Service',
          src: 'img/pengadaan.png',
          href: '#',
        },
        {
          name: 'Layanan Pengaduan',
          alias: 'Complaint Service',
          src: 'img/pengaduan.png',
          href: '#',
        },
        {
          name: 'Layanan Bursa Kerja',
          alias: 'Job Market Service',
          src: 'img/bursa.png',
          href: 'https://id-id.facebook.com/PelayananAntarKerjaCilegon/',
        },
        {
          name: 'Layanan Perpajakan',
          alias: 'Taxation Service',
          src: 'img/pajak.png',
          href: '#',
        },
        {
          name: 'Portal Cilegon',
          alias: 'Cilegon Portal',
          src: 'img/government.png',
          href: 'http://portal.cilegon.go.id',
        },
        {
          name: 'Organisasi Perangkat Daerah',
          alias: 'Regional Organizations',
          src: 'img/subdomain.png',
          href: '#',
        },
        {
          name: 'Produk Hukum Daerah',
          alias: 'Local Regulations',
          src: 'img/download.png',
          href: 'https://jdih.cilegon.go.id',
        },
        {
          name: 'Aplikasi Kepemerintahan',
          alias: 'Government Application',
          src: 'img/aplikasi.png',
          href: '#',
        },
        {
          name: 'Transparansi Keuangan Daerah',
          alias: 'Regional Financial Transparency',
          src: 'img/ekonomi.png',
          href: 'http://bappedacilegon.emonev8.com/masuk.php?op=grafikata&o=fisikvsuang&idk=1',
        },
        {
          name: 'PPID Kota Cilegon',
          alias: 'Cilegon PPID',
          src: 'img/ppid.png',
          href: 'http://ppid.cilegon.go.id',
        }, 
        {
          name: 'Cilegon Smart City',
          alias: 'Cilegon Smart City',
          src: 'img/smart.png',
          href: 'https://qlue.city',
        },
          {
          name: 'Data Statistik Cilegon',
          alias: 'Cilegon Statistics',
          src: 'img/download.png',
          href: 'https://cilegonkota.bps.go.id',
        },
          {
          name: 'Wisata dan Kuliner',
          alias: 'Tour and Culinary',
          src: 'img/kuliner.png',
          href: 'http://keneke.cilegon.go.id',
        },
          {
          name: 'Satu Data Indonesia',
          alias: 'Satu Data Indonesia',
          src: 'img/satudata.png',
          href: 'https://data.go.id',
        },
          {
          name: 'Open Government',
          alias: 'Open Government',
          src: 'img/opengov.png',
          href: 'http://www.opengovindonesia.org',
        },
        {
          name: 'Tautan',
          alias: 'Link',
          src: 'img/tautan.png',
          href: '#',
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