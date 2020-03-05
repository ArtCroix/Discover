<template>
  <div class="form-group mt-4">
    <label :for="question_id">{{label}}</label>
    <input
      v-model="answer"
      :name="question_id+'#'+name"
      type="email"
      class="form-control"
      :id="question_id"
    />
    <div class="invalid_form error" :class="name">{{current_error}}</div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      question_id: this.question_item.question_id,
      question_value: this.question_item.value,
      label: this.question_item.label,
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
    current_error() {
      let error = this.errors[this.name] || [];
      return error[0];
    }
  },
  mounted() {}
};
</script>
