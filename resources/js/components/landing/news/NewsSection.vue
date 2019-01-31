<template>
  <div class="page-top">
    <navbar></navbar>
    <b-container>
      <b-row>
        <b-col>
          <h1 class="display-4 mb-3">{{ post.data.title }}</h1>
          <b-img class="mb-3" :src="'/img/' + post.data.posted_by.avatar" height="32"></b-img> <span><a class="font-weight-bold" href="#">{{ post.data.posted_by.name }}</a></span>
          <p class="mb-2 font-weight-light">Tags: <a href="#" class="font-weight-normal">{{ post.data.category.post_category }}</a></p>
          <p class="font-weight-light">Posted on: {{ post.data.created_at }}</p>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <b-img class="mb-2" :src="post.data.image.image_link" fluid-grow :alt="post.data.title"></b-img>
        </b-col>
      </b-row>
      <b-row>
        <b-col>
          <p class="content text-justify text-wrap">{{ post.data.content }}</p>
        </b-col>  
      </b-row>
    </b-container>
    <the-footer></the-footer>
  </div>
</template>

<script>

import Navbar from '../layouts/Navbar'
import Footer from '../layouts/Footer'
import axios from 'axios'

export default {
  name: 'NewsSection',
  components: {
    'navbar': Navbar,
    'the-footer': Footer
  },
  data () {
    return {
      post: null
    }
  },
  mounted () {
    const paramUrl = this.$route.params.id
    axios.get(`http://localhost:8000/api/posts/${paramUrl}`)
      .then(response => {
        this.post = response.data
        console.log(this.post.data)
      })
      .catch(error => {
        console.log(error)
      })
  }
}
</script>

<style lang="scss" scoped>

#mainNav {
  background-color: #2C9DD9;
}

.content {
  line-height: 1.5rem;
}

.fixed-top {
  position: sticky;
  margin-bottom: 1.5rem;
}

</style>


