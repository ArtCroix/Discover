import Vue from "vue";
import Vuex from "vuex";
Vue.use(Vuex);
const store = new Vuex.Store({
  state: {
    locales: {
      ru: false,
      cn: false,
      en: false
    },
    current_locale: "ru"
  },
  mutations: {
    changeLocale({ locales }, current_locale) {
      locales[current_locale] = true;
      this.state.current_locale = current_locale;
    }
  },
  actions: {
    changeLocale({ commit }, current_locale) {
      commit("changeLocale", current_locale);
    }
  }
});

export default store;
