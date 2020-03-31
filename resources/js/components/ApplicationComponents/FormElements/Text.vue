<template>
  <div class="form-group mt-4">
    <label v-html="label" v-if="locales.ru" :for="question_id"></label>
    <label v-html="label_en" v-if="locales.en" :for="question_id"></label>
    <label v-html="label_en" v-if="locales.cn" :for="question_id"></label>
    <input
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
export default {
  data() {
    return {
      question_id: this.question_item.question_id,
      question_value: this.question_item.value,
      label: this.question_item.label + (/^required(?=$|\|)/.test(this.question_item.rule) ? '<span class="text-danger">*</span>' : ''),
      label_en: this.question_item.label_en + (/^required(?=$|\|)/.test(this.question_item.rule) ? '<span class="text-danger">*</span>' : ''),
      name: this.question_item.name,
      answer: this.question_item.answer || this.question_item.value
    };
  },

  computed: {
    ...mapState(["locales"]),
    current_error() {
      let error = this.errors[this.name] || [];
      return error[0];
    }
  },

  props: {
    question_item: "",
    errors: {
      default() {
        return {};
      }
    }
  },

  mounted() {
    // console.log(this.question_item);
  }
};
</script>
