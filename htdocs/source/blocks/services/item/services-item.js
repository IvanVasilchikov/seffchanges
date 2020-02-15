import cTitleFourth from '../../fonts/title/fourth/title-fourth';
import cText from '../../fonts/text/text';
import popupEvent from '../../../base/scripts/popupEvent';
require('./services-item.scss');

const template = require('./services-item.pug');

export default template({
  components: {
    cTitleFourth,
    cText,
  },
  props: ['info', 'className', 'isLazy'],
  methods: {
    openPopup() {
      const popupInfo = {
        name: this.info.popup.name,
        ico: this.info.popup.ico,
        title: this.info.title,
        html: this.info.popup.html,
        btnPhrase: this.info.popup.btnPhrase,
      };
      popupEvent.openAsync('content', popupInfo);
    },
  }
});
