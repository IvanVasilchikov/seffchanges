import cInput from '../../core/input/input';
import cTextarea from '../../core/textarea/textarea';
import cBtn from '../../core/btn/btn';
import cCheckbox from '../../core/checkbox/checkbox';
import cForm from '../../form/form';
import api from '../../../base/scripts/api';
import popupEvent from '../../../base/scripts/popupEvent';
import './form-question.scss'

const template = require('./form-question.pug');

export default template({
  components: {
    cForm,
    cInput,
    cTextarea,
    cBtn,
    cCheckbox
  },
  data() {
    return {
      formData: {}
    }
  },
  methods: {
    onSubmit() {
      if (!this.checkValid().length && this.info.checkbox.checked) {
        const formData = this.info.hidden ? Object.assign({}, this.formData, this.info.hidden) : Object.assign({}, this.formData);
        api.post(this.info.action, formData).then((res) => {
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
      this.info.inputs.forEach((input) => {
        if (input.checked && !(input.checked.value === 'success' || (!input.checked.required && !input.value.length))) {
          input.checked.value = 'fail';
          errors.push(input.name);
        }
      });
      return errors;
    },
  },
  props: ['info', 'className'],
});
