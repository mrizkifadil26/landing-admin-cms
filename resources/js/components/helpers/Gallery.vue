<template>
  <b-container fluid class="p-4">
    <b-row>
      <b-col v-for="(image, index) in images" :key="index" md="3" sm="3" class="mb-4">
        <b-img thumbnail fluid :src="image.src" alt="Thumbnail" />
      </b-col>
    </b-row>
  </b-container>
</template>

<script>
export default {
  name: 'Gallery',
  data () {
    return {
      images : [
        {
          src: "https://picsum.photos/250/250/?image=54"
        },
        {
          src: "https://picsum.photos/250/250/?image=55"
        },
        {
          src: "https://picsum.photos/250/250/?image=56" 
        },
        {
          src: "https://picsum.photos/250/250/?image=57" 
        },
        {
          src: "https://picsum.photos/250/250/?image=58" 
        }
      ]
    }
  }
}
</script>