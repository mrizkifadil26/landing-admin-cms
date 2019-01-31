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
        <div class="col-lg-4 col-sm-12 mb-4" v-for="post in this.posts.data" :key="post.id">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" :src="post.image" alt="" height="200"></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">{{ post.title }}</a>
              </h4>
              <p class="card-text text-dark">{{ post.content | truncate(200, '...')}}</p>
              <p class="text-muted">Posted by {{ post.posted_by }} on {{ post.created_at }}</p>
              <b-button class="btn btn-primary" :to="{ path: '/news/show/' + post.id }">Read more <i class="fas fa-arrow-right"></i></b-button>
            </div>
          </div>
        </div>
        
      </div>
      <!-- /.row -->
      
      <!-- Action Button -->
      
      <!-- ./ Action Button -->

      <!-- Pagination -->
      <ul class="pagination justify-content-center">
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">Newest Posts</span>
            <span class="sr-only">Newest Posts</span>
          </a>
        </li>
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Next">
            <span aria-hidden="true">Older Posts</span>
            <span class="sr-only">Older Posts</span>
          </a>
        </li>
      </ul>
    
    </div>
    <!-- /.container -->

  </section>
</template>

<script>

import axios from 'axios'

export default {
  name: 'News',
  data () {
    return {
      posts: [],
      // post: {
      //   title: '',
      //   content: '',
      //   image: '',
      //   category: '',
      //   postedBy: '',
      //   createdAt: '',
      // }
    }
  },
  created() {
    axios.get('http://localhost:8000/api/posts')
      .then(response => {
        this.posts = response.data
      }).catch(error => {
        console.log(error)
      })
  },
  filters: {
     truncate: function (text, length, suffix) { 
                  return text.substring(0, length) + suffix;
                },
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