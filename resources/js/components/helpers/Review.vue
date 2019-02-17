<template>
  <div>
    <h3>Reviews:</h3>
    <spinner v-if="loading"></spinner>
    <b-row v-for="review in reviews" :key="review.id" class="mb-1">
      <b-container>
        <hr>
        <b-row>
          <b-col md="1" sm="2">
            <b-img-lazy
                  rounded
                  class="mb-3" 
                  :src="review.user.link" 
                  width="72" />
          </b-col>
          <b-col>
            <strong>{{ review.user.name }}</strong>
            <small>on {{ review.created_at }}</small>
            <h6>
              <rating
                :star-size="20"
                :read-only="true"
                :inline="true"
                :show-rating="false"
                :rating="parseInt(review.rating)">
              </rating>
            </h6>
            <p class="mt-2">{{ review.review }}</p>
          </b-col>
        </b-row>
      </b-container>
    </b-row>
  </div>
</template>

<script>

import Rating from 'vue-star-rating'

export default {
  name: 'Review',
  components: {
    Rating
  },
  props: ['location'],
  data () {
    return {
      loading: false, 

      reviews: []
    }
  },
  methods: {
    getReviews (id) {
      this.loading = true
      window.axios.get('/api/ratings?location_id=' + id)
        .then(response => {
          this.loading = false
          this.reviews = response.data.data
          console.log(this.reviews)
        })
        .catch(error => {
          this.loading = false
          console.log(error)
        })
    }
  },
  created () {
    setTimeout(() => {
      this.getReviews(this.location)
    }, 1000)
  },
  watch: {
    '$route': 'getReviews'
  }
}

</script>

