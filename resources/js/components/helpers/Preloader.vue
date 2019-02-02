<template>
  <div class="text-center">
    <img src="/img/preloader.gif" class="preloader">
  </div>
</template>

<script>

export default {
  props: {
    preloader: {
      required: true,
      type: Boolean,
      default: false
    }
  }
}

</script>

<style scoped>

  img.preloader {
    max-width: 60px;
  }

</style>


