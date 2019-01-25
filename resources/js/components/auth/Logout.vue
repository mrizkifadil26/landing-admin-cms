<template>
  <div>
    <i class="fas fa-sign-out-alt" /> Logout
  </div>
</template>

<script>
export default {
  name: 'Logout',
  computed: {
    isLoggedIn: function() {
      return this.$store.getters.isLoggedIn
    }
  },
  methods: {
    logout: function() {
      this.$store.dispatch('logout')
        .then(() => {
          this.$router.push('/login')
        })
    }
  }
}
</script>

