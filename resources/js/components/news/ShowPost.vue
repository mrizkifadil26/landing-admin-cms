<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <strong></strong>
          <b-row class="mb-3">
            <b-col md="3" sm="3" class="text-left">
              <b-button variant="warning" @click="$router.back()"><i class="fas fa-arrow-left" /> Back</b-button>
            </b-col>
          </b-row>
          <b-row>
            <b-col>
              <div class="display-4">{{ post.title }}</div>
              <hr>
              <p>Posted {{ post.created_at }} by <b-link :to="{ path: `/admin/users/show/${post.posted_by.id}` }">{{ post.posted_by.name }}</b-link></p>
              <p><i class="fas fa-tags"></i> Tags: <b-badge variant="dark">{{ post.category.post_category }}</b-badge></p>
              <br>
              <b-img :src="post.image.image_link" center fluid :alt="post.image.image_name" class="mb-3" />
              <div v-html="post.content"></div>
              <hr>
            </b-col>
          </b-row>
          <b-row>
            <b-col class="mb-3">
              <h2>Write a comment:</h2>
            </b-col>
          </b-row>
          <b-container v-if="!isLoggedIn">
            <b-row>
              <b-col class="text-center">
                <h4 class="mb-2">You must login first.</h4>
                <b-button variant="primary" :to="{ path: '/login' }" size="lg">Login</b-button>
              </b-col>
            </b-row>
            <hr>
          </b-container>
          <b-container v-else>
            <b-form @submit.prevent="addComment()">
              <b-row>
                <b-col md="1.5">
                  <b-img-lazy
                      rounded
                      class="mb-3" 
                      :src="user.avatar.avatar_link" 
                      width="96" />
                </b-col>
                <b-col>
                  <b-form-textarea
                    id="comment"
                    v-model="comment"
                    placeholder="Write a comment..."
                    :rows="4"
                    :max-rows="6"></b-form-textarea>
                </b-col>
              </b-row>
              <b-row>
                <b-col class="text-right">
                  <b-button type="submit" variant="primary">Add Comment</b-button>
                </b-col>
              </b-row>
              <hr>
            </b-form>
          </b-container>
          <comments :post="post.id"></comments>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

import Comments from '../helpers/Comments'
import Swal from 'sweetalert2'

export default {
  name: 'ShowPost',
  components: {
    Comments
  },
  data () {
    return {
      post: {},
      comment: ''
    }
  },
  methods: {
    getPost () {
      const urlParam = this.$route.params.id
      axios.get(`/api/posts/${urlParam}`)
        .then(response => {
          this.post = response.data.data
          console.log(this.post)
        })
        .catch(error => {
          console.log(error)
        })
    },
    addComment () {
      window.axios.post('/api/comments', {
        post_id: this.post.id,
        user_id: this.user.id,
        comment: this.comment
      }).then(response => {
          Swal.fire({
            type: 'success',
            title: 'Comment Sent!',
            text: 'Your comment successfully sent.'
          })
          this.comment = ''
        })
        .catch(error => {
          Swal.fire({
            type: 'error',
            title: 'Error!',
            text: 'Please try again later.'
          })
          console.log(error)
        })
      console.log({
        post_id: this.post.id,
        user_id: this.user.id,
        comment: this.comment
      })
    }
  },
  computed: {
    isLoggedIn () {
      return this.$store.getters['authentication/isLoggedIn']
    },
    user () {
      return this.$store.getters['authentication/currentUser']
    }
  },
  created () {
    this.getPost()
  }
}
</script>
