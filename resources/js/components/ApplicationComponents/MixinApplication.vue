<script>
import { mapState } from "vuex";
import input_text from "./FormElements/Text";
import email from "./FormElements/Email";
import radio from "./FormElements/Radio";
import radio_coach from "./FormElements/RadioCoach";
import is_coach_in from "./FormElements/CheckCoachParticipation";
import text_coach from "./FormElements/TextCoach";
import email_coach from "./FormElements/EmailCoach";
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
    app_files_json: {
      default: []
    },
    strategies: "",
    is_submitted: {
      default: false
    }
  },
  computed: {
    ...mapState(["locales", "current_locale", "tabs_data"]),

    app_files() {
      return JSON.parse(this.app_files_json);
    },

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
    }
  },

  mounted() {
    console.log(this.app_files);

    //Выполнить стратегии
    JSON.parse(this.strategies).forEach(strategy_action => {
      this[strategy_action]();
    });
  },

  components: {
    input_text,
    radio,
    long_text,
    email,
    check,
    file_upload,
    info,
    radio_coach,
    is_coach_in,
    email_coach,
    text_coach,
    created_docs
  }
};
</script>
