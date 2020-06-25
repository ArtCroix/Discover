<template>
  <div class="form-group mt-4">
    <label v-html="label" v-if="locales.ru" :for="question_id"></label>
    <label v-html="label_en" v-if="locales.en" :for="question_id"></label>
    <span v-if="is_coach_participated" class="text-danger">*</span>
    <input
      :readonly="!is_coach_participated"
      v-model="answer"
      :name="question_id+'#'+name"
      type="text"
      class="form-control"
      :id="question_id"
    />
    <div class="invalid_form error" :class="name">{{current_error}}</div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import Text from "./Text";
export default {
  mixins: [Text],
  computed: {
    ...mapState(["locales", "is_coach_participated"])
  }
};
</script>
