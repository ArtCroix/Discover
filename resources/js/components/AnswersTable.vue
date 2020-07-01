<template>
  <table class="table table-bordered table-responsive">
    <thead>
      <tr>
        <th scope="col">user_id</th>
        <th scope="col">submit_id</th>
        <th scope="col">Фамилия</th>
        <th scope="col">Имя</th>
        <th scope="col">Отчество</th>
        <th v-for="(question) in questions" :key="question.id" scope="col">{{question.label}}</th>
        <th>Удалить сабмит</th>
        <th>Открепить от сабмита</th>
      </tr>
    </thead>
    <tbody>
      <template v-for="(submit)  in submits">
        <tr v-for="(user) in submit.users" :key="user.id">
          <td>
            <a target="_blank" :href="'/admin/users/'+user.id">{{user.id}}</a>
          </td>
          <td>
            <a target="_blank" :href="'/admin/edit_submit/'+submit.id">{{submit.id}}</a>
          </td>
          <td>{{user.firstname}}</td>
          <td>{{user.lastname}}</td>
          <td>{{user.middlename}}</td>
          <template v-for="(answer) in answers[submit.id]">
            <td v-if="answer.question.type=='file_upload'" :key="answer.id">
              <p>
                <a
                  download
                  :href="`/storage/events/${application.event.event_name}/applications/${application.id}/users_data/${user.id}/uploaded/${user.id}.zip`"
                >Скачать</a>
              </p>
            </td>
            <!--         <td
              v-if="answer.question.type=='file_upload'"
              :key="answer.id"
              v-html="parseFilesField(answer.value)"
            ></td>-->
            <td v-else :key="answer.id">{{answer.value}}</td>
          </template>
          <td>
            <a :href="'/admin/submits/delete/'+submit.id">
              <button>Удалить сабмит</button>
            </a>
          </td>
          <td>
            <a :href="'/admin/submits/unbind/'+user.id+'/'+submit.id">
              <button>Открепить от сабмита</button>
            </a>
          </td>
        </tr>
      </template>
    </tbody>
  </table>
</template>

<script>
import { mapState } from "vuex";
export default {
  data() {
    return {
      errors: {}
    };
  },
  props: {
    answers_json: "",
    submits_json: "",
    questions_json: "",
    application_json: ""
  },
  computed: {
    ...mapState(["locales", "current_locale"]),
    csrf_token() {
      return document
        .getElementsByTagName("meta")
        ["csrf-token"].getAttribute("content");
    },
    answers() {
      return JSON.parse(this.answers_json);
    },
    submits() {
      return JSON.parse(this.submits_json);
    },
    questions() {
      return JSON.parse(this.questions_json);
    },
    application() {
      return JSON.parse(this.application_json);
    }
  },
  methods: {
    parseFilesField(value) {
      let files = JSON.parse(value);
      return files.reduce((result_string, file) => {
        return (
          result_string +
          `<p><a download href='/storage/${file}'>Скачать</a></p>`
        );
      }, "");
      return result_string;
    }
  },

  beforeMount() {
    console.log(this.answers);
    console.log(this.submits);
    console.log(this.questions);
    console.log(this.application);
  }
};
</script>
