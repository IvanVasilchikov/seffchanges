import cTitleThird from '../../fonts/title/third/title-third';
import cBtn from '../../core/btn/btn';
import popupEvent from '../../../base/scripts/popupEvent';
require('./banner-send.scss');

const template = require('./banner-send.pug');

export default template({
  components: {
    cTitleThird,
    cBtn
  },
  methods: {
    popupOpen(type, name) {
      popupEvent.open(type, name);
    },
  },
  props: ['obj' ,'className'],
});
