<template>
  <div class="animated fadeIn">
    <b-row>
      <b-col>
        <div slot="header">
          <strong>Create User</strong> <small>Muhammad Rizki Fadillah</small>
        </div>
        <b-row>
          <b-col>
            <b-form-group
             label="Title"
             label-for="title"
             :label-cols="3"
             :horizontal="true">
             <b-form-input id="title" type="text"></b-form-input>
            </b-form-group>
          </b-col>
        </b-row>
      </b-col>
    </b-row>
  </div>
</template>

<script>
export default {
  name: 'CreateUser',
}
</script>

