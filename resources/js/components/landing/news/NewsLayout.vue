<template>
  <div class="page-top">
    <nav class="navbar navbar-expand-lg navbar-light fixed-top" id="mainNav">
      <div class="container">
        <a class="navbar-brand js-scroll-trigger" href="/"><img src="/img/favicon.png" alt="Logo">Cilegon <span>SmartCity</span></a>
        <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
          <ul class="navbar-nav ml-auto">
            <li class="nav-item" v-for="(nav, index) in navs" :key="index">
              <a class="nav-link js-scroll-trigger" :href="'/' + nav.href">{{ nav.name }}</a>
            </li>
            <li class="nav-item ml-3">
            <b-button class="btn btn-warning js-scroll-trigger" :to="{ name: 'Login' }">Login</b-button>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container">
      <div class="row">
        <div class="col-lg-12 col-sm-12 mb-4" v-for="post in this.posts.data" :key="post.id">
          <div class="card h-100">
            <a :href="`/news/show/${post.id}`"><img class="card-img-top" :src="post.image.image_link" alt="" height="200"></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="`/news/show/${post.id}`">{{ post.title }}</a>
              </h4>
              <p class="card-text text-dark">{{ post.content | truncate(200, '...')}}</p>
              <p class="text-muted">Posted by {{ post.posted_by.name }} on {{ post.created_at }}</p>
              <b-button class="btn btn-primary" :to="{ path: '/news/show/' + post.id }">Read more <i class="fas fa-arrow-right"></i></b-button>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Pagination -->
    <ul class="pagination justify-content-center">
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Previous" :disabled="page < pages.length"  @click="page++">
          <span aria-hidden="true">Newest Posts</span>
          <span class="sr-only">Newest Posts</span>
        </a>
      </li>
      <li class="page-item">
        <a class="page-link" href="#" aria-label="Next" :disabled="page != 1" @click="page--">
          <span aria-hidden="true">Older Posts</span>
          <span class="sr-only">Older Posts</span>
        </a>
      </li>
    </ul>

  </div>
</template>

<script>

export default {
  name: 'NewsLayout',
  components: {

  },
  data () {
    return {
      posts: []
    }
  },
  created() {
    axios.get('/api/posts')
      .then(response => {
        this.posts = response.data
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

</style>

