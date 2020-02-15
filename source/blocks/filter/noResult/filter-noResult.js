import VueBus from '../../../base/scripts/vue/v-bus';
require('./filter-noResult.scss');

const template = require('./filter-noResult.pug');

export default template({
  methods: {
    resetFilter() {
      VueBus.$emit('resetFilter');
    },
  },
  props: ['info', 'className', 'resetBtn'],
});
