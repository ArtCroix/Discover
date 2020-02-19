<template>
  <portal-target :name="name">
    <!--
  This component can be located anywhere in your App.
  The slot content of the above portal component will be rendered here.
    -->
  </portal-target>
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

  computed: {
    ...mapState(["locales"])
  },

  props: {
    question_item: ""
  },

  mounted() {
    // console.log(this.question_item);
  }
};
</script>
