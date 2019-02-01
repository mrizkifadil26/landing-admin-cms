<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong>Location List</strong> <small>Muhammad Rizki Fadillah</small>
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
                dark="dark"
                responsive="sm" 
                :items="locations" 
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage">
                <template slot="actions" slot-scope="data">
                  <b-button variant="success" :to="{ name: 'Show Location' }">{{ data.item.actions[0] }}</b-button>
                  <b-button variant="warning" :to="{ name: 'Edit Location' }">{{ data.item.actions[1] }}</b-button>
                  <b-button variant="danger">{{ data.item.actions[2] }}</b-button>
                </template>
              </b-table>
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
  props: {
    hover: {
      type: Boolean,
      default: true
    },
    perPage: {
      type: Number,
      default: 5
    },
  },
  data() {
    return {
      currentPage: 1,
      locations: [],
      fields: [
        { key: 'place', label: 'Place', sortable: true},
        { key: 'category' },
        { key: 'stars' },
        { key: 'actions' }
      ]
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
  },  
  computed: {
    totalRows: function () {
      return this.getRowCount()
    }
  },
  methods: {
    getRowCount: function () {
      return this.items.length
    }
  }
}
</script>
