<template>
  <div class="mt-4">
    <!--    <p class="mb-1">{{label}}</p>-->
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

export default {
  data() {
    return {
      coach_participate_status: "",
      question_id: this.question_item.question_id,
      question_value: this.question_item.value,
      question_value_en: this.question_item.value_en,
      name: this.question_item.name,
      answer: this.question_item.answer,
      rules: this.question_item.rule
    };
  },
  props: {
    question_item: "",

    errors: {
      default() {
        return {};
      }
    }
  },
  methods: {},
  computed: {
    ...mapState(["locales", "current_locale", "is_coach_participated"]),
    label() {
      return (
        this.question_item.label +
        (/^required(?=$|\|)/.test(this.question_item.rule)
          ? '<span class="text-danger">*</span>'
          : "")
      );
    },
    label_en() {
      return (
        this.question_item.label_en +
        (/^required(?=$|\|)/.test(this.question_item.rule)
          ? '<span class="text-danger">*</span>'
          : "")
      );
    },
    current_error() {
      let error = this.errors[this.name] || [];
      return error[0];
    },
    presentations_values() {
      let question_data = { en: {}, ru: {} };

      let question_values = this.question_item.value
        .split("\n")
        .map(value => value.trim());

      let question_values_en = this.question_item.value_en
        .split("\n")
        .map(value => value.trim());

      let question_presentations = this.question_item.presentation
        .split("\n")
        .map(value => value.trim());

      let question_presentations_en = this.question_item.presentation_en
        .split("\n")
        .map(value => value.trim());

      question_data.ru = Object.fromEntries(
        question_presentations.map((_, i) => [
          question_presentations[i],
          question_values[i]
        ])
      );

      question_data.en = Object.fromEntries(
        question_presentations_en.map((_, i) => [
          question_presentations_en[i],
          question_values_en[i]
        ])
      );

      return question_data;
    }
  },
  beforeMount() {
    /*     if (this.coach_participate_status == "Да") {
      this.$store.dispatch("changeCoachParticipateStatus", true);
    } */
  },
  mounted() {
    // console.log(this.is_coach_participated);
    // console.log(this.is_coach_participated);
    // console.log(this.answer);
    /*             console.log(this.value);
                        console.log(this.old_input_value); */
  }
};
</script>
