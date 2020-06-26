<template>
  <div class="mt-4">
    <p v-html="label" class="mb-1" v-if="locales.ru" :for="question_id"></p>
    <p v-html="label_en" class="mb-1" v-if="locales.en" :for="question_id"></p>
    <input hidden :checked="!answer" type="radio" :name="question_id+'#'+name" />
    <div
      class="form-check"
      v-for="(value, presentation) in presentations_values[current_locale]"
      :key="value"
    >
      <input
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
      question_id: this.question_item.question_id,
      question_value: this.question_item.value,
      question_value_en: this.question_item.value_en,
      name: this.question_item.name,
      answer: this.question_item.answer
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
  computed: {
    ...mapState(["locales", "current_locale"]),
    current_error() {
      let error = this.errors[this.name] || [];
      return error[0];
    },
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
  mounted() {}
};
</script>
