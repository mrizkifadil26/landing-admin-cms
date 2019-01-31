<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong>Users List</strong> <small>Muhammad Rizki Fadillah</small>
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
                :items="items.data" 
                :fields="captions" 
                :current-page="currentPage" 
                :per-page="perPage">
                <template slot="avatar" slot-scope="data">
                  <b-img rounded="circle" width="64" center thumbnail fluid :src="'/img/' + data.item.avatar" alt="Thumbnail" />
                </template>
                <template slot="actions" slot-scope="row">
                  <b-button class="mb-1" variant="success" :to="{ name: 'Show User' }">{{ row.value = "Show"  }}</b-button>
                  <b-button class="mb-1" variant="warning" :to="{ name: 'Edit User' }">{{ row.value = "Edit" }}</b-button>
                  <b-button class="mb-1" variant="danger">{{ row.value = "Delete" }}</b-button>
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

import axios from 'axios'

// let items = []

export default {
  name: 'UsersList',
  props: {
    hover: {
      type: Boolean,
      default: true
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
      items: [],
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
    axios.get('http://localhost:8000/api/users')
      .then(response => {
        this.items = response.data
        console.log(response.data)
      }).catch(error => {
        console.log(error)
      })
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
