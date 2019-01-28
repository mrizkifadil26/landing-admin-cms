<template>
  <div id="page-top">
    <navbar></navbar>
    <hero-image></hero-image>
    <news-section></news-section>
    <complaint-section></complaint-section>
    <location-section></location-section>
    <link-section></link-section>
    <the-footer></the-footer>
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
    'navbar': Navbar,
    'hero-image': Hero,
    'news-section': News,
    'location-section': Location,
    'complaint-section': Complaint,
    'link-section': Links,
    'the-footer': Footer
  },
}

</script>

