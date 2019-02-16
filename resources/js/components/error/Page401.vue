<template>
  <div class="app flex-row align-items-center">
    <div class="container">
      <b-row class="justify-content-center">
        <b-col md="6">
          <div class="clearfix">
            <h1 class="float-left display-3 mr-4">401</h1>
            <h4 class="pt-3">Unauthorized</h4>
            <p class="text-muted">You're not be able to access this page.</p>
          </div>
        </b-col>
        <b-link class="float-right" :to="{ path: '/' }"><i class="fas fa-long-arrow-alt-left"></i> Back to Home</b-link>
      </b-row>
    </div>
  </div>
</template>

<script>
export default {
  name: 'Page404'
}
</script>
