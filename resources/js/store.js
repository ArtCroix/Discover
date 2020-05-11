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
    current_locale: "ru",
    tabs_data: [],
    is_coach_participated: false,
    display_invitations: {
      user_2: false,
      user_3: false,
      coach: false
    }
  },
  mutations: {
    changeLocale({ locales }, current_locale) {
      locales[current_locale] = true;
      this.state.current_locale = current_locale;
    },
    changeTabsData(state, tabs_data) {
      state.tabs_data = tabs_data;
    },
    changeCoachParticipateStatus(state, is_coach_participated) {
      state.is_coach_participated = is_coach_participated;
    },
    changeDisplayInvitations(state, display_invitations) {
      state.display_invitations = display_invitations;
    }
  },
  actions: {
    changeLocale({ commit }, current_locale) {
      commit("changeLocale", current_locale);
    },
    changeTabsData({ commit }, tabs_data) {
      commit("changeTabsData", tabs_data);
    },
    changeCoachParticipateStatus({ commit }, is_coach_participated) {
      commit("changeCoachParticipateStatus", is_coach_participated);
    },
    changeDisplayInvitations({ commit }, display_invitations) {
      commit("changeDisplayInvitations", display_invitations);
    }
  }
});

export default store;
