<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong><i class="fas fa-pencil-alt" /> Update Location</strong>
          </div>
          <b-row>
            <b-col>
              <b-form>
                <b-form-group
                  label="Location Name"
                  label-for="location"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="location" type="text" v-model="location.name" :value="location.name"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Description"
                  label-for="description"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="description" type="text" v-model="location.description" :value="location.description"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Category"
                  label-for="category"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="category" type="text" v-model="location.category" :value="location.category"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Map Location"
                  label-for="mapLocation"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="mapLocation" type="text" v-model="location.mapLocation" :value="location.mapLocation"></b-form-input>
                </b-form-group>

                <!-- <b-button variant="warning" md="3 ml-auto">Save As Draft</b-button> -->
                <b-button variant="primary" md="3 ml-auto">Create</b-button>

              </b-form>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

export default {
  name: 'UpdateLocation',
  data () {
    return {
      location: {
        name: '',
        description: '',
        category: '',
        mapLocation: '',
      },

      tag: '',
      tags: [],
      autoCompleteItems: [],
      debounce: null
    }
  },
  method: {
    getCategories: function() {
      if (this.tag.length < 2) return;
      clearTimeout(this.debounce)
      this.debounce = setTimeout(() => {
        axios.get('/api/location-categories')
        .then(response => {
          this.autoCompleteItems = response.data.data.map(i => {
            return {
              id: i.id,
              text: i.location_category
            }
          })
          console.log(this.autoCompleteItems)
        })
        .catch(error => {
          console.log(error)
        })
      }, 600)
    },
    updateTag(newTag) {
      this.autoCompleteItems = [],
      this.tags = newTag
    },
  },
  watch: {
    'tag': 'getCategories'
  }
}
</script>