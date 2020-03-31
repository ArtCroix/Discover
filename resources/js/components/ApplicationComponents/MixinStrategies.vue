


<script>
import strategies_action from "./strategies";
export default {
  methods: {
    ...strategies_action
  },

  mounted() {
    JSON.parse(this.strategies).forEach(strategy_action => {
      this[strategy_action]();
    });
  }
};
</script>
