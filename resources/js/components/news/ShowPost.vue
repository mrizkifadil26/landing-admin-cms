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
              <b-button variant="warning" :to="{ path: `/news/show/${post.data.id}` }"><i class="fas fa-eye" /> Preview</b-button>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <div class="display-4">{{ post.data.title }}</div>
              <hr>
              <p>Posted {{ post.data.created_at }} by {{ post.data.posted_by.name }}</p>
              <p>Tags: <b-badge variant="dark">{{ post.data.category.post_category }}</b-badge></p>
              <br>
              <b-img :src="post.data.image.image_link" center fluid :alt="post.data.title" class="mb-3" />
              <p>{{ post.data.content }}</p>
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
  created () {
    const urlParam = this.$route.params.id
    axios.get(`/api/posts/${urlParam}`)
      .then(response => {
        this.post = response.data
      })
      .catch(error => {
        console.log(error)
      })
  }
}
</script>
