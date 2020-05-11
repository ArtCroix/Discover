<template>
  <div class="col-md-6 offset-md-4">
    <button
      type="submit"
      class="btn btn-primary"
      @click.prevent="submit"
    >{{ current_locale == 'ru' ? 'Зарегистрироваться' : current_locale == 'en' ? 'Register' : 'Register' }}</button>
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
      let form = document.querySelector('form[name="user_reg"]');
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
        .post(`/register/${this.current_locale}`, this.createFormData(), {
          headers: {
            "Content-Type": "multipart/form-data",
            "X-CSRF-TOKEN": this.csrf_token
          }
        })
        .then(data => {
          let message_arr = new Map([
            [
              "en",
              "Thank you for registering in your Discover account!\n" +
                "\n" +
                "A letter has been sent to the address indicated during registration with a link to confirm registration.\n" +
                "For further work with your personal account, you need to confirm the email address using the link from the letter."
            ],
            [
              "ru",
              "Благодарим Вас за регистрацию в личном кабинете Discover! \n" +
                "\n" +
                "На адрес, указанный при регистрации отправлено письмо со ссылкой для подтверждения регистрации. \n" +
                "Для дальнейшей работы с личным кабинетом Вам необходимо подтвердить адрес электронной почты по ссылке из письма."
            ],
            ["cn", "数据发送"]
          ]);
          let cur_loc = this.current_locale;
          jAlert(message_arr.get(cur_loc), "", function() {
            location = "/login/" + cur_loc;
          });
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
