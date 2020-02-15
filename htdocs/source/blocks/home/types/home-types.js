import cTitleFourth from './../../fonts/title/fourth/title-fourth';
import cText from './../../fonts/text/text';
import popupEvent from '../../../base/scripts/popupEvent';
require('./home-types.scss');

const template = require('./home-types.pug');

export default template({
  components: {
    cTitleFourth,
    cText
  },
  methods: {
    popupOpen(type, name) {
      popupEvent.open(type, name);
    },
  },
  props: ['obj'],
});
