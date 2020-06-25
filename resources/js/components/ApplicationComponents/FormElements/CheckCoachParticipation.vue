<template>
  <div class="mt-4">
    <span v-html="label" class="mb-1" v-if="locales.ru" :for="question_id"></span>
    <span v-html="label_en" class="mb-1" v-if="locales.en" :for="question_id"></span>
    <input hidden :checked="!answer" type="radio" :name="question_id+'#'+name" value />
    <div
      class="form-check"
      v-for="(value, presentation) in presentations_values[current_locale]"
      :key="value"
    >
      <input
        class="form-check-input"
        :checked="answer === value"
        type="radio"
        @change="change_coach_participate_status"
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
  methods: {
    change_coach_participate_status(e) {
      if (e.target.value == "Да") {
        this.$store.dispatch("changeCoachParticipateStatus", true);
      } else {
        this.$store.dispatch("changeCoachParticipateStatus", false);
      }
    }
  },
  computed: {
    ...mapState(["locales", "current_locale", "is_coach_participated"])
  },
  beforeMount() {
    if (this.answer == "Да") {
      this.$store.dispatch("changeCoachParticipateStatus", true);
    }
  }
};
</script>
