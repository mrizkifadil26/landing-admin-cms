<template>
  <div style="height: 400px; width: 100%">
    <l-map
      style="width: 100%"
      :zoom="zoom"
      :center="markerLatLng">
      <l-tile-layer :url="url"></l-tile-layer>
      <l-marker 
        :lat-lng.sync="markerLatLng"
        :draggable="draggable">
      </l-marker>
    </l-map>
  </div>  
</template>

<script>

import { LMap, LTileLayer, LMarker } from 'vue2-leaflet'
import L from 'leaflet'

delete L.Icon.Default.prototype._getIconUrl;
L.Icon.Default.imagePath = '/';
L.Icon.Default.mergeOptions({
    iconRetinaUrl: require('leaflet/dist/images/marker-icon-2x.png'),
    iconUrl: require('leaflet/dist/images/marker-icon.png'),
    shadowUrl: require('leaflet/dist/images/marker-shadow.png'),
});

export default {
  name: 'Maps',
  props: {
    draggable: {
      type: Boolean,
      default: false
    },
    markerLatLng: {
      type: [Array, Object],
      default: () => []
    }
  },
  components: {
    LMap,
    LTileLayer,
    LMarker
  },
  data () {
    return {
      url: 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
      zoom: 13,
    }
  },
  computed: {
    
  }
}

</script>

