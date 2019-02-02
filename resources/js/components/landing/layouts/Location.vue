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

    <div class="container">
      <div class="row">
        <div class="col">
          <b-carousel id="carousel1"
                  style="text-shadow: 1px 1px 2px #333;"
                  controls
                  indicators
                  background="#ababab"
                  :interval="4000"
                  img-width="1024"
                  img-height="480"
            >
            <b-carousel-slide
                          v-for="(location, index) in this.locations.data" :key="index" 
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
                  <!-- <a href="#"><strong>{{ location.category }}</strong></a>  -->
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
          </b-carousel>
        </div>
      </div>
    </div>
  </section>
</template>

<script>

import Rating from 'vue-star-rating'

export default {
  name: 'Location',
  components: {
    'star-rating': Rating
  },
  data () {
    return {
      locations: []
    }
  },
  created() {
    axios.get('/api/locations')
      .then(response => {
        this.locations = response.data
        console.log(this.locations)
      })
      .catch(error => {
        console.log(error)
      })
  }
}
</script>

<style lang="scss" scoped>

@import '../../../../sass/landing.scss';

a {

  color: #fff;

  &:hover {
    color: #eaeaea;
  }
}

.carousel-item {

  &::after {
    display: block;
    position: relative;
    background-image: linear-gradient(to top right, rgba(0, 47, 75, 0.5), rgba(248, 99, 69, 0.5));
    margin-top: -540px;
    height: 540px;
    width: 1280px;
    content: '';
  }

}

</style>