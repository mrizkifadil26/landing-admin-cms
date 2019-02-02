<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-user"></i><strong> Users</strong>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="3">
              <b-button :to="{ name: 'Add User' }" variant="primary"><i class="fas fa-plus"></i> Add User</b-button>
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
                responsive="sm" 
                :items="this.users.data" 
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage">
                <template slot="avatar" slot-scope="data">
                  <b-img rounded="circle" width="64" center thumbnail fluid :src="'/img/' + data.item.avatar" alt="Thumbnail" />
                </template>
                <template slot="actions" slot-scope="data">
                  <b-button class="mb-1" variant="success" :to="{ name: 'Show User', path: `users/show/${data.item.id}` }">{{ data.value = 'Show' }}</b-button>
                  <b-button class="mb-1" variant="warning" :to="{ name: 'Edit User', path: `users/edit/${data.item.id}`}">{{ data.value = 'Edit' }}</b-button>
                  <b-button class="mb-1" variant="danger" :to="{ name: 'Delete User', path: `users/delete/${data.item.id}`}">{{ data.value = 'Delete' }}</b-button>
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

// let items = []

export default {
  name: 'UsersList',
  data() {
    return {
      currentPage: 1,
      perPage: 10,
      users: [],
      fields: [
        { key: 'avatar', tdClass: "align-middle" },
        { key: 'name', label: 'Name', sortable: true, tdClass: "align-middle" },        
        { key: 'username', tdClass: "align-middle" },
        { key: 'role', tdClass: "align-middle" },
        { key: 'actions', tdClass: "align-middle" },
      ]
    }
  },
  mounted () {
    axios.get('/api/users')
      .then(response => {
        this.users = response.data
        console.log(response.data)
      }).catch(error => {
        console.log(error)
      })
  },
  computed: {
    totalRows: function () {
      return this.getRowCount()
    },
  },
  methods: {
    getBadge (role) {
      return role === 'Admin' ? 'primary' : 'warning';
    },
    getRowCount: function () {
      return this.users.length
    }
  }
}
</script>
