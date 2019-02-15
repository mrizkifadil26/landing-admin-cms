<template>
  <span @click="logout">
    Logout
  </span>
</template>

<script>

import Swal from 'sweetalert2'

export default {
  name: 'Logout',
  computed: {
    isLoggedIn: function() {
      return this.$store.getters['authentication/isLoggedIn']
    }
  },
  methods: {
    logout: function() {

      Swal.fire({
        title: "Are you sure?",
        text: "You will be logged out.",
        type: 'warning',
        showCancelButton: true,
      })
      .then((logout) => {
        if (logout.value) {
          this.$store.dispatch('authentication/logout')
          Swal.fire({
            title: 'Logout Success',
            text: 'Logging out...',
            backdrop: 'rgba(0, 0, 0, 0.5)',
            showConfirmButton: false,
          }).then(() => {
            this.$router.push('/login')
          }) 
        } 
      })
        // this.$store.dispatch('authentication/logout')
        //   .then(() => {
        //   this.$router.push('/login')
        //   })
        // })
      
    }
  },
  mounted() {
    this.$on('logout', this.logout)
  }
}

</script>

