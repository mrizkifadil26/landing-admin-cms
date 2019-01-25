<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong>Users List</strong> <small>Muhammad Rizki Fadillah</small>
          </div>
          <b-row class="mb-3">
            <b-col md="3">
              <b-button :to="{ name: 'Add User' }" variant="primary"><i class="fas fa-plus"></i> Add User</b-button>
            </b-col>
            <b-col md="4 ml-auto">
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
                  <b-button variant="info" :to="{ name: 'Show User' }">{{ data.item.actions[0] }}</b-button>
                  <b-button variant="warning" :to="{ name: 'Edit User' }">{{ data.item.actions[1] }}</b-button>
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

const data = () => [
  { image: 'avatar.jpg', name: 'Muhammad Rizki Fadillah', username: 'mrizkifadil26', role: 'Admin', actions: ['Show', 'Edit', 'Delete'] }
]

export default {
  name: 'UsersList',
  props: {
    userId: {
      type: Number,
      required: true
    },
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
        { key: 'name', label: 'Name', sortable: true},
        { key: 'username' },
        { key: 'role' },
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
