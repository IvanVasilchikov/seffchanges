import IMask from 'imask';
import inputCheck from '../../../base/scripts/inputCheck';
require('./input.scss');

const template = require('./input.pug');

export default template({
  props: ['obj', 'className'],
  data() {
    return {
      status: 'waiting',
      changed: false,
      pattern: /[^ 0-9a-zA-Z\u0400-\u04FF]$/gi,
      maskOption: {
        mask: '+{7}(000) 000-00-00',
      },
    }
  },
  watch: {
    'obj.value'(value) {
      if (this.status !== 'input') this.change(value);
    },
    'obj.checked':{
      handler() {
        this.status = 'change';
        this.changed = true;
      },
      deep: true,
    },
  },
  methods: {
    inputDefault(value) {
      if (!this.mask) {
        this.input(value);
      }
    },
    inputMask(value, complete) {
      this.obj.maskInfo.complete = complete;
      this.input(value);
    },
    input(value) {
      this.obj.value = value;
      if (this.pattern && value) this.$set(this.obj, 'value', value.replace(this.pattern, ''));
      this.status = 'input';
      if (this.changed) this.check();
      this.$emit('input', value);
    },
    change(value) {
      this.status = 'change';
      this.changed = true;
      this.check();
      if (this.pattern && value) this.$set(this.obj, 'value', value.replace(this.pattern, ''));
      this.$emit('change', value);
    },
    check() {
      const { checked, value } = this.obj;
      if (checked) {
        const errors = [];
        if (checked.required && !inputCheck.required(value)) errors.push(`Поле ${this.obj.name} обязательное`);
        if (checked.lengthString) {
          const result = inputCheck.lengthString(value, checked.lengthString.min, checked.lengthString.max);
          if (!result[0]) errors.push(`В поле ${this.obj.name} должно быть не менее ${checked.lengthString.min} символов`);
          if (!result[1]) errors.push(`В поле ${this.obj.name} должно быть не более ${checked.lengthString.max} символов`);
        }
        if (value.length && checked.email) {
          if (!inputCheck.email(value)) errors.push(`В поле ${this.obj.name} должен быть указан адрес электронной почты`);
        }
        checked.value = errors.length ? 'fail' : 'success';
      }
    },
  },
  created() {
    if (this.obj.checked && !this.obj.checked.value) this.$set(this.obj.checked, 'value', 'waiting');
    if (this.obj.maskInfo && !this.obj.maskInfo.complete) this.$set(this.obj.maskInfo, 'complete', false);
  },
  mounted() {
    this.$emit('input', this.obj.value);
    if (this.obj.checked && this.obj.checked.email) this.pattern = '';
    if (this.obj.name === 'name') this.pattern = /[^ a-zA-Z\u0400-\u04FF]$/gi;
    if (this.obj.maskInfo) {
      this.pattern = '';
      this.mask = new IMask(this.$refs.input, this.obj.maskInfo.options || this.maskOption);
      this.mask.on('complete', () => {
        this.inputMask(this.mask.value, true);
      });
      this.mask.on('accept', () => {
        this.inputMask(this.mask.value, false);
      });
    }
  },
});
