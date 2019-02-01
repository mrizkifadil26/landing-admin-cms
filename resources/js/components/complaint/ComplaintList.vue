<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-list"></i> <strong>Complaint List</strong>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="3">
              <!-- <b-button variant="primary"><i class="fas fa-download"></i> Export</b-button> -->
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
                :hover="hover"
                :items="items" 
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage">
                <template slot="actions" slot-scope="row">
                  <b-button variant="warning" :to="{ name: 'Change Status' }">{{ row.value = "Change Status" }}</b-button>
                  <b-button variant="success" :to="{ path: 'show/' + row.value, name: 'Complaint Details' }">{{ row.value = "Complaint Details" }}</b-button>
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
  name: 'ComplaintList',
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
  data () {
    return {
      currentPage: 1,
      items: [],
      fields: [
        { key: 'complaint', label: 'Complaint', sortable: true},
        { key: 'complaint_by', label: 'Complaint By' },
        { key: 'category' },
        { key: 'status' },
        { key: 'actions' }
      ]
    }
  },
  created () {
    axios.get('/api/complaints')
      .then(response => {
        this.items = response.data
        console.log(response)
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
    getBadge (status) {
      return status === 'Handled' ? 'primary' : 'warning';
    },
    getRowCount: function () {
      return this.items.length
    }
  }
}
</script>
