<template>
  <div class="col-md-6 offset-md-4">
    <button
      type="submit"
      class="btn btn-primary"
      @click.prevent="submit"
    >{{ current_locale == 'ru' ? 'Сохранить' : current_locale == 'en' ? 'Save' : 'Save' }}</button>
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
    form_name: "",
    post_action: "",
    success_message: "",
    submit_button_text: ""
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
      let form = document.querySelector(`form[name="${this.form_name}"]`);
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
        .post(`${this.post_action}`, this.createFormData(), {
          headers: {
            "Content-Type": "multipart/form-data",
            "X-CSRF-TOKEN": this.csrf_token
          }
        })
        .then(data => {
          let message_arr = new Map([
            ["en", "Data was saved"],
            ["ru", "Данные успешно сохранены"],
            ["cn", "数据发送"]
          ]);
          jAlert(message_arr.get(this.current_locale), "");
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
          let error_arr = new Map([
            ["en", "Invalid fields"],
            ["ru", "Неверно заполнены поля"],
            ["cn", "无效的栏位"]
          ]);
          jAlert(error_arr.get(this.current_locale), "");
        });
    }
  }
};
</script>
