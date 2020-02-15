import cBtn from '../../core/btn/btn';
import popupEvent from '../../../base/scripts/popupEvent';
import ScrollTo from '../../../base/scripts/scrollTo';
require('./detail-nav.scss');

const template = require('./detail-nav.pug');

export default template({
  components: {
    cBtn,
  },
  data() {
    return {
      fixHeader: false,
      activeAnchor: '#main',
      price: '',
    }
  },
  methods: {
    openPopup() {
      popupEvent.open('form', 'writeUs');
    },
    scrollTo(anchor) {
      ScrollTo({
        anchor,
        offset: this.$el.offsetHeight,
      });
    },
  },
  created() {
    this.price = this.nav.price;
  },
  props: ['nav', 'className', 'offersAnchor'],
});
