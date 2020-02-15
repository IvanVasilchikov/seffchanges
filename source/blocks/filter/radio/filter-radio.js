import VueBus from '../../../base/scripts/vue/v-bus';

require('./filter-radio.scss');

const template = require('./filter-radio.pug');

export default template({
  data() {
    return {
      checked: '',
    }
  },
  watch: {
    checked() {
      if (this.name === 'deal_type') VueBus.$emit('dealChange', this.checked, this.name, this.parentName);
    },
  },
  created() {
    this.checked = this.buttons.find((el) => el.checked).value;
  },
  mounted() {
    this.name = this.$props.name;

    VueBus.$on('clearField', (fields) => {
      if (fields.indexOf(this.name) !== -1) {
        this.$set(this, 'checked', this.buttons[0].value);
        this.$emit('change', this.checked, this.name);
      }
    });
  },
  props: ['buttons', 'name', 'className', 'parentName'],
});
