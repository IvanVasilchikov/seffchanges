require('./label.scss');
import VueBus from '../../../base/scripts/vue/v-bus';
const template = require('./label.pug');

export default template({
  data() {
    return {
      checked: false,
    }
  },
  methods: {
    toggleChecked() {
      this.checked = !this.info.checked;
      this.$set(this.info, 'checked', this.checked);
      this.$emit('change', this.info);
    }
  },
  created() {
    if (this.info.checked) {
      this.checked = this.info.checked;
    } else this.$set(this.info, 'checked', this.checked);

    VueBus.$on('clearField', (fields) => {
      this.$set(this.info, 'checked', false);
      this.checked = this.info.checked;
    });
    VueBus.$on('clearLabel', (items) => {
      if (items.includes(this.info.value)) {
        this.$set(this.info, 'checked', false);
        this.checked = this.info.checked;
      }
    });
  },
  props: ['info', 'className'],
});
