<template>
  <div v-if="question_item.display">
    <div v-html="value" class v-if="locales.ru"></div>
    <div v-html="value_en" class v-if="locales.en"></div>
    <div v-html="value_en" class v-if="locales.cn"></div>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      value: this.question_item.value,
      value_en: this.question_item.value_en
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
