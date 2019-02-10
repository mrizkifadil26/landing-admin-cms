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
                  <b-form-input type="text"></b-form-input>
                  <b-input-group-append>
                    <b-button variant="primary">Search</b-button>
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
                :per-page="perPage">
                <template slot="actions" slot-scope="data">
                  <b-button variant="success" :to="{ path: `locations/show/${data.item.id}`, label: 'Show Location' }">Show</b-button>
                  <b-button variant="warning" :to="{ path: `locations/edit/${data.item.id}`, label: 'Edit Location' }">Edit</b-button>
                  <b-button variant="danger" :to="{ path: `locations/delete/${data.item.id}`, label: 'Delete Location' }">Delete</b-button>
                </template>
              </b-table>
              <spinner v-show="loading"></spinner>
              <nav>
                <b-pagination
                  :total-rows="totalRows"
                  :per-page="perPage" 
                  v-model="currentPage" 
                  prev-text="Prev" 
                  next-text="Next" 
                  hide-goto-end-buttons
                >
                </b-pagination>
              </nav>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

export default {
  name: 'LocationList',
  data() {
    return {
      loading: false,
      currentPage: 1,
      perPage: 10,
      locations: [],
      fields: [
        { key: 'location', label: 'Place', sortable: true},
        { key: 'description' },
        { key: 'address' },
        { key: 'avg_rating', label: 'Rating' },
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
    }
  },
  created() {
    this.getLocations()
  },
  computed: {
    totalRows: function() {
      return this.locations.length
    }
  }
}
</script>
