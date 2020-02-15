import cTitleSecond from '../../fonts/title/second/title-second';
import cWysiwyg from '../../wysiwyg/wysiwyg';
import cBtn from '../../core/btn/btn';
import popupEvent from '../../../base/scripts/popupEvent';
import VueBus from '../../../base/scripts/vue/v-bus';
require('./popup-response.scss');

const template = require('./popup-response.pug')

export default template({
  name: 'popupResponse',
  props: ['info'],
  components: {
    cTitleSecond,
    cWysiwyg,
    cBtn
  },
  methods: {
    close() {
      const data = window.popup_object;

      if (data) {
        setTimeout(() => {
          popupEvent.openAsync('object', data, 'popup__content--object');
        }, 1);
      } else {
        VueBus.$emit('popupClose');
      }
    }
  }
});
