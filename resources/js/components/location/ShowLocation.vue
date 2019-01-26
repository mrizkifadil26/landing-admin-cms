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
                  <b-img rounded="square" fluid src="https://picsum.photos/200/200/?image=54" alt="Image" />
                </b-col>
              </b-row>
            </b-col>

            <b-col md="8" class="mb-3">
              
              <b-table 
                stacked
                :items="items">
                <template slot="rating" slot-scope="data">
                  
                </template>
              </b-table>
            </b-col>
          </b-row>

          <b-row class="mb-3">
            <b-col>
              <h1>Location</h1>
              <map-view></map-view>
            </b-col>
          </b-row>

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
    // 'gallery-view': GalleryView,
  },
  data () {
    return {
      fields: ['location', 'description', 'category', 'rating'],
      items: data,
    }
  },
  methods: {

  }
}
</script>

