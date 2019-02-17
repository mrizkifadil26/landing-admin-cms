<template>
  <section id="location" class="bg-primary">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading">Lokasi Istimewa</h2>
          <hr class="my-4 light">
        </div>
      </div>
    </div>

    <b-container>
      <b-row>
        <b-col>
          <spinner v-if="loading"></spinner>
          <swiper :options="swiperOption">
            <swiper-slide class="text-center" v-for="location in locations" :key="location.id">
              <b-card
                :img-src="location.gallery.length < 1 ? 'https://via.placeholder.com/800x350' : location.gallery[0].image_link"
                :img-alt="location.image.image_name" 
                class="mx-2 text-dark text-left">
                <h3>{{ location.location }}</h3>
                <p class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ location.address }}</p>
                <span>Tags <i class="fas fa-tag"></i></span>
                <b-badge v-for="(category, index) in location.category" :key="index" class="mr-1" variant="warning">{{ category.location_category }}</b-badge>
                <b-row class="mt-3">
                  <b-col md="8">
                    <p>{{ location.description | truncate(50, '...') }}</p>
                    <b-button variant="primary">Read more</b-button>
                  </b-col>
                  <b-col md="4" class="text-center">
                    <h5>Rated:</h5>
                    <h1>{{ location.avg_rating }}</h1>
                    <span>
                      <star-rating 
                        :star-size="15"
                        :inline="true"
                        :read-only="true"
                        :show-rating="false"
                        :round-start-rating="false"
                        :rating="parseFloat(location.avg_rating)"
                        text-class="text"
                        >
                      </star-rating>                
                    </span>
                  </b-col>
                </b-row> 
              </b-card>
            </swiper-slide>
            <div class="swiper-button-prev" slot="button-prev"></div>
            <div class="swiper-button-next" slot="button-next"></div>
          </swiper>
          <!-- <b-carousel id="carousel1"
                  style="text-shadow: 1px 1px 2px #333;"
                  controls
                  indicators
                  background="#ababab"
                  :interval="4000"
                  img-width="1024"
                  img-height="480"
            >
            <b-carousel-slide
                          v-for="(location, index) in this.locations" :key="index" 
                          :img-src="location.image.image_link">
                          
              <div class="row">
                <div class="col-md-9 col-sm-3 text-left">
                  <div class="mb-3">
                    <h1>{{ location.location }}</h1>
                    <span>{{ location.address }}</span>
                  </div>
                  <p>{{ location.description }}</p>
                  <p><i class="fas fa-tag"></i> <a href="#" v-for="(category, index) in location.category" :key="index">{{ category }}, </a></p>
                </div>
                <div class="col-md-3 col-sm-3 ml-auto">
                  <h5>Rated:</h5>
                  <h1>{{ location.avg_rating }}</h1>
                  <span>
                    <star-rating 
                      :star-size="15"
                      :inline="true"
                      :read-only="true"
                      :show-rating="false"
                      :round-start-rating="false"
                      :rating="parseFloat(location.avg_rating)"
                      text-class="text"
                      >
                    </star-rating>                
                  </span>
                </div>
              </div>
              
            </b-carousel-slide>
          </b-carousel> -->
        </b-col>
      </b-row>
    </b-container>
  </section>
</template>

<script>

import Rating from 'vue-star-rating'
import { swiper, swiperSlide } from 'vue-awesome-swiper'

export default {
  name: 'Location',
  components: {
    'star-rating': Rating,
    'swiper': swiper,
    'swiper-slide': swiperSlide
  },
  data () {
    return {
      loading: false,
      locations: [],

      swiperOption: {
        autoplay: true,
        slidesPerView: '3',
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev'
        }
      }
    }
  },
  filters: {
    truncate (text, length, suffix) { 
      if (text.length > length) {
        return text.substring(0, length) + suffix;
      }
        return text.substring(0, length)
      },
  },
  created() {
    this.loading = true
    axios.get('/api/locations')
      .then(response => {
        this.loading = false
        this.locations = response.data.data
      })
      .catch(error => {
        this.loading = false
        console.log(error)
      })
  }
}
</script>

<style lang="scss" scoped>

@import '../../../../sass/landing.scss';

.btn {
  text-transform: capitalize;
  font-weight: 500;
  border-radius: 0.25rem;
  color: #fff;
}

.btn.page-link {
  color: #2C9DD9;
}

</style>