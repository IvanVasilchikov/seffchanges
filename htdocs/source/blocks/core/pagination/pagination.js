require('./pagination.scss');

const template = require('./pagination.pug');
const util = require('../../../../util');

export default template({
  data() {
    return {
      util,
    };
  },
  methods: {
    changePage(page) {
      if (page === 'prev') {
        if (this.info.current >= 2) this.info.current = this.info.current -= 1;
      } else if (page === 'next') {
        if (this.info.current < this.info.count) this.info.current = this.info.current += 1;
      } else this.info.current = page;

      this.$emit('setPage', this.info.current);
    },
  },
  props: ['info', 'className'],
});
