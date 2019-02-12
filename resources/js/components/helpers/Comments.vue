<template>
  <div>
    <h3>Comments:</h3>
    <spinner v-if="loading"></spinner>
    <b-row v-for="comment in comments" :key="comment.id" class="mb-1">
      <b-container>
        <hr>
        <b-row>
          <b-col md="1">
            <b-img-lazy
                  rounded
                  class="mb-3" 
                  :src="comment.user.link" 
                  width="72" />
          </b-col>
          <b-col>
            <strong>{{ comment.user.name }}</strong>
            <small>on {{ comment.created_at }}</small>
            <p class="mt-2">{{ comment.comment }}</p>
          </b-col>
        </b-row>
      </b-container>
    </b-row>
  </div>
</template>

<script>

export default {
  name: 'Comments',
  props: ['post'],
  data () {
    return {
      loading: false,

      comments: []
    }
  },
  methods: {
    getComments (id) {
      this.loading = true
      window.axios.get('/api/comments?post_id='+id)
        .then(response => {
          this.loading = false
          this.comments = response.data.data
          console.log(this.comments)
        })
        .catch(error => {
          this.loading = false
          console.log(error)
        })
    }
  },
  created () {
    this.getComments(this.post)
  },
  watch: {
    '$route': 'getComments'
  }
}

</script>

