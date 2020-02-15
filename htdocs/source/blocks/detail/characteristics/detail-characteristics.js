import cTitle from '../../fonts/title/title';
import cText from '../../fonts/text/text';
import cShare from '../../share/share';
require('./detail-characteristics.scss');
import popupEvent from '../../../base/scripts/popupEvent';

const template = require('./detail-characteristics.pug');

export default template({
  components: {
    cTitle,
    cText,
    cShare,
  },
  data() {
    return {
      showButton: true,
    }
  },
  methods: {
    toggleVisibility() {
      this.showButton = !this.$refs.share.showButtons;
    },
    popupOpen(type, name) {
      popupEvent.open(type, name);
    },
  },
  props: ['info', 'className'],
});
