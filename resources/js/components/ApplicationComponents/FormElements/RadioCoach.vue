<template>
  <div class="mt-4">
    <span v-html="label" class="mb-1" v-if="locales.ru" :for="question_id"></span>
    <span v-html="label_en" class="mb-1" v-if="locales.en" :for="question_id"></span>
    <span v-if="is_coach_participated" class="text-danger">*</span>
    <input hidden :checked="!answer" type="radio" :name="question_id+'#'+name" value />
    <div
      class="form-check"
      v-for="(value, presentation) in presentations_values[current_locale]"
      :key="value"
    >
      <input
        :disabled="!is_coach_participated"
        class="form-check-input"
        :checked="answer === value"
        type="radio"
        :name="question_id+'#'+name"
        :id="question_id+'_'+presentation"
        :value="value"
      />
      <label class="form-check-label" :for="question_id+'_'+presentation">{{presentation}}</label>
    </div>
    <div class="invalid_form error" :class="name">{{current_error}}</div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import Radio from "./Radio";

export default {
  mixins: [Radio],
  computed: {
    ...mapState(["locales", "current_locale", "is_coach_participated"])
  }
};
</script>
