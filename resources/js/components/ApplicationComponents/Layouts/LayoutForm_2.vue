<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-12 mt-4">
        <slot name="common_info"></slot>
      </div>
    </div>
    <div class="row">
      <div class="col-sm-12 col-12 mt-4">
        <slot name="team"></slot>
      </div>
    </div>
    <div class="row">
      <div class="user_1 col-sm-4 col-12 mt-4">
        <slot name="user_1"></slot>
      </div>
      <div v-if="display_invitations.user_2" class="user_2 col-sm-4 col-12 mt-4">
        <slot name="user_2"></slot>
      </div>
      <div v-if="display_invitations.user_3" class="user_3 col-sm-4 col-12 mt-4">
        <slot name="user_3"></slot>
      </div>
    </div>
    <div class="row justify-content-between">
      <div v-if="display_invitations.coach" class="coach col-sm-4 col-12 mt-4">
        <slot name="coach"></slot>
      </div>
      <div class="col-sm-4 col-12 mt-4">
        <slot name="chief"></slot>
      </div>
      <div class="col-sm-4 col-12 mt-4">
        <slot name="chief_aside"></slot>
      </div>
    </div>
  </div>
</template>
<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState(["display_invitations"])
  }
};
</script>