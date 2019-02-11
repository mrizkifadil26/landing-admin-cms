<template>
  <section id="events" class="bg-primary">

    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading">Events</h2>
          <hr class="my-4 light">
        </div>
      </div>

      <div class="container">
        <div class="row">
          <b-col>
            <spinner v-if="loading"></spinner>
            <b-card v-for="event in displayedEvents" :key="event.id">
              <b-row>
                <b-col md="5" class="text-center text-dark">
                  <b-row v-if="moment(event.start_date).format('YYYY-MM-DD') == moment(event.end_date).format('YYYY-MM-DD')">
                    <b-col>
                      <h5 class="mb-1"><strong>{{ event.start_date | toDayName }}</strong></h5>
                      <h1 class="display-3">{{ event.start_date | toDay }}</h1>
                      <h5>{{ event.start_date | toMonth }} {{ event.start_date | toYear }}</h5>
                      <h4>{{ event.start_date | toTime }} - {{ event.end_date | toTime }}</h4>
                    </b-col>
                  </b-row>
                  <b-row v-else>
                    <b-col>
                      <h5 class="mb-1"><strong>{{ event.start_date | toDayName }}</strong></h5>
                      <h1 class="display-3">{{ event.start_date | toDay }}</h1>
                      <h5>{{ event.start_date | toMonth }} {{ event.start_date | toYear }}</h5>
                      <p>{{ event.start_date | toTime }}</p>
                    </b-col>
                    <h1 class="display-3 my-4">-</h1>
                    <b-col>
                      <h5 class="mb-1"><strong>{{ event.end_date | toDayName }}</strong></h5>
                      <h1 class="display-3">{{ event.end_date | toDay }}</h1>
                      <h5>{{ event.end_date | toMonth }} {{ event.end_date | toYear }}</h5>
                      <p>{{ event.end_date | toTime }}</p>
                    </b-col>
                  </b-row>
                </b-col>
                <b-col md="7" class="text-dark">
                  <h2>{{ event.event }}</h2>
                  <p>{{ event.description }}</p>
                  <p class="text-muted"><i class="fas fa-map-marker-alt"></i> {{ event.location }}</p>
                </b-col>
              </b-row>
            </b-card>
          </b-col>
        </div>
      </div>

      <b-row>
        <b-col class="text-center" align-self-bottom>
          <b-button-group size="lg">
            <b-button variant="light" class="page-link" aria-label="Previous" :disabled="page <= 1" @click.prevent="page--">
              <span aria-hidden="true">Previous</span>
              <span class="sr-only">Previous</span>
            </b-button>
            <b-button variant="light" class="page-link" aria-label="Next" :disabled="page >= this.pages.length" @click.prevent="page++">
              <span aria-hidden="true">Next</span>
              <span class="sr-only">Next</span>
            </b-button>
          </b-button-group>
        </b-col>
      </b-row>

    </div>

  </section>
</template>

<script>

import moment from 'moment'

export default {
  name: 'Events',
  data () {
    return {
      loading: false,
      events: [],
      currentPage: 1,
      perPage: 3,
      page: 1,
      pages: []
    }
  },
  created () {
    this.getEvents()
  },
  filters: {
    toDayName (date) {
      return moment(date, 'YYYY-MM-DD HH:mm:ss').format('dddd')
    },
    toDay (date) {
      return moment(date, 'YYYY-MM-DD HH:mm:ss').format('DD')
    },
    toMonth (date) {
      return moment(date, 'YYYY-MM-DD HH:mm:ss').format('MMMM')
    },
    toYear (date) {
      return moment(date, 'YYYY-MM-DD HH:mm:ss').format('YYYY')
    },
    toTime (date) {
      return moment(date, 'YYYY-MM-DD HH:mm:ss').format('HH:mm')
    }
  },
  methods: {
    getEvents () {
      this.loading = true
      window.axios.get('/api/events')
        .then(response => {
          this.loading = false
          this.events = response.data.data
          console.log(this.events)
        })
        .catch(error => {
          this.loading = false
          console.log(error)
        })
    },
    moment (date) {
      return moment(date)
    },
    setPages () {
      let numberOfPages = Math.ceil(this.events.length / this.perPage)
      for(let i = 1; i <= numberOfPages; i++) {
        this.pages.push(i)
      }
    },
    paginate(events) {
      let page = this.page
      let perPage = this.perPage
      let from = (page * perPage) - perPage
      let to = (page * perPage)
      return events.slice(from, to)
    },
  },
  computed: {
    displayedEvents() {
      return this.paginate(this.events)
    }
  },
  watch: {
    events() {
      this.setPages()
    }
  },
}
</script>

<style lang="scss" scoped>

@import '../../../../sass/landing.scss';

.btn {
  text-transform: capitalize;
  font-weight: 500;
  border-radius: 0.25rem;
  color: #fff;
}

.btn.page-link {
  color: #2C9DD9;
}

</style>