<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-calendar"></i><strong> Events</strong>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="3">
              <b-button :to="{ name: 'Add Event' }" variant="primary"><i class="fas fa-plus"></i> Add Event</b-button>
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
                hover
                fixed
                responsive="sm"
                :items="this.events.data" 
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage">
                <template slot="actions" slot-scope="data">
                  <b-button variant="success" :to="{ path: `events/show/${data.item.id}`, label: 'Show Event' }"><i class="fas fa-eye"></i></b-button>
                  <b-button variant="warning" :to="{ path: `events/edit/${data.item.id}`, label: 'Edit Event' }"><i class="fas fa-marker"></i></b-button>
                  <b-button variant="danger" :to="{ path: `events/delete/${data.item.id}`, label: 'Delete Event' }"><i class="fas fa-trash"></i></b-button>
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
  name: 'EventList',
  props: {
    hover: {
      type: Boolean,
      default: true
    },
    dark: {
      type: Boolean,
      default: false
    },
  },
  data: () => {
    return {
      currentPage: 1,
      events: [],
      perPage: 5,
      fields: [
        { key: 'event', sortable: true},
        { key: 'description', sortable: true },
        { key: 'date' },
        { key: 'location', sortable: true },
        { key: 'actions', label: 'Actions' }
      ],
    }
  },
  mounted() {
    axios.get('/api/events')
      .then(response => {
        this.events = response.data
        console.log(response.data)
      }).catch(error => {
        console.log(error)
      })
  },
  computed: {
    totalRows: function totalRows() {
      return this.events.length
      // console.log(this.items.length)
    }
  },
  methods: {
    getBadge (status) {
      return status === 'Published' ? 'primary' : 
        status === 'Draft' ? 'danger' : 'default';
    },
  }
}
</script>
