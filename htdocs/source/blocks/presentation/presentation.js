import cTitleSecond from '../fonts/title/second/title-second';
import cBtn from '../core/btn/btn';
import cPicture from '../core/picture/picture';
import eventPopup from '../../base/scripts/popupEvent';
require('./presentation.scss');

const template = require('./presentation.pug');

export default template({
  components: {
    cTitleSecond,
    cBtn,
    cPicture
  },
  props: ['info', 'className'],
  methods: {
    popupOpen() {
      eventPopup.open('form', 'presentation');
    }
  }
});
