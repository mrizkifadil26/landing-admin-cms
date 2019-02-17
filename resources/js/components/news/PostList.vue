<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-newspaper"></i><strong> Posts</strong>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="3">
              <b-button :to="{ name: 'Add Post' }" variant="primary"><i class="fas fa-plus"></i> Add Post</b-button>
            </b-col>
            <b-col md="4 ml-auto" sm="6 ml-auto">
              <b-form-group>
                <b-input-group>
                  <b-form-input type="text" v-model.lazy="keywords"></b-form-input>
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
                :items="this.posts"
                :fields="fields" 
                :current-page="currentPage" 
                :per-page="perPage">
                <template slot="posted_by" slot-scope="data">
                  <b-link :to="{ path: `/admin/users/show/${data.item.posted_by.id}` }">{{ data.item.posted_by.name }}</b-link>
                  <p><small>{{ data.item.created_at }}</small></p>
                </template>
                <template slot="category_id" slot-scope="data">
                  <b-badge variant="warning">{{ data.item.category.post_category }}</b-badge>
                </template>
                <template slot="status" slot-scope="row">
                  <b-badge :variant="row.value == 'Published' ? 'danger': 'success' ">Published</b-badge>
                </template>
                <template slot="actions" slot-scope="data">
                  <b-button class="mb-1" variant="success" :to="{ path: `news/show/${data.item.id}`, label: 'Show Post' }">{{ data.value = 'Show' }}</b-button>
                  <b-button class="mb-1" variant="warning" :to="{ path: `news/edit/${data.item.id}`, label: 'Edit Post' }">{{ data.value = 'Edit' }}</b-button>
                  <b-button class="mb-1" variant="danger" @click="deletePost(data.item.id)">{{ data.value = 'Delete' }}</b-button>
                </template>
              </b-table>
              <spinner v-if="loading"></spinner>
              <nav>
                <b-pagination
                  :total-rows="totalRows"
                  :per-page="perPage" 
                  v-model="currentPage" 
                  prev-text="Prev" 
                  next-text="Next" 
                  hide-goto-end-buttons>
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
  name: 'PostList',
  data() {
    return {
      loading: false,
      search: false,
      keywords: '',
      results: [],

      currentPage: 1,
      posts: [],
      perPage: 10,
      fields: [
        { key: 'title', label: 'Title', sortable: true},
        { key: 'posted_by', sortable: true },
        { key: 'category_id', label: 'Category' },
        { key: 'status', sortable: true },
        { key: 'actions', label: 'Actions' }
      ],
    }
  },
  created() {
    this.getPosts()
  },
  computed: {
    totalRows() {
      return this.getRowCount()
    },
  },
  methods: {
    getPosts () {
      this.loading = true
      window.axios.get(`/api/posts`)
        .then(response => {
          this.loading = false
          this.posts = response.data.data
        }).catch(error => {
          this.loading = false
          console.log(error)
        })   
    },
    deletePost (id) {
      Swal.fire({
        title: 'Are you sure?',
        text: "You will delete the selected post.",
        type: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Delete'
      })
        .then((result) => {
          if (result.value) {
            window.axios.delete(`/api/posts/${id}`)
              .then(response => {
                Swal.fire(
                  'Deleted!',
                  'This post has been deleted.',
                  'success'
                )
                const index = this.posts.findIndex(post => post.id === id)
                if (~index) {
                  this.posts.splice(index, 1)
                }
              })
              .catch(error => {
                Swal.fire(
                  'Error!',
                  'Error deleting post',
                  'error'
                )
              })
          }
      })
    },
    getRowCount () {
      return this.posts.length
    },
    getBadge (status) {
      return status === 'Published' ? 'primary' : 
        status === 'Draft' ? 'danger' : 'default'
    },
  },
  watch: {
    '$route': 'getPosts',
  }
}
</script>
