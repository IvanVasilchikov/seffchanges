require('./tabs.scss');

const template = require('./tabs.pug');

export default template({
  data() {
    return {
      activeBtn: this.btns[0].value
    }
  },
  methods: {
    switchBtn(value) {
      this.activeBtn = value;
      this.$emit('changeTab', value);
    },
  },
  props: ['btns', 'className'],
});
