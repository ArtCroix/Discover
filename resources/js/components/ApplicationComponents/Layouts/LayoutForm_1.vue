<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 mt-4">
        <slot name="application_info"></slot>
        <p v-for="(file, key) in app_files" :key="`file${key}`">
          <a download :href="'/storage/'+file">{{file.split("/").slice(-1)[0]}}</a>
        </p>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-12 mt-4">
        <slot name="team"></slot>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-4 col-12 mt-4">
        <slot name="user_1"></slot>
      </div>
      <div class="col-sm-4 col-12 mt-4">
        <slot name="user_2"></slot>
      </div>
      <div class="col-sm-4 col-12 mt-4">
        <slot name="user_3"></slot>
      </div>
    </div>
    <div class="row justify-content-between">
      <div class="col-sm-4 col-12 mt-4">
        <slot name="coach"></slot>
      </div>
      <div class="col-sm-4 col-12 mt-4">
        <slot name="coach_aside"></slot>
      </div>
    </div>
    <div class="row justify-content-between">
      <div class="col-sm-4 col-12 mt-4">
        <slot name="chief"></slot>
      </div>
      <div class="col-sm-4 col-12 mt-4">
        <slot name="chief_aside"></slot>
      </div>
    </div>
    <div class="row">
      <div class="col-12 mt-4">
        <slot name="common_info"></slot>
      </div>
    </div>
    <div class="row">
      <div class="col-12 mt-4">
        <slot name="submit_button"></slot>
      </div>
    </div>
  </div>
</template>
<script>
export default {
  props: {
    app_files: {
      default: []
    }
  }
};
</script>