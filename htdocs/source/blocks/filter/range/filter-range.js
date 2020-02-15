import vStore from '../../../base/scripts/vue/v-store';
import cSelect from '../../core/select/select';
import VueBus from '../../../base/scripts/vue/v-bus';
import Imask from 'imask';
require('./filter-range.scss');

const template = require('./filter-range.pug');

export default template({
  components: {
    cSelect,
  },
  data() {
    return {
      showDropdown: false,
      formData: {},
      range: null,
      dropdown: null,
    }
  },
  watch: {
    formData: {
      handler() {
        this.$emit('change', this.formData);
      },
      deep: true,
    }
  },
  computed: {
    title() {
      if (this.dropdown && this.dropdown.title) {
        return this.dropdown.title;
      }
      return this.info.inputs.title;
    }
  },
  methods: {
    formatPrice(event, el) {
      const input = event.target;
      let cursor = this.getCursorPosition(input);
      const code = event.keyCode;
      let startValue = this.formData[`${el.name}`];
      const inputValue = this.formData[`${el.name}`];
      if ((event.ctrlKey === true && code === 86) ||
        (event.metaKey === true && code === 86) ||
        (event.shiftKey === true && code === 45)) {
        return false;
      } else if (code === 9 || code === 27 ||
        event.ctrlKey === true ||
        event.metaKey === true ||
        event.altKey === true ||
        event.shiftKey === true ||
        (code >= 112 && code <= 123) ||
        (code >= 35 && code <= 39)) {
        return false;
      } else if (code === 8) {
        const delCount = this.delSelected(event, el);
        if (!delCount) {
          if (startValue[cursor - 1] === ' ') {
            cursor--;
          }
          this.$set(this.formData, el.name, startValue.substr(0, cursor - 1) + startValue.substring(cursor, startValue.length));
        }
        this.$set(this.formData, el.name, this.priceFormatted(inputValue));
        this.setCursorPosition(cursor - (startValue.length - input.value.length - delCount), input);
      } else if (code === 46) {
        let delCount = this.delSelected(event, el);
        if (!delCount) {
          if (startValue[cursor] === ' ') {
            cursor++;
          }
          this.$set(this.formData, el.name, startValue.substr(0, cursor - 1) + startValue.substring(cursor, startValue.length));
        }
        if (!delCount)delCount = 1;
        this.$set(this.formData, el.name, this.priceFormatted(input.value));
        this.setCursorPosition(cursor - (startValue.length - input.value.length - delCount), input);

      } else {
        this.delSelected(event, el);
        startValue = input.value;
        let key = false;
        if ((code >= 48 && code <= 57)) {
          key = (code - 48);
        }
        else if ((code >= 96 && code <= 105 )) {
          key = (code - 96);
        } else {
          this.$set(this.formData, el.name, this.priceFormatted(input.value));
          this.setCursorPosition(cursor, input);
          return false;
        }
        const length = startValue.length;
        const value = startValue.substr(0, cursor) + key + startValue.substring(cursor, length);
        this.$set(this.formData, el.name, this.priceFormatted(input.value));
        this.setCursorPosition(cursor + value.length - length, input);
      }
    },
    getCursorPosition(input) {
      if ('selectionStart' in input) {
        return input.selectionStart;
      } else if (document.selection) {
        input.focus();
        const sel = document.selection.createRange();
        const selLen = document.selection.createRange().text.length;
        sel.moveStart('character', -input.value.length);
        return sel.text.length - selLen;
      }
    },
    setCursorPosition(pos, input) {
      if (input.setSelectionRange) {
        input.setSelectionRange(pos, pos);
      } else if (input.createTextRange) {
        const range = input.createTextRange();
        range.collapse(true);
        range.moveEnd('character', pos);
        range.moveStart('character', pos);
        range.select();
      }
    },
    delSelected(event, el) {
      const input = event.target;
      const value = this.formData[`${el.name}`];
      const start = input.selectionStart;
      const end = input.selectionEnd;
      this.$set(this.formData, el.name, value.substr(0, start) + value.substring(end, value.length));
      return end - start;
    },
    priceFormatted(element) {
      element = String(element).replace(/[^\d]/g, '');
      if(!element) return '';
      return (String(parseInt(element))).replace(/(\d)(?=(\d\d\d)+([^\d]|$))/g, '$1 ');
    },
    computedClass(item, type) {
      const name = this.info.inputs[`${type}`].name;
      return item.value === this.formData[`${name}`];
    },
    change(e, type) {
      this.$set(this.formData, this.info.inputs[`${type}`].name, this.priceFormatted(e.value));
      if (type === 'max') {
        this.showDropdown = false;
      }
    },
    resetData() {
      for (let key in this.info) {
        if (this.info.hasOwnProperty(key)) {
          if (key === 'inputs') {
            const inputs = this.info[key];
            for (let k in inputs) {
              if (inputs.hasOwnProperty(k) && inputs[k].hasOwnProperty('name')) {
                this.$set(this.formData, inputs[k].name, '');
              }
            }
          }
        }
      }
    },
    updateRange() {
      if (this.info.range) {
        if (this.info.range.additional) {
          const dealType = this.formData.deal_type || this.info.inputs.dropdown.dealType;
          const values = this.info.range.additional[`${dealType}`];
          this.$set(this.formData, 'range', values.find(el => el.selected).value);
          this.range = {...this.info.range, ...{
              values
            }};
        } else {
          this.range = this.info.range;
        }
      }
    },
    updateDropdown(type) {
      if (this.info.inputs && this.info.inputs.dropdown && this.info.inputs.dropdown.dealType) {
        if (type) this.$set(this.info.inputs.dropdown, 'dealType', type);
        let deal = this.formData.deal_type || this.info.inputs.dropdown.dealType;
        if (this.info.inputs.dropdown.rangeDependency && this.formData.range) deal += `_${this.formData.range}`;
        this.dropdown = this.info.inputs.dropdown[`${deal}`][`${this.formData.currency}`];
      } else this.dropdown = null;
    }
  },
  created() {
    for (let key in this.info) {
      if (this.info.hasOwnProperty(key)) {
        if (key === 'inputs') {
          const inputs = this.info[key];
          for (let k in inputs) {
            if (inputs.hasOwnProperty(k) && inputs[k].hasOwnProperty('name')) {
              if (vStore.state.mapFilter[inputs[k].name]) {
                this.$set(this.formData, inputs[k].name, vStore.state.mapFilter[inputs[k].name]);
              } else {
                this.$set(this.formData, inputs[k].name, inputs[k].value);
              }
            }
          }
        } else if (this.info[key].hasOwnProperty('values')) {
          if (vStore.state.mapFilter[this.info[key].name]) {
            this.$set(this.formData, this.info[key].name, vStore.state.mapFilter[this.info[key].name]);
            this.info[key].values.forEach((item) => {
              item.selected = item.value === vStore.state.mapFilter[this.info[key].name];
            });
          } else {
            this.$set(this.formData, this.info[key].name, this.info[key].values.find(el => el.selected).value);
          }
        }
      }
    }
  },
  mounted() {
    VueBus.$on('clearField', (fields) => {
      this.resetData();
    });
    VueBus.$on('dealChange', (type, name, parent) => {
      if (this.parentName && this.parentName === parent) {
        if (this.info.inputs.dropdown) {
          this.$set(this.formData, name, type);
          this.updateRange();
          this.updateDropdown(type);
        }
      }
    });

    if (this.info.inputs && this.info.inputs.dropdown) {
      this.updateRange();
      this.updateDropdown();
      const head = this.$refs.head;

      if (head) {
        document.addEventListener('click', (e) => {
          const {
            target
          } = e;
          const dropdown = this.$refs.drop;
          if (target === head || head.contains(target)) {
            this.showDropdown = true;
          } else if (target !== head || !dropdown.contains(target)) {
            this.showDropdown = false;
          }
        });
      }
    }
    if (!this.info.currency) {
      const inputs = Array.from(this.$el.querySelectorAll('.filter-range__inputs-wrp input'));
      inputs.forEach((input) => {
        new Imask(input, {
          numericInput: true,
          // pattern: /[^ 0-9]$/gi,
          mask: '000000000'
        });
      });
    }
  },
  props: ['info', 'className', 'name', 'parentName'],
});
