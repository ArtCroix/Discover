let strategies_action = {
  invitation() {
    if (this.is_submitted == "false") {
      console.log("falsss");
      let answers_for_team_reg_app = JSON.parse(this.additional_data_for_form)[
        "answers_for_team_reg_app"
      ];
      answers_for_team_reg_app.forEach(answer => {
        for (let index = 0; index < this.application_data.length; index++) {
          if (this.application_data[index].name == answer.name) {
            this.application_data[index].answer = answer.answer;
            break;
          }
        }
      });
    }
  }
};

export default strategies_action;
