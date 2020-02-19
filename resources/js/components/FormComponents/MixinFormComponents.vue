<script>
import InputText from "./Text";
import Email from "./Email";
import Radio from "./Radio";
import TextArea from "./TextArea";
import CheckBox from "./CheckBox";
import FileUpload from "./FileUpload";
import FormInfo from "./FormInfo";
import FormPortal from "./FormPortal";
// import form_components from "./FormComponents/MixinFormComponents";
import show_created_docs from "../ShowCreatedDocs";
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

  mounted() {
    // console.log(this.application_data);
    // console.log("ff", this.computed_created_docs);
    /*             console.log(this.questions);
                          console.log(this.old_inputs); */
  },
  components: {
    input_text: InputText,
    radio: Radio,
    long_text: TextArea,
    email: Email,
    check: CheckBox,
    file_upload: FileUpload,
    info: FormInfo,
    portal: FormPortal,
    show_created_docs
  }
};
</script>
