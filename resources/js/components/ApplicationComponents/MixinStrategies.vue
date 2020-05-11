<script>
export default {
  methods: {
    invitation() {
      let display_invitations = {
        user_2: false,
        user_3: false,
        coach: false
      };

      let answers_for_team_reg_app = JSON.parse(this.additional_data_for_form)[
        "answers_for_team_reg_app"
      ];

      answers_for_team_reg_app.forEach(answer => {
        if (answer.name == "lastname_2" && answer.answer) {
          display_invitations.user_2 = true;
        }
        if (answer.name == "lastname_3" && answer.answer) {
          display_invitations.user_3 = true;
        }
        if (answer.name == "coach_participate" && answer.answer == "Да") {
          display_invitations.coach = true;
        }
        // if (this.is_submitted == "false") {
        for (let index = 0; index < this.application_data.length; index++) {
          if (
            this.application_data[index].name == answer.name &&
            this.application_data[index].answer == ""
          ) {
            this.application_data[index].answer = answer.answer;
            break;
          }
          // }
        }
      });

      /*  answers_for_team_reg_app.forEach(answer => {
        if (answer.name == "lastname_2" && answer.answer) {
          for (let index = 0; index < this.application_data.length; index++) {
            if (this.application_data[index].slot_name == answer.slot_name) {
              display_invitations.user_2 = true;
            }
          }
        }
        if (answer.name == "lastname_3" && answer.answer) {
          for (let index = 0; index < this.application_data.length; index++) {
            if (this.application_data[index].slot_name == answer.slot_name) {
              display_invitations.user_3 = true;
            }
          }
        }
        if (answer.name == "coach_participate" && answer.answer == "Да") {
          for (let index = 0; index < this.application_data.length; index++) {
            if (this.application_data[index].slot_name == answer.slot_name) {
              display_invitations.coach = true;
            }
          }
        }
      }); */
      this.$store.dispatch("changeDisplayInvitations", display_invitations);
    }
  }
};
</script>
