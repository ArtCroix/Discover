<template>
  <div class="cotainer-fluid w-75 mx-auto">
    <form name="app_form" method="POST" enctype="multipart/form-data">
      <component
        @addedfile="addFileToFormData($event)"
        v-for="(question_item, index) in application_data"
        :question_item="question_item"
        :key="index"
        :is="question_item.type"
        :errors="errors"
      ></component>
      <input type="hidden" name="_token" :value="csrf_token" />
      <button type="submit" @click.prevent="submit()" class="btn btn-primary">Sign in</button>
    </form>
    <show_created_docs :created_docs="created_docs"></show_created_docs>
  </div>
</template>

<script>
import form_components from "./FormComponents/MixinFormComponents";
import show_created_docs from "./ShowCreatedDocs";

export default {
  data() {
    return {
      files: {},
      application_data: JSON.parse(this.application_data_for_user),
      created_docs: JSON.parse(
        JSON.parse(this.application_data_for_user)[0].created_docs
      ),
      errors: {}
    };
  },

  props: {
    application_data_for_user: ""
  },

  computed: {
    application_id() {
      return this.application_data[0].application_id;
    },
    computed_created_docs() {
      // console.log("ff", JSON.parse(this.application_data[0].created_docs));
      return JSON.parse(
        JSON.parse(this.application_data_for_user)[0].created_docs
      );
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

    clearErrorsObject() {
      this.errors = {};
    },

    createFormData() {
      let form = document.querySelector('form[name="app_form"]');

      let formData = new FormData(form);

      for (let files_field in this.files) {
        this.files[files_field].forEach(file => {
          formData.append(files_field + "[]", file);
        });
      }
      return formData;
    },

    submit() {
      axios
        .post("/add_app_inst/" + this.application_id, this.createFormData(), {
          headers: {
            "Content-Type": "multipart/form-data",
            "X-CSRF-TOKEN": this.csrf_token
          }
        })
        .then(data => {
          console.log(data.data);
          this.application_data = data.data.applicationDataForUser;
          this.created_docs = data.data.doc_creating;
          alert("Данные отправлены");
          console.log("SUCCESS!!");
        })
        .catch(errors => {
          this.errors = errors.response.data.errors;
          console.log(this.errors);
          alert("Не верно заполнены поля");
          console.log("FAILURE!!");
        });
    }
  },
  components: {
    show_created_docs
  },
  mixins: [form_components],

  mounted() {
    // console.log("ff", this.computed_created_docs);
    /*             console.log(this.questions);
                          console.log(this.old_inputs); */
  }
};
</script>
