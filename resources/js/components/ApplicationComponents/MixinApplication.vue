<script>
import { mapState } from "vuex";
import input_text from "./FormElements/Text";
import email from "./FormElements/Email";
import radio from "./FormElements/Radio";
import radio_dynamic_price from "./FormElements/RadioDynamicPrice";
import long_text from "./FormElements/TextArea";
import check from "./FormElements/CheckBox";
import file_upload from "./FormElements/FileUpload";
import info from "./FormElements/FormInfo";
import created_docs from "./AdditionalComponentsForForm/CreatedDocs";
import MixinStrategies from "./MixinStrategies";
export default {
  mixins: [MixinStrategies],
  data() {
    return {
      files: {},
      application_data: JSON.parse(this.application_data_for_user),

      created_docs: (() => {
        let submit_additional_data = {};
        JSON.parse(this.application_data_for_user).some(value => {
          if (
            Object.prototype.toString.call(
              JSON.parse(value.additional_data)
            ) === "[object Object]"
          ) {
            submit_additional_data = JSON.parse(value.additional_data);
            return true;
          }
        });

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
    application_data_for_user: "",
    additional_data_for_form: "",
    strategies: "",
    is_submitted: {
      default: false
    }
  },
  computed: {
    ...mapState(["locales", "current_locale"]),
    slots() {
      return new Set(this.application_data.map(val => val.slot_name));
    },
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
        .post(
          `/add_app_inst/${this.application_id}/${this.current_locale}`,
          this.createFormData(),
          {
            headers: {
              "Content-Type": "multipart/form-data",
              "X-CSRF-TOKEN": this.csrf_token
            }
          }
        )
        .then(data => {
          this.application_data = data.data.applicationDataForUser;
          this.created_docs = data.data.created_docs;
          this.clearErrorsObject();
          jAlert(
            JSON.parse(this.application_data[0].settings)["confirm"][
              this.current_locale
            ],
            ""
          );
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

  mounted() {},

  components: {
    input_text,
    radio,
    long_text,
    email,
    check,
    file_upload,
    info,
    radio_dynamic_price,
    created_docs
  }
};
</script>
