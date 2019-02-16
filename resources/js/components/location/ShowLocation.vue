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
                <spinner v-if="loading"></spinner>
                <b-col class="text-center text-muted" v-if="location.gallery < 1">
                  <p>No Image</p>
                </b-col>
                <b-col v-else>
                  <b-img-lazy
                    v-for="(photo, index) in location.gallery" :key="index"
                    class="mr-3 mb-3"
                    blank-color="#bbb"
                    width="330"
                    :src="photo.image_link"
                    :alt="photo.image_name" />
                </b-col>
              </b-row>
            </b-col>
          </b-row>

        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

// import Maps from '../helpers/Maps'
import Rating from 'vue-star-rating'

export default {
  name: 'ShowLocation',
  components: {
    // 'map-view': Maps,
    'star-rating': Rating,
  },
  data () {
    return {
      loading: false,

      fields: [
        { key: 'location' }, 
        { key: 'description' },
        { key: 'address' },
        { key: 'category' }, 
        { key: 'avg_rating', label: 'Rating' },
        { key: 'ratings', label: 'Rated by'}
      ],
      location: null,
      // locations: [],
    }
  },
  created () {
    this.getLocation()
  },
  methods: {
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
    }
  }
}
</script>

<style scoped>

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


