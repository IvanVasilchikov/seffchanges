import cTitle from '../../fonts/title/title';
import cTabs from '../../tabs/tabs';
import cServicesItem from '../../services/item/services-item';
require('./about-services.scss');

const template = require('./about-services.pug');

export default template({
  components: {
    cTitle,
    cTabs,
    cServicesItem,
  },
  data() {
    return {
      activeTab: this.info.buttons[0].value,
    }
  },
  methods: {
    changeTab(value) {
      this.activeTab = value;
    }
  },
  props: ['info'],
});
