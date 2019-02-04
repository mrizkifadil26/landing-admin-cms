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
                fixed
                responsive="sm"
                :items="this.posts.data"
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
      showBadge: false,

      currentPage: 1,
      posts: [],
      offset: 5,
      pagination: {
        'current_page': 1
      },
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
  mounted() {
    // this.fetchData()
    axios.get(`/api/posts`)
      .then(response => {
        this.posts = response.data
        console.log(this.pagination)
      }).catch(error => {
        console.log(error)
      })
  },
  computed: {
    totalRows() {
      return this.posts.length
      // console.log(this.items.length)
    },
    pages() {
      let pages = []
      let from = this.pagination.current_page - Math.floor(this.offset / 2)
      if (from < 1) {
        from = 1
      }
      let to = from + this.offset - 1
      while (from <= to) {
        pages.push(from)
        from++
      }
      return pages
    }
  },
  methods: {
    fetchData() {
      axios.get(`/api/posts?page=${this.pagination.current_page}`)
      .then(response => {
        this.posts = response.data.data
        this.pagination = response.data.pagination
        console.log(this.pagination)
      }).catch(error => {
        console.log(error)
      })
    },
    isCurrentPage(page) {
      return this.pagination.current_page === page
    },
    changePage(page) {
      if (page > this.pagination.last_page) {
        page = this.pagination.last_page
      }
      this.pagination.current_page = page
    },
    getBadge (status) {
      return status === 'Published' ? 'primary' : 
        status === 'Draft' ? 'danger' : 'default';
    },
  }
}
</script>
