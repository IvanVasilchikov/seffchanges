import cAnimationFade from '../animation/fade/animation-fade';
import cCheckbox from '../checkbox/checkbox';
import VueBus from '../../../base/scripts/vue/v-bus';
require('./select.scss');

const template = require('./select.pug');

export default template({
  components: {
    cAnimationFade,
    cCheckbox,
  },
  data() {
    return {
      isOpen: false,
      selected: {
        text: "",
        value: "",
        name: "",
      }
    }
  },
  watch: {
    info: {
      handler() {
        if (this.info.multiple) {
          this.changeMultiple({ disabled: false });
        } else {
          const newData = this.info.values.find((el) => el.selected);
          this.selected.text = newData.text;
          this.selected.value = newData.value;
        }
      }
    }
  },
  computed: {
    selectValue() {
      if (this.info.multiple) {
        return this.info.values.filter((el) => el.selected);
      }
      return this.info.values.find((el) => el.selected);
    }
  },
  methods: {
    computedClass(item) {
      if (this.info.multiple) {
        const selected = this.selected.value.includes(item.value);
        if (selected) this.$set(item, 'checked', true);
        return selected;
      }
      return item.value === this.selected.value;
    },
    change(e) {
      if (!e.disabled) {
        this.selected.value = e.value;
        this.selected.text = e.text;
        this.$emit('input', this.selected.value, this.selected.name);
      }
    },
    changeMultiple(e, data) {
      if (!e.disabled) {
        let checked = null;
        if (data) {
          checked = data;
        } else {
          checked = this.info.values.filter(el => el.checked && !el.disabled);
        }
        const elAllVal = checked.find(el => el.value === 'all');
        if (e.value === 'all') {
          this.info.values.forEach((el) => {
            if (!el.disabled) {
              this.$set(el, 'checked', e.checked);
              this.$set(el, 'selected', e.checked);
            }
          });
        }
        if (elAllVal && e.value !== 'all') {
          this.$set(elAllVal, 'checked', false);
          this.$set(elAllVal, 'selected', false);
        } else if (!elAllVal && e.value !== 'all') {
          const checkedVals = this.info.values.filter(el => el.checked && !el.disabled);
          if (checkedVals.length + 1 === (this.info.values.length - 1)) {
            const allVal = this.info.values.find(el => el.value === 'all');
            if (allVal) {
              this.$set(allVal, 'checked', true);
              this.$set(allVal, 'selected', true);
            }
          }
        }
        checked = this.info.values.filter(el => el.checked && !el.disabled);
        if (checked.length === 0) {
          if (this.info.values.find(el => el.disabled)) {
            checked = this.info.values.filter(el => el.disabled);
          } else checked = [this.info.values[0]];
        }
        this.selected.value = checked.map(el => el.value);
        this.updateTitle(checked);
        this.$emit('input', this.selected.value, this.selected.name);
      }
    },
    updateTitle(checked) {
      const text = () => {
        const all = this.info.values.find(el => el.value === 'all');
        if ((all && all.checked) || checked.length + 1 === (this.info.values.length - 1)) {
          return all.text;
        }
        return checked.filter(el => el.value !== 'all').map(el => el.text).join(', ');
      };
      this.selected.text = text();
    },
  },
  mounted() {
    VueBus.$on('clearField', (fields = []) => {
      if (fields.indexOf(this.$props.info.name) !== -1) {
        if (this.info.multiple) {
          this.changeMultiple({ disabled: false });
        } else this.change(this.$props.info.values[0]);
      }
    });
    VueBus.$on('updateField', (fields = [], data = [], el) => {
      if (fields.indexOf(this.$props.info.name) !== -1) {
        if (this.info.multiple) {
          this.changeMultiple(el, data);
        } else this.change(this.$props.info.values[0]);
      }
    });

    if (this.selectValue) {
      if (this.info.multiple) {
        this.changeMultiple({ disabled: false });
      } else {
        this.selected.text = this.selectValue.text;
        this.selected.value = this.selectValue.value;
      }
    }

    this.selected.name = this.info.name;

    const head = this.$el.querySelector('.select__head');
    this.dropdown = this.$refs.dropdown;

    document.addEventListener('click', (e) => {
      const {
        target
      } = e;
      if (target === head || head.contains(target)) {
        this.isOpen = !this.isOpen;
      } else {
        if (this.info.multiple) {
          this.isOpen = !(!this.$el.contains(target) || (target === head || head.contains(target)));
        } else {
          this.isOpen = !(target !== this.dropdown || !this.dropdown.contains(target));
        }
      }
    });
  },
  props: ['info', 'className', 'animationTime', 'title'],
});
