<template>
  <button type="button" class="btn btn-danger" @click.prevent="submit">Удалить</button>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      errors: {},
      user_id: JSON.parse(this.user_id_json),
      team_id: JSON.parse(this.team_id_json)
    };
  },
  props: {
    user_id_json: "",
    team_id_json: ""
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
        .post(`/admin/teams/users/unbind/${this.team_id}/${this.user_id}`, {
          headers: {
            "Content-Type": "multipart/form-data",
            "X-CSRF-TOKEN": this.csrf_token
          }
        })
        .then(data => {
          let message_arr = new Map([
            ["en", "Data was changed"],
            ["ru", "Данные успешно изменены"],
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
