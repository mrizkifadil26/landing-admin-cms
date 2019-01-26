<template>
  <div style="height: 400px; width: 100%">
    <l-map
      style="width: 100%"
      :zoom="zoom"
      :center="center">
      <l-tile-layer :url="url"></l-tile-layer>
      <l-marker :lat-lng="markerLatLng"></l-marker>
    </l-map>
  </div>  
</template>

<script>

import { LMap, LTileLayer, LMarker } from 'vue2-leaflet'

export default {
  name: 'Maps',
  components: {
    LMap,
    LTileLayer,
    LMarker
  },
  data () {
    return {
      url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      zoom: 13,
      center: [47.413220, -1.219482],
      markerLatLng: [47.413220, -1.219482],
    }
  }
}

</script>

