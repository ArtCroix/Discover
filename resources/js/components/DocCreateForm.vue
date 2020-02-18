<template>
  <div class="cotainer-fluid w-75 mx-auto">
    <form name="app_form" method="POST" enctype="multipart/form-data">
      <component
        :is_submit_fired="is_submit_fired"
        @addedfile="addFileToFormData($event)"
        v-for="(question_item, index) in questions_data"
        :question_item="question_item"
        :key="index"
        :is="question_item.type"
      ></component>
      <input type="hidden" name="_token" :value="csrf_token" />
      <button type="submit" @click.prevent="submit()" class="btn btn-primary">Sign in</button>
    </form>
  </div>
</template>

<script>
import form_components from "./FormComponents/MixinFormComponents";

export default {
  data() {
    return {
      files: {},
      questions_array: JSON.parse(this.questions),
      is_submit_fired: {
        submit_id: 0,
        status: false
      }
    };
  },

  props: {
    questions: ""
  },

  computed: {
    questions_data() {
      return this.questions_array;
    },
    csrf_token() {
      return document
        .getElementsByTagName("meta")
        ["csrf-token"].getAttribute("content");
    }
  },

  methods: {
    addFileToFormData(e) {
      let file_input_name = Object.keys(e.files);
      this.files[file_input_name] = Object.values(e.files[file_input_name[0]]);
    },

    submit() {
      let form = document.querySelector('form[name="app_form"]');

      let formData = new FormData(form);
      // console.log(this.files);

      for (let files_field in this.files) {
        this.files[files_field].forEach(file => {
          formData.append(files_field + "[]", file);
        });
      }

      axios
        .post(
          "/create_doc/" + this.questions_data[0].application_id,
          formData,
          {
            headers: {
              "Content-Type": "multipart/form-data",
              "X-CSRF-TOKEN": this.csrf_token
            }
          }
        )
        .then(data => {
          // console.log(data.data.submit);
          this.questions_array = data.data.submit;
          alert("Данные отправлены");
          console.log("SUCCESS!!");
        })
        .catch(data => {
          // console.log(data);
          alert("Не верно заполнены поля");
          console.log("FAILURE!!");
        });
    }
  },

  mixins: [form_components],

  mounted() {
    // console.log(this.questions_data);
    /*             console.log(this.questions);
                          console.log(this.old_inputs); */
  }
};
</script>
