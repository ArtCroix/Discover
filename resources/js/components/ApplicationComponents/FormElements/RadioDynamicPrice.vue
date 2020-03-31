<template>
  <div class="mt-4">
    <!--    <p class="mb-1">{{label}}</p>-->
    <p class="mb-1" v-if="locales.ru" :for="question_id">{{label}}</p>
    <p class="mb-1" v-if="locales.en" :for="question_id">{{label_en}}</p>
    <p class="mb-1" v-if="locales.cn" :for="question_id">{{label_en}}</p>
    <input hidden :checked="!answer" type="radio" :name="question_id+'#'+name" value />
    <div class="form-check" v-for="(value, presentation) in presentations_values" :key="value">
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
      presentation: JSON.parse(this.question_item.presentation),
      presentation_en: JSON.parse(this.question_item.presentation_en),
      label: this.question_item.label,
      label_en: this.question_item.label_en,
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
    presentations_values() {
      let question_values = this.question_item.value
        .split("\n")
        .map(value => value.trim());

      let question_presentations = this.question_item.presentation
        .split("\n")
        .map(value => value.trim());

      return Object.fromEntries(
        question_presentations.map((_, i) => [
          question_presentations[i],
          question_values[i]
        ])
      );
    },
    pv() {
      let p = {};
      p.en = Object.fromEntries(
        this.presentation_en.map((_, i) => [
          presentation_en[i],
          question_values[i]
        ])
      );
      p.cn = Object.fromEntries(
        this.presentation_en.map((_, i) => [
          presentation_en[i],
          question_values[i]
        ])
      );
      p.ru = Object.fromEntries(
        this.presentation.map((_, i) => [presentation[i], question_values[i]])
      );
      return p;
    },
    pv_en() {
      return Object.fromEntries(
        presentation_en.map((_, i) => [presentation_en[i], question_values[i]])
      );
    }
  },
  mounted() {
    console.log(this.presentation);
    /*             console.log(this.value);
                        console.log(this.old_input_value); */
  }
};
</script>
