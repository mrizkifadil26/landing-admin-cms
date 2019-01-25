<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong>Posts</strong> <small>Muhammad Rizki Fadillah</small>
          </div>
          <b-row class="mb-3">
            <b-col md="3">
              <b-button :to="{ name: 'Add Post' }" variant="primary"><i class="fas fa-plus"></i> Add Post</b-button>
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
                <template slot="status" slot-scope="data">
                  <b-badge :variant="getBadge(data.item.status)">{{ data.item.status }}</b-badge>
                </template>
                <template slot="actions" slot-scope="data">
                  <b-button variant="info" :to="{ name: 'Show Post' }">{{ data.item.actions[0] }}</b-button>
                  <b-button variant="warning" :to="{ name: 'Edit Post' }">{{ data.item.actions[1] }}</b-button>
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
  { title: 'Hai', writer: 'Rizki', category: 'Business', status: 'Published', actions: ['Show', 'Edit', 'Delete']}
]

export default {
  name: 'PostList',
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
        { key: 'title', label: 'Title', sortable: true},
        { key: 'writer' },
        { key: 'category' },
        { key: 'status' },
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
    getBadge (roles) {
      return roles === 'Published' ? 'primary' : 'danger';
    },
    getRowCount: function () {
      return this.items.length
    }
  }
}
</script>
