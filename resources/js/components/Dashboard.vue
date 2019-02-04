<template>
  <div class="animated fadeIn">
    <b-row>

      <b-col sm="6" lg="3">
        <b-card class="text-white bg-success">
          <div class="h3 text-muted text-right mb-4">
            <i class="far fa-newspaper"></i>
          </div>
          <h1 class="h1 mb-0">{{ count.post }}</h1>
          <small class="text-muted text-uppercase font-weight-bold">Post(s)</small>  
        </b-card>
      </b-col>

      <b-col sm="6" lg="3">
        <b-card class="text-white bg-primary">
          <div class="h3 text-muted text-right mb-4">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <h1 class="h1 mb-0">{{ count.location }}</h1>
          <small class="text-muted text-uppercase font-weight-bold">Location(s)</small>  
        </b-card>
      </b-col>

      <b-col sm="6" lg="3">
        <b-card class="text-white bg-danger">
          <div class="h3 text-muted text-right mb-4">
            <i class="fas fa-list"></i>
          </div>
          <h1 class="h1 mb-0">{{ count.complaint }}</h1>
          <small class="text-muted text-uppercase font-weight-bold">Complaint(s)</small>  
        </b-card>
      </b-col>

      <b-col sm="6" lg="3">
        <b-card class="text-white bg-warning">
          <div class="h3 text-muted text-right mb-4">
            <i class="far fa-user"></i>
          </div>
          <h1 class="h1 mb-0">{{ count.user }}</h1>
          <small class="text-muted text-uppercase font-weight-bold">User(s)</small>  
        </b-card>
      </b-col>

    </b-row>

    <b-card>
      <b-row>
        <b-col sm="5">
          <h4 id="traffic" class="card-title mb-0">Complaint</h4>
          <div class="small text-muted">February 2019</div>
        </b-col>
        <b-col sm="7" class="d-none d-md-block">
          <b-button type="button" variant="primary" class="float-right"><i class="fas fa-download"></i></b-button>
          <b-button-toolbar class="float-right" aria-label="Toolbar with buttons group">
            <b-form-radio-group class="mr-3" id="radiosBtn" buttons button-variant="outline-secondary" v-model="selected" name="radiosBtn">
              <b-form-radio class="mx-0" value="Day">Day</b-form-radio>
              <b-form-radio class="mx-0" value="Month">Month</b-form-radio>
              <b-form-radio class="mx-0" value="Year">Year</b-form-radio>
            </b-form-radio-group>
          </b-button-toolbar>
        </b-col>
      </b-row>
      <charts chartId="main-chart-01" class="chart-wrapper" style="height:300px;margin-top:40px;" height="300"></charts>
    </b-card>

  </div>
</template>

<script>

import Charts from './helpers/Charts'

export default {
  name: 'Dashboard',
  components: {
    'charts': Charts
  },
  data () {
    return {
      // location: [],
      loading: false,
      count: {
        user: 0,
        location: 0,
        post: 0,
        complaint: 0
      },
      selected: true
    }
  },
  methods: {
    getPostCount: function() {
      axios.get('/api/posts')
      .then(response => {
        this.loading = false
        this.count.post = response.data.data.length
      })
      .catch(error => {
        this.loading = false
        console.log(error)
      })
    },
    getLocationCount: function() {
      axios.get('/api/locations')
      .then(response => {
        this.loading = false
        this.count.location = response.data.data.length
      })
      .catch(error => {
        this.loading = false
        console.log(error)
      })
    },
    getComplaintCount: function() {
      axios.get('/api/complaints')
      .then(response => {
        this.loading = false
        this.count.complaint = response.data.data.length
      })
      .catch(error => {
        this.loading = false
        console.log(error)
      })
    },
    getUserCount: function() {
      axios.get('/api/users')
      .then(response => {
        this.loading = false
        this.count.user = response.data.data.length
      })
      .catch(error => {
        this.loading = false
        console.log(error)
      })
    }
  },
  created() {
    this.loading = true

    this.getPostCount()
    this.getLocationCount()
    this.getComplaintCount()
    this.getUserCount()
  }
}

</script>
