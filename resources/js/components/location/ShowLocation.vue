<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>        
        <b-card>
          <div slot="header">
            <i class="fas fa-marker"></i> <strong> Location Details</strong>
          </div>
          <b-row>
            
            <b-col md="4" class="mb-3">
              <b-row class="text-center mb-3">
                <b-col>
                  <b-img rounded="square" thumbnail fluid src="https://picsum.photos/200/200/?image=54" alt="Image" />
                </b-col>
              </b-row>
            </b-col>

            <b-col md="8" class="mb-3">
              
              <b-table 
                stacked
                :items="items">
                <template slot="rating" slot-scope="data">
                  <star-rating 
                    :star-size="30"
                    :read-only="true"
                    :rating="data.item.rating"
                    text-class="custom-text">
                  </star-rating>
                </template>
              </b-table>
            </b-col>
          </b-row>
          <hr>
          <b-row class="mb-3">
            <b-col>
              <h1>Location</h1>
              <map-view></map-view>
            </b-col>
          </b-row>
          <hr>
          <b-row class="mb-3">
            <b-col>
              <h1>Gallery</h1>
              <gallery-view></gallery-view>
            </b-col>
          </b-row>

        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

import Maps from '../helpers/Maps'
import Rating from 'vue-star-rating'
import Gallery from '../helpers/Gallery'

const data = () => [
        {
          title: 'Hotel Merak',
          description: 'Hotel dipinggir Pantai Merak',
          category: 'Hotel',
          rating: 5
        }
      ]

export default {
  name: 'ShowLocation',
  components: {
    'map-view': Maps,
    'star-rating': Rating,
    'gallery-view': Gallery,
  },
  data () {
    return {
      fields: ['location', 'description', 'category', 'reted'],
      items: data,
    }
  },
  methods: {

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


