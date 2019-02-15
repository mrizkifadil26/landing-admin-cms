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
        <spinner v-if="loading"></spinner>
        <div class="col-lg-4 col-sm-12 mb-4" v-for="post in displayedPosts" :key="post.id">
          <div class="card h-100">
            <b-link :to="{ name: 'News Section', params: { slug: post.slug, id: post.id }}"><b-img-lazy class="card-img-top" :src="post.image.image_link" alt="" height="200" /></b-link>
            <div class="card-body">
              <h4 class="card-title">
                <b-link :to="{ name: 'News Section', params: { slug: post.slug, id: post.id }}">{{ post.title }}</b-link>
              </h4>
              <p class="card-text text-dark" v-html="$options.filters.truncate(post.content, 200, '...')"></p>
              <p class="text-muted">Posted by {{ post.posted_by.name }} on {{ post.created_at }}</p>
              <b-button class="btn btn-primary" :to="{ name: 'News Section', params: { slug: post.slug, id: post.id }}">Read more <i class="fas fa-arrow-right"></i></b-button>
            </div>
          </div>
        </div>
        
      </div>
      
      <b-row>
        <b-col class="text-center">
          <b-button-group size="lg">
            <b-button variant="light" class="page-link" aria-label="Next" :disabled="page >= pages.length" @click.prevent="page++">
              <span aria-hidden="true">Older Posts</span>
              <span class="sr-only">Older Posts</span>
            </b-button>
            <b-button variant="light" class="page-link" aria-label="Previous" :disabled="page <= 1" @click.prevent="page--">
              <span aria-hidden="true">Newest Posts</span>
              <span class="sr-only">Newest Posts</span>
            </b-button>
          </b-button-group>
        </b-col>
      </b-row>

    </div>
    <!-- /.container -->

  </section>
</template>

<script>

export default {
  name: 'News',

  data () {
    return {
      loading: false,
      posts: [],
      currentPage: 1,
      perPage: 3,
      page: 1,
      pages: []
    }
  },
  filters: {
     truncate: function (text, length, suffix) { 
                if (text.length > length) {
                  return text.substring(0, length) + suffix;
                }
                  return text.substring(0, length)
                },
  },
  methods: {
    getPosts () {
      this.loading = true
      window.axios.get('/api/posts')
        .then(response => {
          this.loading = false
          this.posts = response.data.data
        })
        .catch(error => {
          this.loading = false
          console.log(error)
        })
    },
    setPages () {
      let numberOfPages = Math.ceil(this.posts.length / this.perPage)
      for(let i = 1; i <= numberOfPages; i++) {
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
  created() {
    this.getPosts()
  }
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