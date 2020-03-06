<template>
  <div class="py-3">
    <label v-if="locales.ru" :for="question_id">{{label}}</label>
    <label v-if="locales.en" :for="question_id">{{label_en}}</label>
    <label v-if="locales.cn" :for="question_id">{{label_en}}</label>
    <div class="uploaded_files" v-if="uploaded_files.length">
      <p class="mb-1">
        <strong>Загруженные файлы</strong>
      </p>
      <table>
        <tbody>
          <tr v-for="(file_path, index) in uploaded_files" :key="index">
            <td>{{file_path.split("/").pop()}}</td>
            <td>
              <button
                type="button"
                @click="deleteFileFromAppSubmit(file_path, index)"
                class="btn btn-danger"
              >Удалить</button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    <div class="upload">
      <ul>
        <li class="mt-2" v-for="(file, index) in files" :key="index">
          <span>{{file.name}}</span> -
          <span>{{file.size}}</span> -
          <span v-if="file.error">{{file.error}}</span>
          <span v-else-if="file.success">success</span>
          <span v-else-if="file.active">active</span>
          <span v-else-if="file.active">active</span>
          <span v-else></span>
          <button
            @click.prevent="$refs.upload.remove(file)"
            type="button"
            class="btn btn-warning"
          >Отменить загрузку</button>
        </li>
      </ul>
      <div class="example-btn">
        <file-upload
          class="btn btn-primary"
          extensions="gif,jpg,jpeg,png,webp"
          accept="image/png, image/gif, image/jpeg, image/webp"
          :name="question_id+'#'+name"
          :multiple="true"
          :size="1024 * 1024 * 10"
          :inputId="question_id"
          v-model="files"
          @input-filter="inputFilter"
          @input-file="inputFile"
          ref="upload"
        >
          <i class="fa fa-plus"></i>
          Select files
        </file-upload>
      </div>
    </div>
  </div>
</template>
<script>
import VueUploadComponent from "vue-upload-component";
import { mapState } from "vuex";
export default {
  components: {
    fileUpload: VueUploadComponent
  },

  data() {
    return {
      files: [],
      uploadAuto: false,
      question_id: this.question_item.question_id,
      submit_id: this.question_item.submit_id,
      application_id: this.question_item.application_id,
      question_value: this.question_item.value,
      label: this.question_item.label,
      name: this.question_item.name
      //   answer: this.question_item.answer
    };
  },

  props: {
    question_item: ""
  },

  computed: {
    ...mapState(["locales"]),
    answer() {
      return this.question_item.answer || JSON.stringify([]);
    },

    uploaded_files() {
      this.files = [];
      return JSON.parse(this.answer);
    }
  },

  methods: {
    inputFilter(newFile, oldFile, prevent) {
      if (newFile && !oldFile) {
        // Before adding a file
        // 添加文件前
        // Filter system files or hide files
        // 过滤系统文件 和隐藏文件
        if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
          return prevent();
        }
        // Filter php html js file
        // 过滤 php html js 文件
        if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
          return prevent();
        }
      }
    },

    inputFile(newFile, oldFile) {
      if (newFile && !oldFile) {
        // add
        // console.log("add", newFile);
      }
      if (newFile && oldFile) {
        // update
        // console.log("update", newFile);
      }
      if (!newFile && oldFile) {
        // remove
        // console.log("remove", oldFile);
      }

      let files = {
        [this.question_id + "#" + this.name]: []
      };

      this.files.map(value =>
        files[this.question_id + "#" + this.name].push(value.file)
      );

      this.$emit("addedfile", {
        files: files
      });
    },

    deleteFileFromAppSubmit(file_path, index) {
      axios
        .delete("/delete_file_from_app_submit/" + this.application_id, {
          data: {
            file_path,
            submit_id: this.submit_id,
            question_id: this.question_id
          }
        })
        .then(() => {
          let arr = [...JSON.parse(this.question_item.answer)];
          arr.splice(index, 1);
          this.question_item.answer = JSON.stringify(arr);
          console.log("SUCCESS!!");
        })
        .catch(() => {
          console.log("FAILURE!!");
        });
    }
  },
  mounted() {
    // console.log(this.question_item);
  }
};
</script>
