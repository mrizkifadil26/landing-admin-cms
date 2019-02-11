<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <i class="fas fa-calendar"></i><strong> Events</strong>
          </div>
          <b-row>
            <b-col md="8">
              <full-calendar :events="popEvents"></full-calendar>
              <spinner v-show="loading"></spinner>
            </b-col>
            <b-col md="4" class="py-5 text-center">
              <h2 class="mb-3">Add Event</h2>
              <b-form @submit.prevent="schedule">
                <b-form-input id="title"
                  placeholder="Event Title" 
                  type="text" 
                  v-model="event.title" 
                  class="form-control mb-3"></b-form-input>

                <flat-pickr
                  v-model="event.startDate"
                  :config="config"                                                          
                  class="form-control mb-3" 
                  placeholder="Start Date"               
                  name="startDate"
                  onChange="">
                </flat-pickr>
                
                <flat-pickr
                  v-model="event.endDate"
                  :config="config"
                  :minDate="event.startDate"                                                          
                  class="form-control mb-3" 
                  placeholder="End Date"               
                  name="endDate">
                </flat-pickr>
                
                <b-form-input id="location"
                  placeholder="Event Location" 
                  type="text" 
                  v-model="event.location" 
                  class="form-control mb-3"></b-form-input>
                
                <b-form-textarea id="description"
                    v-model="event.description"
                    placeholder="Event Description"
                    :rows="3"
                    :max-rows="6"
                    class="form-control mb-3">
                </b-form-textarea>

                <b-button type="submit" variant="primary" size="lg" md="3" class="text-center">Schedule</b-button>

              </b-form>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>  
  </div>
</template>

<script>

import FullCalendar from 'vue-fullcalendar'
import flatPickr from 'vue-flatpickr-component'
import moment from 'moment'

export default {
  name: 'EventList',
  components: {
    FullCalendar,
    flatPickr
  },
  data () {
    return {
      loading: false,
      event: {
        title: '',
        description: '',
        startDate: '',
        endDate: '',
        location: ''
      },
      config: {
        enableTime: true,
        altFormat: 'j M, Y H:i',
        altInput: true,
        dateFormat: 'Y-m-d H:i',
      }, 
      events: [],
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
  methods: {
    getEvents () {
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
    schedule () {
      console.log({
        title: this.event.title,
        description: this.event.description,
        location: this.event.location,
        startDate: this.event.startDate,
        endDate: this.event.endDate,
      })
    }
  }
}
</script>

<style lang="scss" scoped>
  @import '~flatpickr/dist/flatpickr.css';
</style>


