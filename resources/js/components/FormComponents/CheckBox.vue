<template>
  <div class="mt-4">
    <p class="mb-1">{{label}}</p>
    <div class="form-check" v-for="(presentation, value) in presentations_values" :key="value">
      <input
        class="form-check-input"
        :checked="answer.includes(value)"
        type="checkbox"
        :name="question_id+'#'+name+'[]'"
        :id="question_id+'_'+presentation"
        :value="value"
      />
      <label class="form-check-label" for="question_id+'_'+presentation">{{presentation}}</label>
    </div>
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
      name: this.question_item.name
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
    answer() {
      return this.question_item.answer
        ? JSON.parse(this.question_item.answer)
        : [];
    }
  },
  mounted() {
    // console.log(this.question_item);
    // console.log(JSON.parse(this.question_item.answer));
  }
};
</script>
