<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-calendar"></i><strong> Events</strong>
          </div>
          <b-row class="mb-3">
            <b-col md="3" sm="3">
              <b-button :to="{ name: 'Add Event' }" variant="primary"><i class="fas fa-plus"></i> Add Event</b-button>
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
              <full-calendar :events="popEvents"></full-calendar>
              <spinner v-show="loading"></spinner>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>  
  </div>
</template>

<script>

import FullCalendar from 'vue-fullcalendar'
import moment from 'moment'

export default {
  name: 'EventList',
  components: {
    FullCalendar
  },
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
  data () {
    return {
      loading: false,

      currentPage: 1,
      events: [],
      perPage: 5,
      fields: [
        { key: 'event', sortable: true},
        { key: 'description', sortable: true },
        { key: 'date' },
        { key: 'location', sortable: true },
        { key: 'actions', label: 'Actions' }
      ],
      popEvents: [
				{
					title: 'test',
					allDay: true,
					start: moment(),
					end: moment().add(1, 'd'),
				},
				{
					title: 'another test',
					start: moment().add(2,'d'),
					end: moment().add(2, 'd').add(2, 'h'),
				},
			],
    }
  },
  created() {
    this.getEvents()
  },
  computed: {
    totalRows: function totalRows() {
      return this.events.length
    }
  },
  methods: {
    getEvents: function () {
      this.loading = true
      axios.get('/api/events')
        .then(response => {
          this.loading = false
          this.events = response.data.data
          console.log(response.data)
        }).catch(error => {
          this.loading = false
          console.log(error)
        })
    },
    getBadge: function (status) {
      return status === 'Published' ? 'primary' : 
        status === 'Draft' ? 'danger' : 'default';
    },
  }
}
</script>

<style scoped>

</style>

