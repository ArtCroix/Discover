<template>
  <div class="cotainer-fluid w-75 mx-auto">
    <form name="app_form" method="POST" enctype="multipart/form-data">
      <component :is="layoutComponent">
        <template v-for="(slot) in slots" v-slot:[slot]>
          <component
            v-for="(question_item, index) in application_data"
            v-if="question_item.slot_name==slot"
            @addedfile="addFileToFormData($event)"
            :question_item="question_item"
            :key="index"
            :is="question_item.type"
            :errors="errors"
          ></component>
        </template>
      </component>
      <input type="hidden" name="_token" :value="csrf_token" />
      <button type="submit" @click.prevent="submit()" class="btn btn-primary">Sign in</button>
    </form>
    <created_docs :created_docs="created_docs"></created_docs>
  </div>
</template>

<script>
import MixinApplication from "./ApplicationComponents/MixinApplication";

export default {
  mixins: [MixinApplication],
  computed: {
    slots() {
      return new Set(this.application_data.map(val => val.slot_name));
    }
  },
  mounted() {
    console.log(this.application_data);
  }
};
</script>
