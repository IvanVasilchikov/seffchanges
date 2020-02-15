import cPicture from '../../core/picture/picture';
import cTitleSecond from '../../fonts/title/second/title-second';
import cInput from '../../core/input/input';
import cTextarea from '../../core/textarea/textarea';
import cSelect from '../../core/select/select'
import cBtn from '../../core/btn/btn';
import cCheckbox from '../../core/checkbox/checkbox';
import api from '../../../base/scripts/api';
import popupEvent from '../../../base/scripts/popupEvent';
require('./popup-form.scss');

const template = require('./popup-form.pug');

export default template({
  name: 'popupForm',
  data() {
    return {
      formModel: {},
    };
  },
  props: ['info'],
  components: {
    cPicture,
    cTitleSecond,
    cInput,
    cTextarea,
    cSelect,
    cBtn,
    cCheckbox,
  },
  methods: {
    onSubmit() {
      if (!this.checkValid().length && this.info.checkbox.checked) {
        const formData = this.info.hidden ? Object.assign({}, this.formModel, this.info.hidden,
          { page: window.location.pathname }) : Object.assign({}, this.formModel);
        api.post(this.info.action, formData).then((res) => {
          if (res.status !== 200) {
            popupEvent.open('response', 'error', { html: `<p>${res.status}</p>` });
          } else if (res.data.status !== 'success') {
            popupEvent.open('response', 'error', { html: `<p>${res.data.status}</p>` });
          } else {
            popupEvent.open('response', 'success');
          }
          if (this.info.checkbox && this.info.checkbox.checked) this.$set(this.info.checkbox, 'checked', false);
          if (this.info.inputs && this.info.inputs.length !== 0) {
            this.info.inputs.forEach((input) => {
              if (input.type !== 'select') {
                this.$set(input.checked, 'value', 'waiting');
                this.$set(input, 'value', '');
              }
            });
          }
        }).catch((error) => {
          popupEvent.open('response', 'error', { html: `<p>${error}</p>` });
        });
      }
    },
    checkValid() {
      const errors = [];
      this.info.inputs.forEach((input) => {
        if(input.checked && !(input.checked.value === 'success' || (!input.checked.required && !input.value.length))) {
          input.checked.value = 'fail';
          errors.push(input.name);
        }
      });
      return errors;
    }
  },
});
