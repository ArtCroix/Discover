<template>
  <div class="mt-4">
    <p v-html="label" class="mb-1" v-if="locales.ru" :for="question_id"></p>
    <p v-html="label_en" class="mb-1" v-if="locales.en" :for="question_id"></p>
    <p v-html="label_en" class="mb-1" v-if="locales.cn" :for="question_id"></p>
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
        :name="question_id+'#'+name"
        :id="question_id+'_'+presentation"
        :value="value"
      />
      <label
        class="form-check-label"
        :for="question_id+'_'+presentation"
      >{{prices[current_locale][value]}} {{presentation}}</label>
    </div>
    <div class="invalid_form error" :class="name">{{current_error}}</div>
  </div>
</template>

<script>
import { mapState } from "vuex";
import Radio from "./Radio";
export default {
  mixins: [Radio],
  data() {
    return {
      price: JSON.parse(this.question_item.price),
      prices: { ru: {}, en: {} }
    };
  },

  computed: {
    ...mapState(["locales", "current_locale"])
  },

  methods: {
    getCurrentPrice() {
      let { rub, usd } = this.price;
      let current_date = new Date();
      let month = ("0" + (current_date.getMonth() + 1)).slice(-2);
      let date = ("0" + (current_date.getDate() + 1)).slice(-2);

      var year = current_date.getFullYear();

      let now = year + "-" + month + "-" + date;

      let price_types = this.question_item.value
        .split("\n")
        .map(value => value.trim());

      price_types.forEach(type => {
        for (let date in rub[type]) {
          if (new Date(now) <= new Date(date)) {
            this.prices["ru"][type] = rub[type][date];
            break;
          } else {
            this.prices["ru"][type] = rub[type][date];
          }
        }
      });

      price_types.forEach(type => {
        for (let date in usd[type]) {
          if (new Date(now) <= new Date(date)) {
            this.prices["en"][type] = usd[type][date];
            break;
          } else {
            this.prices["en"][type] = usd[type][date];
          }
        }
      });
    }
  },

  beforeMount() {
    this.getCurrentPrice();
  }
};
</script>
