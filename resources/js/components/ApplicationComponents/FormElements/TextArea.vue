<template>
  <div class="form-group mt-4">
    <label v-if="locales.ru" :for="question_id">{{label}}</label>
    <label v-if="locales.en" :for="question_id">{{label_en}}</label>
    <label v-if="locales.cn" :for="question_id">{{label_en}}</label>
    <textarea
      v-model="answer"
      :name="question_id+'#'+name"
      class="form-control"
      :id="question_id"
      rows="3"
    ></textarea>
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
      label: this.question_item.label,
      label_en: this.question_item.label_en,
      name: this.question_item.name,
      answer: this.question_item.answer || this.question_item.value
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
    ...mapState(["locales"]),
    current_error() {
      let error = this.errors[this.name] || [];
      return error[0];
    }
  },
  mounted() {}
};
</script>
