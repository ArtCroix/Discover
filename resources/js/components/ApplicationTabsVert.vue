<template>
  <div class="row justify-content-center">
    <div class="col-3">
      <div
        class="nav flex-column nav-pills"
        id="v-pills-tab"
        role="tablist"
        aria-orientation="vertical"
      >
        <a
          class="nav-link"
          :class="current_app_id==0 ? 'active':''"
          :href="`/home/event/${event_name}/status/${current_locale}`"
        >{{ current_locale == 'ru' ? 'Общая информация по мероприятию' : current_locale == 'en' ? 'Event general information' : 'Event general information' }}</a>

        <a
          v-for="(tab, key) in event_applications_data"
          :key="key"
          v-if="ifPreviousAppIsSubmitted(tab.depends_on)"
          class="nav-link"
          :class="current_app_id==tab.application_id ? 'active':''"
          :href="`/home/event/${tab.event_name}/app/${tab.application_id}/${current_locale}`"
        >{{JSON.parse(tab.tab_title)[current_locale]}}</a>
        <!--         <a v-else>
          {{ JSON.parse(tab.tab_title)[current_locale] }} ({{ JSON.parse(tab.settings)['tab_access_begin'][current_locale] }}
          <a
            :href="`/home/event/${tab.event_name}/app/${getNeededApp(tab.depends_on)}/${current_locale}`"
          >{{ JSON.parse(tab.settings)['tab_access_end'][current_locale] }}</a>)
        </a>-->
      </div>
    </div>
  </div>
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
    ...mapState(["locales", "current_locale"]),
    csrf_token() {
      return document
        .getElementsByTagName("meta")
        ["csrf-token"].getAttribute("content");
    }
  },
  methods: {
    ifPreviousAppIsSubmitted(depends_on) {
      if (!depends_on) return true;
      return this.event_applications_data.some(tab_data => {
        return tab_data.submitted_application == depends_on;
      });
    },
    getNeededApp(depends_on) {
      let needed_app = this.event_applications_data.filter(tab_data => {
        return tab_data.application_id == depends_on;
      });
      console.log(needed_app);
      return needed_app[0].application_id;
    }
  },
  mounted() {
    // console.log(this.event_applications_data);
  }
};
</script>
