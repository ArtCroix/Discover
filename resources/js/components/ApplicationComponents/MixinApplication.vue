<script>
import input_text from "./FormElements/Text";
import email from "./FormElements/Email";
import radio from "./FormElements/Radio";
import long_text from "./FormElements/TextArea";
import check from "./FormElements/CheckBox";
import file_upload from "./FormElements/FileUpload";
import info from "./FormElements/FormInfo";
import created_docs from "./AdditionalComponentsForForm/CreatedDocs";

export default {
  data() {
    return {
      files: {},
      application_data: JSON.parse(this.application_data_for_user),
      created_docs: (() => {
        let submit_additional_data =
          JSON.parse(
            JSON.parse(this.application_data_for_user)[0].additional_data
          ) || {};
        if ("created_docs" in submit_additional_data) {
          return submit_additional_data.created_docs;
        } else {
          return [];
        }
      })(),
      errors: {}
    };
  },

  props: {
    application_data_for_user: ""
  },
  computed: {
    layoutComponent() {
      return () => import(`./Layouts/${this.application_data[0].layout}`);
    },

    application_id() {
      return this.application_data[0].application_id;
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

  mounted() {},

  components: {
    input_text,
    radio,
    long_text,
    email,
    check,
    file_upload,
    info,
    created_docs
  }
};
</script>
