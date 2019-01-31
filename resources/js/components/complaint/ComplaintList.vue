<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong>Complaint List</strong> <small>Muhammad Rizki Fadillah</small>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="3">
              <b-button variant="primary"><i class="fas fa-download"></i> Export</b-button>
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
                :dark="dark"
                responsive="sm" 
                :items="items" 
                :fields="captions" 
                :current-page="currentPage" 
                :per-page="perPage">
                <template slot="actions" slot-scope="data">
                  <b-button variant="warning" :to="{ name: 'Change Status' }">{{ data.item.actions[0] }}</b-button>
                  <b-button variant="success" :to="{ name: 'Complaint Details' }">{{ data.item.actions[1] }}</b-button>
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

const data = () => [
  { complaint: 'Fix Street Lamp', pengadu: 'Rizki', category: 'Infrastruktur', actions: ['Change Status' ,'Details'] }
]

export default {
  name: 'ComplaintList',
  props: {
    caption: {
      type: String,
      default: 'Table'
    },
    hover: {
      type: Boolean,
      default: true
    },
    tableData: {
      type: [Array, Function],
      default: () => []
    },
    perPage: {
      type: Number,
      default: 5
    },
    dark: {
      type: Boolean,
      default: false
    }
  },
  data: () => {
    return {
      currentPage: 1,
      items: data,
      itemsArray: data(),
      fields: [
        { key: 'complaint', label: 'Aduan', sortable: true},
        { key: 'pengadu', label: 'Pengadu' },
        { key: 'category' },
        { key: 'actions' }
      ]
    }
  },
  computed: {
    totalRows: function () {
      return this.getRowCount()
    },
    captions: function () {
      return this.fields
    }
  },
  methods: {
    getBadge (role) {
      return role === 'Admin' ? 'primary' : 'warning';
    },
    getRowCount: function () {
      return this.items.length
    }
  }
}
</script>
