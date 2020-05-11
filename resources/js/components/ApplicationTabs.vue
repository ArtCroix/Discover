<template>
  <nav>
    <div
      class="nav nav-tabs align-items-center flex-column flex-sm-row"
      id="nav-tab"
      role="tablist"
    >
      <a
        class="nav-link nav-item"
        :class="current_app_id==0 ? 'active':''"
        :href="`/home/event/${event_name}/status/${current_locale}`"
      >{{ current_locale == 'ru' ? 'Общая информация по мероприятию' : current_locale == 'en' ? 'Event general information' : 'Event general information' }}</a>
      <a
        v-for="(tab, key) in tabs_data"
        :key="key"
        v-if="ifPreviousAppIsSubmitted(tab.depends_on)"
        class="nav-link nav-item"
        :class="current_app_id==tab.application_id ? 'active':''"
        :href="`/home/event/${tab.event_name}/app/${tab.application_id}/${current_locale}`"
      >{{JSON.parse(tab.tab_title)[current_locale]}}</a>
      <span class="nav-link nav-item disabled" v-else>
        {{ JSON.parse(tab.tab_title)[current_locale] }} {{ JSON.parse(tab.settings)['tab_access_begin'][current_locale] }}
        <a
          :href="`/home/event/${tab.event_name}/app/${getNeededApp(tab.depends_on)}/${current_locale}`"
        >{{ JSON.parse(tab.settings)['tab_access_end'][current_locale] }}</a>
      </span>
    </div>
  </nav>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      event_applications_data: JSON.parse(this.event_applications),
      event_name: JSON.parse(this.event_applications)[0]["event_name"]
    };
  },
  props: {
    event_applications: "",
    current_app_id: ""
  },
  computed: {
    ...mapState(["locales", "current_locale", "tabs_data"]),
    csrf_token() {
      return document
        .getElementsByTagName("meta")
        ["csrf-token"].getAttribute("content");
    }
  },
  methods: {
    ifPreviousAppIsSubmitted(depends_on) {
      if (!depends_on) return true;
      let depends_on_arr = depends_on.split(",");

      let status = [];
      depends_on_arr.forEach(depend_app => {
        this.event_applications_data.some(tab_data => {
          if (tab_data.submitted_application == depend_app) {
            status.push(true);
          }
        });
      });
      if (status.length == depends_on_arr.length) {
        return true;
      }
      return false;
    },
    getNeededApp(depends_on) {
      let needed_app = this.event_applications_data.filter(tab_data => {
        return tab_data.application_id == depends_on[0];
      });
      // console.log(needed_app);
      return needed_app[0].application_id;
    }
  },
  beforeMount() {
    this.$store.dispatch("changeTabsData", this.event_applications_data);
  },
  mounted() {}
};
</script>
