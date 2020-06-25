<template>
  <div class="example-multiple">
    <h5 class="mt-3">Общие файлы:</h5>
    <ul>
      <li v-for="(file, index) in uploaded_common_materials" :key="file.id">
        <span>{{file.split("/").pop()}}</span>
        <button
          type="button"
          @click="deleteMaterial(file, {type:'uploaded_common_materials',index:index} )"
          class="btn btn-danger"
        >Удалить</button>
      </li>
    </ul>
    <div class="upload">
      <ul>
        <li v-for="(file) in common_materials" :key="file.id">
          <span>{{file.name}}</span>
          <span v-if="file.error">{{file.error}}</span>
          <span v-else-if="file.success">
            <button
              type="button"
              @click.prevent="$refs.upload1.remove(file)"
              @click="deleteMaterial(`/events/${event_name}/materials/${file.name}`)"
              class="btn btn-danger"
            >Удалить</button>
          </span>
          <span v-else-if="file.active">active</span>
          <span v-else></span>
        </li>
      </ul>
      <div class="example-btn">
        <file-upload
          class="btn btn-primary"
          :headers="headerInfo"
          input-id="file1"
          :post-action="`/admin/events/${this.event_name}/upload_materials`"
          @input-file="inputFile"
          v-model="common_materials"
          :multiple="multiple"
          ref="upload1"
        >
          <i class="fa fa-plus"></i>
          Выбрать общие файлы
        </file-upload>
      </div>
    </div>
    <hr />

    <h5 class="mt-3">Файлы на русском:</h5>
    <ul>
      <li v-for="(file, index) in uploaded_ru_materials" :key="file.id">
        <span>{{file.split("/").pop()}}</span>
        <button
          type="button"
          @click="deleteMaterial(file, {type:'uploaded_ru_materials',index:index} )"
          class="btn btn-danger"
        >Удалить</button>
      </li>
    </ul>
    <div class="upload">
      <ul>
        <li v-for="(file) in ru_materials" :key="file.id">
          <span>{{file.name}}</span>
          <span v-if="file.error">{{file.error}}</span>
          <span v-else-if="file.success">
            <button
              type="button"
              @click.prevent="$refs.upload2.remove(file)"
              @click="deleteMaterial(`/events/${event_name}/materials/ru/${file.name}`)"
              class="btn btn-danger"
            >Удалить</button>
          </span>
        </li>
      </ul>
      <div class="example-btn">
        <file-upload
          class="btn btn-primary"
          :headers="headerInfo"
          @click.prevent="$refs.upload2.remove(file)"
          input-id="file2"
          :post-action="`/admin/events/${this.event_name}/upload_materials/ru`"
          @input-file="inputFile"
          v-model="ru_materials"
          :multiple="multiple"
          ref="upload2"
        >
          <i class="fa fa-plus"></i>
          Выбрать русскоязычные файлы
        </file-upload>
      </div>
    </div>
    <hr />

    <h5 class="mt-3">Файлы на английском:</h5>
    <ul>
      <li v-for="(file, index) in uploaded_en_materials" :key="file.id">
        <span>{{file.split("/").pop()}}</span>
        <button
          type="button"
          @click="deleteMaterial(file, {type:'uploaded_en_materials',index:index} )"
          class="btn btn-danger"
        >Удалить</button>
      </li>
    </ul>
    <div class="upload">
      <ul>
        <li v-for="(file) in en_materials" :key="file.id">
          <span>{{file.name}}</span>
          <span v-if="file.error">{{file.error}}</span>
          <span v-else-if="file.success">
            <button
              type="button"
              @click.prevent="$refs.upload3.remove(file)"
              @click="deleteMaterial(`/events/${event_name}/materials/en/${file.name}`)"
              class="btn btn-danger"
            >Удалить</button>
          </span>
        </li>
      </ul>
      <div class="example-btn">
        <file-upload
          class="btn btn-primary"
          :headers="headerInfo"
          @click.prevent="$refs.upload3.remove(file)"
          input-id="file3"
          :post-action="`/admin/events/${this.event_name}/upload_materials/en`"
          @input-file="inputFile"
          v-model="en_materials"
          :multiple="multiple"
          ref="upload3"
        >
          <i class="fa fa-plus"></i>
          Выбрать англоязычные файлы
        </file-upload>
      </div>
    </div>
    <hr />
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
      headerInfo: {
        "X-CSRF-TOKEN": document
          .getElementsByTagName("meta")
          ["csrf-token"].getAttribute("content")
      },
      uploaded_common_materials: JSON.parse(
        this.uploaded_common_materials_json
      ),
      uploaded_ru_materials: JSON.parse(this.uploaded_ru_materials_json),
      uploaded_en_materials: JSON.parse(this.uploaded_en_materials_json),
      common_materials: [],
      ru_materials: [],
      en_materials: [],
      multiple: true
    };
  },

  props: {
    uploaded_common_materials_json: "",
    uploaded_ru_materials_json: "",
    uploaded_en_materials_json: "",
    event_name: ""
  },

  computed: {
    ...mapState(["locales"]),

    csrf_token() {
      return document
        .getElementsByTagName("meta")
        ["csrf-token"].getAttribute("content");
    }

    /*  uploaded_ru_materials() {
      return JSON.parse(this.uploaded_ru_materials_json);
    },

    uploaded_en_materials() {
      return JSON.parse(this.uploaded_en_materials_json);
    } */

    /*  uploaded_common_materials() {
      return JSON.parse(this.uploaded_common_materials_json);
    } */
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

      if (
        Boolean(newFile) !== Boolean(oldFile) ||
        oldFile.error !== newFile.error
      ) {
        if (!this.$refs.upload1.active) {
          this.$refs.upload1.active = true;
        }
        if (!this.$refs.upload2.active) {
          this.$refs.upload2.active = true;
        }
        if (!this.$refs.upload3.active) {
          this.$refs.upload3.active = true;
        }
      }
    },

    deleteMaterial(file_path, material) {
      axios
        .delete(`/admin/events/delete_materials`, {
          data: {
            file_path
          }
        })
        .then(() => {
          this[material.type].splice(material.index, 1);
          console.log("SUCCESS!!");
        })
        .catch(() => {
          console.log("FAILURE!!");
        });
    }
  },
  mounted() {
    console.log(this.common_materials);
  }
};
</script>
