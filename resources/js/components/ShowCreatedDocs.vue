<template>
  <div class="cotainer-fluid w-75 mx-auto">
    <ul>
      <li v-for="(doc,key) in created_docs" :key="key">
        <a download :href="'/storage/'+doc">{{doc.split("/").slice(-1)[0]}}</a>
      </li>
    </ul>
  </div>
</template>

<script>
export default {
  data() {
    return {};
  },

  props: {
    created_docs: {
      type: Array,
      default() {
        return [];
      }
    }
  },

  computed: {
    docs() {
      return this.created_docs;
    }
  },

  methods: {},

  mounted() {
    console.log(this.created_docs);
    /*             console.log(this.questions);
                          console.log(this.old_inputs); */
  }
};
</script>
