<template>
  <div class="cotainer-fluid w-75 mx-auto">
    <div v-html="JSON.parse(application_data[0].description)[current_locale]"></div>
    <form name="app_form" method="POST" enctype="multipart/form-data">
      <component :is="layoutComponent">
        <template v-for="(slot) in slots" v-slot:[slot]>
          <component
            v-for="(question_item, index) in application_data"
            v-if="question_item.slot_name==slot"
            @addedfile="addFileToFormData($event)"
            :question_item="question_item"
            :key="index"
            :is="question_item.type"
            :errors="errors"
          ></component>
        </template>
      </component>
      <input type="hidden" name="_token" :value="csrf_token" />
      <button
        type="submit"
        @click.prevent="submit()"
        class="btn btn-primary"
      >{{ JSON.parse(application_data[0].settings)['submit_button'][current_locale] }}</button>
    </form>
    <created_docs :created_docs="created_docs"></created_docs>
  </div>
</template>

<script>
import MixinApplication from "./ApplicationComponents/MixinApplication";

export default {
  mixins: [MixinApplication],
  props: {
    user_id: ""
  },
  methods: {
    submit() {
      axios
        .post(
          `/admin/edit_app/${this.application_id}/${this.user_id}`,
          this.createFormData(),
          {
            headers: {
              "Content-Type": "multipart/form-data",
              "X-CSRF-TOKEN": this.csrf_token
            }
          }
        )
        .then(data => {
          console.log(data);
          this.application_data = data.data.applicationDataForUser;
          this.created_docs = data.data.created_docs;
          this.clearErrorsObject();

          let tabs_data = this.tabs_data.map(tab => {
            // console.log(this.application_id);
            if (tab.application_id == this.application_id) {
              tab.submitted_application = this.application_id;
            }
            return tab;
          });
          this.$store.dispatch("changeTabsData", tabs_data);
          console.log(tabs_data);
          jAlert(
            JSON.parse(this.application_data[0].settings)["confirm"][
              this.current_locale
            ],
            "",
            () => {
              (async () => {
                // await document.location.reload();
                await window.scrollTo(0, 0);
              })();
            }
          );
          // document.location.reload(true);
        })
        .catch(errors => {
          this.errors = errors.response.data.errors;
          jAlert(
            JSON.parse(this.application_data[0].settings)["error"][
              this.current_locale
            ],
            ""
          );
        });
    }
  },
  mounted() {}
};
</script>
