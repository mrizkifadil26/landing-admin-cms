<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong>Posts</strong> <small>Muhammad Rizki Fadillah</small>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="3">
              <b-button :to="{ name: 'Add Post' }" variant="primary"><i class="fas fa-plus"></i> Add Post</b-button>
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
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage">
                <template slot="posted_by" slot-scope="data">
                  {{ data.item.posted_by.name }}
                </template>
                <template slot="category_id" slot-scope="data">
                  {{ data.item.category.post_category }}
                </template>
                <template slot="status" slot-scope="row">
                  <b-badge :variant="row.value == 'Published' ? 'danger': 'success' ">Published</b-badge>
                </template>
                <template slot="actions" slot-scope="row">
                  <b-button variant="success" :to="{ path: '/show/:id', label: 'Show Post' }">{{ row.value = 'Show' }}</b-button>
                  <b-button variant="warning" :to="{ path: '/edit/:id', label: 'Edit Post' }">{{ row.value = 'Edit' }}</b-button>
                  <b-button variant="danger" :to="{ path: '/delete/:id', label: 'Delete Post' }">{{ row.value = 'Delete' }}</b-button>
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
  name: 'PostList',
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
      items: [],
      perPage: 10,
      fields: [
        { key: 'title', label: 'Title', sortable: true},
        { key: 'posted_by', sortable: true },
        { key: 'category_id', label: 'Category' },
        { key: 'status', sortable: true },
        { key: 'actions', label: 'Actions' }
      ],
      status: ['Published', 'Draft'],
      actions: ['Show', 'Edit', 'Delete']
    }
  },
  mounted() {
    axios.get('http://localhost:8000/api/posts')
      .then(response => {
        this.items = response.data
        console.log(response.data)
      }).catch(error => {
        console.log(error)
      })
  },
  computed: {
    totalRows: function() {
      return this.items.length
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
