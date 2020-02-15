import Imask from 'imask';
import cTitleSecond from '../../fonts/title/second/title-second';
import cBtn from '../../core/btn/btn';
import cCheckbox from '../../core/checkbox/checkbox';
import cInput from '../../core/input/input';
import cPicture from '../../core/picture/picture'
import api from '../../../base/scripts/api';
import popupEvent from '../../../base/scripts/popupEvent';
require('./banner-detail.scss');

const template = require('./banner-detail.pug');

export default template({
  components: {
    cTitleSecond,
    cBtn,
    cCheckbox,
    cInput,
    cPicture
  },
  data() {
    return {
      timePattern: /^(0[0-9]|1[0-9]|2[0-3]):[0-5][0-9]$/ig,
      formModel: {}
    }
  },
  methods: {
    onSubmit() {
      if (!this.checkValid().length && this.info.form.checkbox.checked) {
        const formData = this.info.form.hidden ? Object.assign({}, this.formModel, this.info.form.hidden) : Object.assign({}, this.formModel);
        api.post(this.info.form.url, formData).then((res) => {
          if (res.status !== 200) {
            popupEvent.open('response', 'error', { html: `<p>${res.status}</p>` });
          } else if (res.data.status !== 'success') {
            popupEvent.open('response', 'error', { html: `<p>${res.data.status}</p>` });
          } else {
            popupEvent.open('response', 'success');
          }
        }).catch((error) => {
          popupEvent.open('response', 'error', { html: `<p>${error}</p>` });
        });
      }
    },
    checkValid() {
      const errors = [];
      this.info.form.inputs.forEach((input) => {
        if (input.checked && !(input.checked.value === 'success' || (!input.checked.required && !input.value.length))) {
          input.checked.value = 'fail';
          errors.push(input.name);
        }
      });
      return errors;
    },
  },
  mounted() {
    if (this.info.form.timeInputs) {
      this.info.form.timeInputs.forEach((input) => {
        const mask = new Imask(this.$refs[`timeInput${input.name}`], {
          alias: 'datetime',
          mask: '00:00',
          regex: this.timePattern,
          numericInput: true,
        });

        mask.on('complete', () => {
          input.timeMask.complete = true;
          input.value = mask.value;
        });
        mask.on('accept', () => {
          input.timeMask.complete = false;
          input.value = mask.value;
        });
      });
    }
  },
  props: ['info', 'className'],
});
