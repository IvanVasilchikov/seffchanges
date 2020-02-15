import cAnimationFade from '../animation/fade/animation-fade';
import api from '../../../../source/base/scripts/api';
import VueBus from '../../../base/scripts/vue/v-bus';

require('./hint.scss');

const template = require('./hint.pug');

export default template({
  components: {
    cAnimationFade,
  },
  data() {
    return {
      isOpen: false,
      hints: [],
      value: ''
    }
  },
  created() {
    this.value = this.obj.input.value;
    VueBus.$on('clearField', (fields) => {
      if (fields.indexOf(this.obj.name) !== -1) {
        this.value = '';
        this.confirmValue();
      }
    });
  },
  methods: {
    checkVal() {
      if (this.value.length > 2) {
        const iVal = this.value.toLowerCase();
        const iHints = [];
        if (this.$props.obj.hints) {
          this.$props.obj.hints.forEach((item) => {
            const obj = {};
            obj.head = item.head;

            obj.items = item.items.map(str => {
              const iStr = str.toLowerCase();
              const index = iStr.indexOf(iVal);

              if (index !== -1) {
                const s0 = str.substring(0, index);
                const s1 = str.substring(index, index + iVal.length);
                const s2 = str.substring(index + iVal.length);
                return `${s0}<span>${s1}</span>${s2}`;
              } else {
                return null;
              }
            }).filter(item => item !== null);

            if (obj.items.length !== 0) iHints.push(obj);
          });
        }

        this.hints = iHints;
        iHints.length !== 0 ? this.isOpen = true : this.isOpen = false;
      } else {
        this.isOpen = false;
      }
    },
    change(e) {
      const rex = /(<([^>]+)>)/ig;
      this.value = e.replace(rex, '');
      this.isOpen = false;
      this.confirmValue();
    },
    closeDropDown() {
      this.isOpen = false;
      this.value = '';
      this.confirmValue();
    },
    confirmValue() {
      this.$emit('passHint', this.value, this.obj.name);
    },
    getTips() {
      api.get(window.setting.hints, {
        value: this.value,
        departament: this.obj.departament_id
      }).then((responce) => {
        this.hints = responce.data;
        this.isOpen = true;
      });
    }
  },
  props: ['obj', 'className', 'animationTime'],
});
