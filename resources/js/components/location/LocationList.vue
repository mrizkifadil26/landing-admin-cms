<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-map-marker-alt"></i><strong> Location List</strong>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="4 mb-3">
              <b-button :to="{ name: 'Add Location' }" variant="primary"><i class="fas fa-plus"></i> Add Location</b-button>
            </b-col>
            <b-col md="4 ml-auto" sm="6 ml-auto">
              <b-form-group>
                <b-input-group>
                  <b-form-input 
                    type="text" 
                    placeholder="Type to Search"
                    v-model="filter"></b-form-input>
                  <b-input-group-append>
                    <b-button 
                      variant="primary"
                      :disabled="!filter" 
                      @click="filter = ''">Clear</b-button>
                  </b-input-group-append>
                </b-input-group>
              </b-form-group>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <b-table
                fixed hover
                responsive="sm" 
                :items="this.locations" 
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage"
                :filter="filter"
                @filtered="onFiltered">
                <template slot="category" slot-scope="data">
                  <b-badge v-for="(category, index) in data.item.category" :key="index" variant="warning" class="mr-1">{{ category.location_category }}</b-badge>
                </template>
                <template slot="avg_rating" slot-scope="data">
                  <span class="custom-text">{{ data.item.avg_rating }}</span>
                  <br>
                  <rating 
                    :star-size="20"
                    :read-only="true"
                    :round-start-rating="false"
                    :inline="true"
                    :show-rating="false"
                    :rating="parseFloat(data.item.avg_rating)">
                  </rating>
                </template>
                <template slot="actions" slot-scope="data">
                  <b-button class="mb-1" variant="success" :to="{ path: `locations/show/${data.item.id}`, label: 'Show Location' }">Show</b-button>
                  <b-button class="mb-1" variant="warning" :to="{ path: `locations/edit/${data.item.id}`, label: 'Edit Location' }">Edit</b-button>
                  <b-button class="mb-1" variant="danger" @click="deleteLocation(data.item.id)">Delete</b-button>
                </template>
              </b-table>
              <spinner v-show="loading"></spinner>
              <b-row>
                <b-col>
                  <nav>
                    <b-pagination
                      :total-rows="totalRows"
                      :per-page="perPage" 
                      v-model="currentPage" 
                      prev-text="Prev" 
                      next-text="Next" 
                      hide-goto-end-buttons>
                    </b-pagination>
                  </nav>
                </b-col>
                <b-col md="4" class="ml-auto">
                  <h5 class="float-right">Total: {{ locations.length }}</h5>
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

import Swal from 'sweetalert2'
import Rating from 'vue-star-rating'

export default {
  name: 'LocationList',
  components: {
    Rating,
  },
  data() {
    return {
      loading: false,
      currentPage: 1,
      perPage: 5,
      filter: null,
      locations: [],
      fields: [
        { key: 'location', label: 'Place', sortable: true },
        { key: 'category', label: 'Category', sortable: true },
        { key: 'address', sortable: true },
        { key: 'avg_rating', label: 'Rating', sortable: true, tdClass: 'text-center' },
        { key: 'actions' }
      ]
    }
  },
  methods: {
    getLocations() {
      this.loading = true
      axios.get('/api/locations')
      .then(response => {
        this.loading = false
        this.locations = response.data.data
        console.log(this.locations)
      })
      .catch(error => {
        this.loading = false
        console.log(error)
      })
    },
    deleteLocation (id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will delete the selected location.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      })
        .then((result) => {
          if (result.value) {
            window.axios.delete(`/api/locations/${id}`)
              .then(response => {
                Swal.fire(
                  'Deleted!',
                  'This location has been deleted.',
                  'success'
                )
                const index = this.locations.findIndex(location => location.id === id)
                if (~index) {
                  this.locations.splice(index, 1)
                }
              })
              .catch(error => {
                Swal.fire(
                  'Error!',
                  'Error deleting location',
                  'error'
                )
              })
          }
      })
    },
    onFiltered (filteredItems) {
      this.totalRows = filteredItems.length
      this.currentPage = 1
    }
  },
  created() {
    this.getLocations()
  },
  computed: {
    totalRows: function() {
      return this.locations.length
    },
    sortOptions() {
      // Create an options list from our fields
      return this.fields
        .filter(f => f.sortable)
        .map(f => {
          return { text: f.label, value: f.key }
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