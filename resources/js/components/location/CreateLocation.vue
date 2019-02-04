<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <b-card>
          <div slot="header">
            <strong><i class="fas fa-pencil" />Add Location</strong>
          </div>
          <b-row>
            <b-col>
              <b-form @submit.prevent="submitLocation">
                <b-form-group
                  label="Location Name"
                  label-for="location"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="location" type="text" v-model="location.name"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Description"
                  label-for="description"
                  :label-cols="3"
                  :horizontal="true">
                  <b-form-input id="description" type="text" v-model="location.description"></b-form-input>
                </b-form-group>

                <b-form-group
                  label="Category"
                  label-for="category"
                  :label-cols="3"
                  :horizontal="true">
                  <!-- <b-form-input id="category" type="text" v-model="location.category"></b-form-input>
                   -->
                  <vue-tags-input
                    v-model="tag"
                    :tags="tags"
                    :autocomplete-items="autoCompleteItems"
                    :add-only-from-autocomplete="true"
                    @tags-changed="updateTag"
                  ></vue-tags-input>
                </b-form-group>

                <b-form-group
                  label="Address"
                  label-for="address"
                  :label-cols="3"
                  :horizontal="true">
                  <!-- <b-form-input id="mapLocation" type="text" v-model="location.mapLocation" :value="location.mapLocation"></b-form-input> -->
                  <b-form-input id="address" type="text" v-model="location.address"></b-form-input>
                </b-form-group>
                
                <b-form-group>
                  <!-- <map-view
                    :marker-lat-lng="location.latLng"
                    :draggable="true"
                    ></map-view> -->
                </b-form-group>

                <!-- <b-button variant="warning" md="3 ml-auto">Save As Draft</b-button> -->
                <b-button type="submit" variant="primary" md="3 ml-auto">Create</b-button>

              </b-form>
            </b-col>
          </b-row>
        </b-card>
      </b-col>
    </b-row>
  </div>
</template>

<script>

import Maps from '../helpers/Maps'
import VueTagsInput from '@johmun/vue-tags-input'
import { clearTimeout, setTimeout } from 'timers';

export default {
  name: 'CreateLocation',
  components: {
    'map-view': Maps,
    'vue-tags-input': VueTagsInput
  },
  data () {
    return {
      location: {
        name: '',
        description: '',
        address: '',
        category: [],
        image_id: null,
        posted_by: null,
        // latLng: {
        //   lat: -6.009544,
        //   lng: 106.042156, 
        // },
        // mapLocation: [],
      },
      tag: '',
      tags: [],
      autoCompleteItems: [],
      debounce: null
    }
  },
  computed: {

  },
  methods: {
    changeKey: function(orgKey, newKey, arr) {
      let newArr = []
      for (let i = 0; i < arr.length; i++) {
        let obj = arr[i]
        obj[newKey] = obj[orgKey]
        delete(obj[orgKey])
        newArr.push(obj)
      }
      return newArr
    },
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
    submitLocation: function() {
      this.changeKey('text', 'location_category', this.tags)
      axios.post('api/locations', {
        location: this.location.name,
        description: this.location.description,
        address: this.location.address,
        category: this.tags,
        image_id: 2,
        posted_by: localStorage.getItem('user_id'),
      })
      .then(result => {
        console.log(result)
        this.$router.go(-1)
      })
      .catch(error => {
        console.log(error)
      })
      
      // console.log({
      //   location: this.location.name,
      //   description: this.location.description,
      //   address: this.location.address,
      //   category: this.tags,
      //   image_id: 2,
      //   posted_by: localStorage.getItem('user_id'),
      // })
    },
    updateTag(newTag) {
      this.autoCompleteItems = [],
      this.tags = newTag
    },
  },
  created() {
    // this.getCategories()
  },
  watch: {
    'tag': 'getCategories'
  }
}
</script>