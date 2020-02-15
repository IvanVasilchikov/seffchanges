import util from '../../../base/scripts/util';
import cTitleSecond from './../../fonts/title/second/title-second';
import cText from './../../fonts/text/text';
import cPicture from './../../core/picture/picture';
import api from '../../../base/scripts/api';
require('./home-how.scss');

const template = require('./home-how.pug');

export default template({
  components: {
    cPicture,
    cTitleSecond,
    cText
  },
  data() {
    return {
      formData: {},
    }
  },
  methods: {
    changeQuestion(i) {
      if ((i + 1) >= this.obj.tabs.length) {
        this.submitForm();
      } else {
        this.obj.active = i + 1;
      }
    },
    submitForm() {
      api.post(this.obj.url, this.formData).then(() => {
        if (this.obj.success) this.obj.success.show = true;
      });
    }
  },
  props: ['obj'],
});
