<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <strong></strong>
          <b-row class="mb-3">
            <b-col md="3" sm="3" class="text-left">
              <b-button variant="warning"><i class="fas fa-arrow-left" /> Back</b-button>
            </b-col>
            <b-col md="3 ml-auto" sm="3 ml-auto" class="text-right">
              <b-button variant="warning" :href="`/news/show/${post.id}`"><i class="fas fa-eye" /> Preview</b-button>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <div class="display-4">{{ post.title }}</div>
              <hr>
              <p>Posted {{ post.created_at }} by <a :href="'/admin/users/show/' + post.posted_by.id">{{ post.posted_by.name }}</a></p>
              <p><i class="fas fa-tags"></i> Tags: <b-badge variant="dark">{{ post.category.post_category }}</b-badge></p>
              <br>
              <b-img :src="post.image.image_link" center fluid :alt="post.image.image_name" class="mb-3" />
              <div v-html="post.content"></div>
              <hr>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

export default {
  name: 'ShowPost',
  data () {
    return {
      post: {}
    }
  },
  methods: {
    getPost: function() {
      const urlParam = this.$route.params.id
      axios.get(`/api/posts/${urlParam}`)
        .then(response => {
          this.post = response.data.data
          console.log(this.post)
        })
        .catch(error => {
          console.log(error)
        })
    }
  },
  created () {
    this.getPost()
  }
}
</script>
