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
        <div class="col-lg-4 col-sm-12 mb-4">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Project One</a>
              </h4>
              <p class="card-text text-dark">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet numquam aspernatur eum quasi sapiente nesciunt? Voluptatibus sit, repellat sequi itaque deserunt, dolores in, nesciunt, illum tempora ex quae? Nihil, dolorem!</p>
              <p class="text-muted">Posted by Start Bootstrap on July 8, 2018</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12 mb-4">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Project Two</a>
              </h4>
              <p class="card-text text-dark">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nam viverra euismod odio, gravida pellentesque urna varius vitae.</p>
              <p class="text-muted">Posted by Start Bootstrap on July 8, 2018</p>
            </div>
          </div>
        </div>
        <div class="col-lg-4 col-sm-12 mb-4">
          <div class="card h-100">
            <a href="#"><img class="card-img-top" src="http://placehold.it/700x400" alt=""></a>
            <div class="card-body">
              <h4 class="card-title">
                <a href="#">Project Three</a>
              </h4>
              <p class="card-text text-dark">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Quos quisquam, error quod sed cumque, odio distinctio velit nostrum temporibus necessitatibus et facere atque iure perspiciatis mollitia recusandae vero vel quam!</p>
              <p class="text-muted">Posted by Start Bootstrap on July 8, 2018</p>
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

export default {
  name: 'News'
}

</script>

<style lang="scss" scoped>

@import '../../../../sass/landing.scss';

</style>