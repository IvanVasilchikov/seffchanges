import inputCheck from '../../../base/scripts/inputCheck';
require('./textarea.scss');

const template = require('./textarea.pug');

export default template({
  data() {
    return {
      status: 'waiting',
      changed: false,
    };
  },
  props: ['info', 'className'],
  watch: {
    'info.value'(value) {
      if (this.status !== 'input') this.change(value);
    },
    'info.checked':{
      handler() {
        this.status = 'change';
        this.changed = true;
      },
      deep: true,
    },
  },
  methods: {
    input(value) {
      this.info.value = value;
      this.status = 'input';
      if (this.changed) this.check();
      this.$emit('input', value);
    },
    change(value) {
      this.info.value = value;
      this.status = 'change';
      this.changed = true;
      this.check();
      this.$emit('change', value);
    },
    check() {
      const { checked, value } = this.info;
      if (checked) {
        const errors = [];
        if (checked.required && !inputCheck.required(value)) errors.push(`Поле ${this.info.name} обязательное`);
        if (checked.lengthString) {
          const result = inputCheck.lengthString(value, checked.lengthString.min, checked.lengthString.max);
          if (!result[0]) errors.push(`В поле ${this.info.name} должно быть не менее ${checked.lengthString.min} символов`);
          if (!result[1]) errors.push(`В поле ${this.info.name} должно быть не более ${checked.lengthString.max} символов`);
        }
        checked.value = errors.length ? 'fail' : 'success';
      }
    },
  },
  created() {
    if (this.info.checked && !this.info.checked.value) this.$set(this.info.checked, 'value', 'waiting');
  },
});
