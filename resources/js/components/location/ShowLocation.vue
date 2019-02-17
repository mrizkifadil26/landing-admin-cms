<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>        
        <b-card>
          <div slot="header">
            <i class="fas fa-eye"></i> <strong> Location Details</strong>
          </div>
          <b-row>
            <b-col md="12" class="mb-3">
              <b-table 
                stacked
                :items="[location]"
                :fields="fields">
                <template slot="category" slot-scope="data">
                  <b-badge v-for="(category, index) in data.item.category" :key="index" variant="warning" class="mr-1">{{ category.location_category }}</b-badge>
                </template>
                <template slot="avg_rating" slot-scope="data">
                  <star-rating 
                    :star-size="30"
                    :read-only="true"
                    :round-start-rating="false"
                    :rating="parseFloat(data.item.avg_rating)"
                    text-class="custom-text">
                  </star-rating>
                </template>
                <template slot="ratings" slot-scope="data">
                  {{ data.item.ratings.length }} people
                </template>
              </b-table>
              <spinner v-if="loading"></spinner>
            </b-col>
          </b-row>
          <hr>
          <b-row class="mb-3">
            <b-col>
              <h3 class="mb-2">Photos</h3>
              <b-row>
                <b-col v-if="loading" md="12">
                  <spinner></spinner>
                </b-col>
                <b-col class="text-center text-muted" v-if="location.photos < 1" md="12" sm="12">
                  <p>No Image</p>
                </b-col>
                <b-col md="12" sm="12" v-else>
                  <b-row>
                    <b-col md="3" sm="4" 
                      v-for="(photo, index) in location.photos" :key="index">
                      <b-link
                        @click="openLightbox(index)">
                        <b-img-lazy                        
                          thumbnail
                          class="mr-3 mb-3"
                          blank-color="#bbb"
                          width="200"
                          :src="photo.image_link"
                          :alt="photo.image_name" />
                      </b-link>
                    </b-col>
                  </b-row>
                  <vue-image-lightbox-carousel 
                    ref="lightbox"
                    :show="showLightbox"
                    @close="showLightbox = false"
                    :images="photos"
                    @change="changeImage"></vue-image-lightbox-carousel>
                </b-col>
              </b-row>
            </b-col>
          </b-row>
          <hr>
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
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

import Rating from 'vue-star-rating'
import VueImageLightboxCarousel from 'vue-image-lightbox-carousel'
import Review from '../helpers/Review'
import Swal from 'sweetalert2'

export default {
  name: 'ShowLocation',
  components: {
    'star-rating': Rating,
    Review,
    VueImageLightboxCarousel
  },
  data () {
    return {
      loading: false,

      review: {
        rating: null,
        review: ''
      },

      fields: [
        { key: 'location' }, 
        { key: 'description' },
        { key: 'address' },
        { key: 'category' }, 
        { key: 'avg_rating', label: 'Rating' },
        { key: 'ratings', label: 'Rated by'}
      ],
      location: {},
      showLightbox: false,
    }
  },
  computed: {
    isLoggedIn () {
      return this.$store.getters['authentication/isLoggedIn']
    },
    user () {
      return this.$store.getters['authentication/currentUser']
    },
    photos () {
      return this.getPhotos()
    }
  },
  created () {
    this.getLocation()
  },
  methods: {

    getPhotos () {
      return this.location.photos.map(i => {
        return {
          url: i.image_link,
          caption: i.image_name
        }
      })
    },

    openLightbox (id) {
      this.showLightbox = true
      this.$refs.lightbox.showImage(id)
    },
    changeImage (index) {
      console.log(index)
    },

    getLocation() {
      this.loading = true
      const locationId = this.$route.params.id
      window.axios.get(`/api/locations/${locationId}`)
        .then(response => {
          this.loading = false
          this.location = response.data.data
          console.log(this.location)
        })
        .catch(error => {
          this.loading = false
          console.error(error)
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
  }
}
</script>

<style>

.custom-text {
  font-family: 'Raleway', sans-serif;
  font-weight: bold;
  font-size: 1.5em;
  border: 1px solid #cfcfcf;
  padding-left: 10px;
  padding-right: 10px;
  border-radius: 5px;
  color: #999;
  background: #fff;
}

</style>


