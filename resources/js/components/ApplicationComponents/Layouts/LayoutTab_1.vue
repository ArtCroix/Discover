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