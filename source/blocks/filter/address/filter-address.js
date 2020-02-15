import popupEvent from '../../../base/scripts/popupEvent';
import VueBus from '../../../base/scripts/vue/v-bus';
require('./filter-address.scss');

const template = require('./filter-address.pug');

export default template({
  props: ['info', 'className'],
  data() {
    return {
      address: '',
    }
  },
  watch: {
    address() {
      this.$emit('change', this.address, this.info.input.name);
    },
  },
  methods: {
    btnClick(target) {
      if (target.textContent.toLowerCase() === 'район') popupEvent.openAsync('area');
    }
  },
  created() {
    this.address = this.info.input.value;
  },
  mounted() {
    VueBus.$on('clearField', () => {
      this.$set(this, 'address', '');
    });
  },
});
