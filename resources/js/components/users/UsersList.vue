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
                fixed hover
                class="animated fadeIn"
                responsive="sm" 
                :items="users" 
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage">
                <template slot="role.name" slot-scope="data">
                  <b-badge :variant="getBadge(data.item.role.name)">{{ data.item.role.name | capitalize }}</b-badge>
                </template>
                <template slot="avatar" slot-scope="data">
                  <b-img-lazy rounded="circle" width="96" height="96" center thumbnail fluid :src="data.item.avatar.avatar_link" alt="Thumbnail" />
                </template>
                <template slot="actions" slot-scope="data">
                  <b-button class="mb-1" variant="success" :to="{ label: 'Show User', path: 'users/show/', params: { id: data.item.id } }">{{ data.value = 'Show' }}</b-button>
                  <b-button class="mb-1" variant="warning" :to="{ label: 'Edit User', path: 'users/edit/', params: { id: data.item.id }}">{{ data.value = 'Edit' }}</b-button>
                  <b-button variant="danger" @click="deleteUser(data.item.id)">{{ data.value = 'Delete' }}</b-button>
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

import Swal from 'sweetalert2'

export default {
  name: 'UsersList',
  data() {
    return {
      currentPage: 1,
      loading: false,
      perPage: 10,
      users: [],
      fields: [
        { key: 'avatar', tdClass: "align-middle" },
        { key: 'name', label: 'Name', sortable: true, tdClass: "align-middle" },        
        { key: 'username', tdClass: "align-middle" },
        { key: 'role.name', label: 'Role', tdClass: "align-middle" },
        { key: 'actions', tdClass: "align-middle" },
      ]
    }
  },
  filters: {
    capitalize: function(value) {
      if (!value) return ''
      value.toString()
      return value.charAt(0).toUpperCase() + value.slice(1)
    }
  },
  created () {
    this.getUsers()
  },
  computed: {
    totalRows() {
      return this.getRowCount()
    },
  },
  methods: {
    getUsers () {
      this.loading = true
      axios.get('/api/users')
        .then(response => {
          this.loading = false
          this.users = response.data.data
          console.log(this.users)
        }).catch(error => {
          this.loading = false
          console.log(error)
        })
    },
    deleteUser (id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will delete the selected user.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      }).then((result) => {
        if (result.value) {
          window.axios.delete(`/api/users/${id}`)
            .then(response => {
              Swal.fire(
                'Deleted!',
                'This user has been deleted.',
                'success'
              )
              const index = this.users.findIndex(user => user.id === id)
              if (~index) {
                this.users.splice(index, 1)
              }
            })
            .catch(error => {
              Swal.fire(
                'Error!',
                'Error deleting user',
                'error'
              )
            })
        }
      })
    },
    getBadge (role) {
      return role === 'admin' ? 'primary' : 'danger';
    },
    getRowCount: function () {
      return this.users.length
    },
  },
}
</script>
