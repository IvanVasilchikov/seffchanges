import cTitleSecond from '../../fonts/title/second/title-second';
import cBtn from '../../core/btn/btn';
import cCheckbox from '../../core/checkbox/checkbox';
import cInput from '../../core/input/input';
import cPicture from '../../core/picture/picture'
import popupEvent from '../../../base/scripts/popupEvent';
import api from '../../../base/scripts/api';
import VueBus from '../../../base/scripts/vue/v-bus';
require('./banner-request.scss');

const template = require('./banner-request.pug');

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
      formModel: {}
    }
  },
  methods: {
    onSubmit() {
      // console.log(this);
      if (!this.checkValid().length && this.info.form.checkbox.checked) {
        const formData = this.info.form.hidden ? Object.assign({}, this.formModel, this.info.form.hidden) : Object.assign({}, this.formModel);
        api.post(this.info.form.url, formData).then((res) => {
          if (res.status !== 200) {
            popupEvent.open('response', 'error', {
              html: `<p>${res.status}</p>`
            });
          } else if (res.data.status !== 'success') {
            popupEvent.open('response', 'error', {
              html: `<p>${res.data.status}</p>`
            });
          } else {
            popupEvent.open('response', 'success');
          }
        }).catch((error) => {
          popupEvent.open('response', 'error', {
            html: `<p>${error}</p>`
          });
        });
        VueBus.$emit('bannerRequestSubmit');
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
  props: ['info', 'className', 'imgModif'],
});
