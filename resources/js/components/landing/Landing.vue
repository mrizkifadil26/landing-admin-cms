<template>
  <div>
    <Navbar />
    <Hero />
    <News />
    <Complaint />
    <Location />
    <Links />
    <Footer />
  </div>
</template>

<script>

import Navbar from './layouts/Navbar'
import Hero from './layouts/Hero'
import News from './layouts/News'
import Location from './layouts/Location'
import Complaint from './layouts/Complaint'
import Links from './layouts/Links'
import Footer from './layouts/Footer'

export default {
  name: 'Landing',
  components: {
    Navbar,
    Hero,
    News,
    Location,
    Complaint,
    Links,
    Footer
  }
}

</script>