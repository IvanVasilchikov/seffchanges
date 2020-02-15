import cTitleFourth from '../../fonts/title/fourth/title-fourth';
import cWysiwyg from '../../wysiwyg/wysiwyg';
import cBtn from '../../core/btn/btn';
import popupEvent from '../../../base/scripts/popupEvent';
import './popup-content.scss'

const template = require('./popup-content.pug')

export default template({
  name: 'popupContent',
  props: ['info', 'className'],
  components: {
    cTitleFourth,
    cWysiwyg,
    cBtn,
  },
  methods: {
    popupOpen(type, name) {
      setTimeout(() => {
        popupEvent.open(type, name);
      }, 1);
    }
  }
});