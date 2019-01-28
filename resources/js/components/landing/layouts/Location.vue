<template>
  <section id="location" class="bg-primary">
    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading">Lokasi Penting</h2>
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
                  v-model="slide"
                  @sliding-start="onSlideStart"
                  @sliding-end="onSlideEnd"
            >
            <b-carousel-slide
                          v-for="(location, index) in data" :key="index" 
                          :img-src="location.image">
                          
              <div class="row">
                <div class="col-md-9 text-left">
                  <h1>{{ location.title }}</h1>
                  <p>{{ location.description }}</p>
                  <p><i class="fas fa-tag"></i> <a href="#" v-for="(category, index) in location.category" :key="index">{{ category }}, </a></p>
                </div>
                <div class="col-md-3">
                  <!-- <a href="#"><strong>{{ location.category }}</strong></a>  -->
                  <h5>Rated:</h5>
                  <h1>{{ location.stars }}</h1>
                  <span>
                    <star-rating 
                      :star-size="15"
                      :inline="true"
                      :read-only="true"
                      :show-rating="false"
                      :round-start-rating="false"
                      :rating="location.stars"
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

const data = [
  {
    title: 'Hotel Merak',
    description: 'Hotel di samping pantai',
    category: ['Hotel', 'Beach'],
    stars: 5,
    image: 'https://picsum.photos/1024/480/?image=55',
  },
  {
    title: 'Hotel Merak',
    description: 'Hotel di samping pantai',
    category: ['Hotel'],
    stars: 5,
    image: 'https://picsum.photos/1024/480/?image=55',
  },
  {
    title: 'Hotel Merak',
    description: 'Hotel di samping pantai',
    category: ['Hotel'],
    stars: 5,
    image: 'https://picsum.photos/1024/480/?image=55',
  }
]

import Rating from 'vue-star-rating'

export default {
  name: 'Location',
  components: {
    'star-rating': Rating
  },
  data () {
    return {
      data
    }
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