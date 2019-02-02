<template>
  <section id="news" class="bg-primary">

    <div class="container">
      <div class="row">
        <div class="col-lg-12 text-center">
          <h2 class="section-heading text-light">Berita</h2>
          <hr class="light my-4">
        </div>
      </div>
    </div>

    <!-- Page Content -->
    <div class="container">
      
      <div class="row">
        <div class="col-lg-4 col-sm-12 mb-4" v-for="post in this.paginate(this.posts.data)" :key="post.id">
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
      <!-- /.row -->
      
      <!-- Action Button -->
      <!-- <preloader
        :preloader="this.preloader"
        class="mb-3"></preloader> -->
      <!-- ./ Action Button -->

      <!-- Pagination -->
      <ul class="pagination justify-content-center">

        <li class="page-item">
          <b-link class="page-link" aria-label="Next" :disabled="this.page != 1" @click.prevent="this.page--">
            <span aria-hidden="true">Older Posts</span>
            <span class="sr-only">Older Posts</span>
          </b-link>
        </li>
        <li class="page-item">
          <b-link class="page-link" aria-label="Previous" :disabled="this.page < this.posts.length" @click.prevent="this.page++">
            <span aria-hidden="true">Newest Posts</span>
            <span class="sr-only">Newest Posts</span>
          </b-link>
        </li>

      </ul>
    
    </div>
    <!-- /.container -->

  </section>
</template>

<script>

import Preloader from '../../helpers/Preloader'

export default {
  name: 'News',
  components: {
    'preloader': Preloader
  },
  data () {
    return {
      preloader: false,
      posts: [],
      currentPage: 1,
      perPage: 3,
      page: 1,
      pages: []
    }
  },
  filters: {
     truncate: function (text, length, suffix) { 
                  return text.substring(0, length) + suffix;
                },
  },
  methods: {
    setPages () {
      let numberOfPages = Math.ceil(this.posts.length / this.perPage)
      for( let i = 1; i <= numberOfPages; i++) {
        this.pages.push(i)
      }
    },
    paginate(posts) {
      let page = this.page
      let perPage = this.perPage
      let from = (page * perPage) - perPage
      let to = (page * perPage)
      return posts.slice(from, to)
    },
  },
  computed: {
    displayedPosts() {
      return this.paginate(this.posts)
    }
  },
  watch: {
    posts() {
      this.setPages()
    }
  }, 
  mounted() {
    this.preloader = true
    axios.get(`/api/posts?page=${this.page}`)
      .then(response => {
        this.posts = response.data
      })
      .catch(error => {
        console.log(error)
      })
      .finally(() => this.preloader = false)
  }
}

</script>

<style lang="scss" scoped>

@import '../../../../sass/landing.scss';

.btn {
  text-transform: capitalize;
  font-weight: 500;
  border-radius: 10px;
  color: #fff;
}

</style> 