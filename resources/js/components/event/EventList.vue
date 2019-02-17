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
              <spinner v-if="loading"></spinner>
              <full-calendar
                v-else 
                :events="events"
                @eventClick="eventShow"></full-calendar>
              <b-modal ref="calendarModal" title="Event" @hidden="editing = false" ok-only :no-enforce-focus='true'>
                <b-row class="mb-3" v-if="!editing">
                  <b-col>
                    <b-button class="float-left" variant="warning" @click.prevent="enableEditing">Update</b-button>
                    <b-button class="float-right" variant="danger" @click.prevent="deleteEvent(eventModal.id)">Delete</b-button>
                  </b-col>  
                </b-row>
                <b-table stacked :items="[eventModal]" :fields="['title', 'description', 'startDate', 'endDate', 'location']" v-if="!editing"></b-table>
                <b-form v-else>
                   <b-form-group id="titleLabel"
                    label="Event Title"
                    label-for="eventTitle">
                    <b-form-input id="eventTitle"
                      name="title"
                      type="text" 
                      v-model="eventModal.title" 
                      class="form-control mb-3"></b-form-input>
                  </b-form-group>

                  <b-form-group id="startDateLabel"
                    label="Start Date"
                    label-for="startDateEvent">
                    <flat-pickr id="startDateEvent"
                      v-model="eventModal.startDate"
                      :config="config"                                                          
                      class="form-control mb-3" 
                      placeholder="Start Date"               
                      name="startDate">
                    </flat-pickr>
                  </b-form-group>
                
                  <b-form-group id="endDateLabel"
                    label="End Date"
                    label-for="endDateEvent">
                    <flat-pickr 
                      id="endDateEvent"
                      v-model="eventModal.endDate"
                      :config="config"                                                      
                      class="form-control mb-3" 
                      placeholder="End Date"               
                      name="endDate">
                    </flat-pickr>
                  </b-form-group>

                  <b-form-group id="locationLabel"
                    label="Location"
                    label-for="eventLocation">
                    <b-form-input id="eventLocation"
                      name="location"
                      placeholder="Event Location" 
                      type="text" 
                      v-model="eventModal.location" 
                      class="form-control mb-3"></b-form-input>
                  </b-form-group>
                  
                  <b-form-group id="descriptionLabel"
                    label="Description"
                    label-for="eventDescription">
                    <b-textarea id="eventDescription"
                      name="description"
                      v-model="eventModal.description"
                      :rows="3"
                      :max-rows="6"
                      class="form-control mb-3"
                      placeholder="Event Description">
                    </b-textarea>
                  </b-form-group>

                </b-form>
                <template slot="modal-footer" v-if="editing">
                  <b-button @click="updateEvent(eventModal.id)" variant="warning">Update</b-button>
                </template>
              </b-modal>
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
                  name="startDate">
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
import Swal from 'sweetalert2'

import ConfirmDatePlugin from 'flatpickr/dist/plugins/confirmDate/confirmDate.js';
import 'flatpickr/dist/plugins/confirmDate/confirmDate.css';

export default {
  name: 'EventList',
  components: {
    FullCalendar,
    flatPickr
  },
  data () {
    return {
      loading: false,
      editing: false,

      popoverShow: false,
      eventModal: {
        id: '',
        title: '',
        description: '',
        startDate: '',
        endDate: '',
        location: ''
      },
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
        plugins: [new ConfirmDatePlugin({})],

      }, 
      events: [],
    }
  },
  created() {
    this.getEvents()
  },
  computed: {
    user: function () {
      return this.$store.getters['authentication/currentUser']
    }
  },
  methods: {
    eventShow (event, js, pos) {
      console.log(this.eventModal)
      this.$refs.calendarModal.show()
      this.eventModal.id = event.id
      this.eventModal.title = event.title
      this.eventModal.startDate = event.start
      this.eventModal.endDate = event.end
      this.eventModal.location = event.location
      this.eventModal.description = event.description
    },
    getEvents () {
      this.loading = true
      axios.get('/api/events')
        .then(response => {
          this.loading = false
          this.events = response.data.data.map(i => {
            return {
              id: i.id,
              title: i.event,
              start: i.start_date,
              end: i.end_date,
              description: i.description,
              location: i.location
            }
          })
          console.log(this.events)
        }).catch(error => {
          this.loading = false
          console.log(error)
        })
    },
    schedule () {
      Swal.fire({
        type: 'warning',
        title: 'Are you sure want to schedule this event?',
        text: 'This event will be published.',
        showCancelButton: true
      }).then(result => {
        if (result.value) {
          window.axios.post('/api/events', {
            event: this.event.title,
            description: this.event.description,
            location: this.event.location,
            start_date: moment(this.event.startDate).format('YYYY-MM-DD HH:mm:ss'),
            end_date: moment(this.event.endDate).format('YYYY-MM-DD HH:mm:ss'),
            posted_by: this.user.id
          })
          .then(response => {
            Swal.fire('Publish success!', 'Event successfully published.', 'success')
            console.log(response)
          })
          .catch(error => {
            Swal.fire('Error!', 'Error publishing event.', 'error')
            console.log(error)
          })
        } else {
          Swal.fire('Error!', 'Error publishing event.', 'error')
        }
      })
      .catch(error => {
        Swal.fire('Error!', 'Try again later.', 'error')
        console.log(error)
      })
      console.log({
        title: this.event.title,
        description: this.event.description,
        location: this.event.location,
        startDate: this.event.startDate,
        endDate: this.event.endDate,
      })
    },
    enableEditing () {
      this.editing = true
    },
    updateEvent (id) {
      Swal.fire({
        type: 'warning',
        title: 'Are you sure want to update this?',
        text: 'This event will be updated.',
        showCancelButton: true
      })
      .then(result => {
        if (result.value) {
          window.axios.patch('/api/events/' + id, {
            event: this.eventModal.title,
            description: this.eventModal.description,
            location: this.eventModal.location,
            start_date: moment(this.eventModal.startDate).format('YYYY-MM-DD HH:mm:ss'),
            end_date: moment(this.eventModal.endDate).format('YYYY-MM-DD HH:mm:ss')
          })
            .then(response => {
              Swal.fire('Update success!', 'Event successfully updated.', 'success')
              console.log(response)
            })
            .catch(error => {
              Swal.fire('Error!', 'Error updating event.', 'error')
              console.log(error)
            })
          
        }
      })
      .catch(error => {
        Swal.fire('Error!', 'Try again later.', 'error')
        console.log(error)
      })
    },
    deleteEvent (id) {
      Swal.fire({
        type: 'warning',
        title: 'Are you sure?',
        text: 'This event will be deleted.',
        showCancelButton: true
      }).then(result => {
        if (result.value) {
          window.axios.delete(`/api/events/${id}`)
            .then(response => {
              Swal.fire(
                'Deleted!',
                'This post has been deleted.',
                'success'
              )
              const index = this.events.findIndex(event => event.id === id)
              if (~index) {
                this.events.splice(index, 1)
              }
              this.$refs.calendarModal.hide()
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
    }
  },
  watch: {
    '$route': 'getEvents'
  }
}
</script>

<style lang="scss" scoped>
  @import '~flatpickr/dist/flatpickr.css';
</style>


