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
              <b-alert variant="success" dismissible :show="showBadge">Success</b-alert>
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
                  {{ data.item.posted_by.name }}
                </template>
                <template slot="category_id" slot-scope="data">
                  {{ data.item.category.post_category }}
                </template>
                <template slot="status" slot-scope="row">
                  <b-badge :variant="row.value == 'Published' ? 'danger': 'success' ">Published</b-badge>
                </template>
                <template slot="actions" slot-scope="data">
                  <b-button variant="success" :to="{ path: `news/show/${data.item.id}`, label: 'Show Post' }">{{ data.value = 'Show' }}</b-button>
                  <b-button variant="warning" :to="{ path: `news/edit/${data.item.id}`, label: 'Edit Post' }">{{ data.value = 'Edit' }}</b-button>
                  <b-button variant="danger" :to="{ path: `news/delete/${data.item.id}`, label: 'Delete Post' }">{{ data.value = 'Delete' }}</b-button>
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
  name: 'PostList',
  data() {
    return {
      showBadge: false,
      loading: false,

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
    getPosts: function () {
      this.loading = true
      axios.get(`/api/posts`)
        .then(response => {
          this.loading = false
          this.posts = response.data.data
          console.log(this.pagination)
        }).catch(error => {
          this.loading = false
          console.log(error)
        })   
    },
    getRowCount: function () {
      return this.posts.length
    },
    getBadge: function (status) {
      return status === 'Published' ? 'primary' : 
        status === 'Draft' ? 'danger' : 'default';
    },
  }
}
</script>
