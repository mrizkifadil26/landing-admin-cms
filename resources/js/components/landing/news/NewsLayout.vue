<template>
  <div class="page-top">
    <navbar></navbar>
  </div>
</template>

<script>

import Navbar from '../layouts/Navbar'
import Hero from '../layouts/Hero'

export default {
  name: 'NewsLayout',
  components: {
    'navbar': Navbar,
    'main-image': Hero
  }
}

</script>


<style lang="scss" scoped>

#mainNav {
  background-color: #2C9DD9;
}

</style>

