<template>
  <div class="col-md-6 offset-md-4">
    <button
      type="submit"
      class="btn btn-primary"
      @click.prevent="submit"
    >Отредактировать мероприятие</button>
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      errors: {}
    };
  },
  props: {
    event_id: ""
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
    createFormData() {
      let form = document.querySelector('form[name="edit_event"]');
      let formData = new FormData(form);
      return formData;
    },
    clearErrorsObject() {
      for (let key in this.errors) {
        let error_block = document.querySelector(
          ".invalid-feedback" + "." + key
        );
        let error_input = document.querySelector(`input[name='${key}']`);
        if (error_input) error_input.classList.toggle("is-invalid");
        if (error_block) error_block.innerHTML = "";
      }
      this.errors = {};
    },
    submit() {
      this.clearErrorsObject();
      axios
        .post(`/admin/edit_event/${this.event_id}`, this.createFormData(), {
          headers: {
            "Content-Type": "multipart/form-data",
            "X-CSRF-TOKEN": this.csrf_token
          }
        })
        .then(data => {
          let message_arr = new Map([["ru", "Мероприятие отредактировано"]]);
          let cur_loc = this.current_locale;
          jAlert(message_arr.get(cur_loc));
        })
        .catch(errors => {
          this.errors = errors.response.data.errors;
          for (let key in this.errors) {
            let error_block = document.querySelector(
              ".invalid-feedback" + "." + key
            );
            let error_input = document.querySelector(`input[name='${key}']`);
            if (error_block) error_block.innerHTML = this.errors[key];
            if (error_input) error_input.classList.toggle("is-invalid");
          }
          let error_arr = new Map([["ru", "Неверно заполнены поля"]]);
          jAlert(error_arr.get(this.current_locale), "");
        });
    }
  }
};
</script>
