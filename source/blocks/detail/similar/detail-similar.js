import Axios from 'axios';
import cTitle from '../../fonts/title/title';
import cCardSmall from '../../card/small/card-small';
import cTabs from '../../tabs/tabs';
import cLabel from '../../core/label/label';
require('./detail-similar.scss');

const template = require('./detail-similar.pug');

export default template({
  components: {
    cTitle,
    cTabs,
    cCardSmall,
    cLabel,
  },
  data() {
    return {
      activeTab: this.info.tabs[0].value,
      filter: {
        tab: this.info.tabs[0].value,
      },
    }
  },
  methods: {
    updateLabels() {
      this.$set(this.filter, 'label', this.info.tags.filter(item => item.checked).map(item => item.value));
      this.loadCards();
    },
    setTab(value) {
      // this.info.tags.forEach(item => item.checked = false);
      this.loadCards(value);
    },
    loadCards(url) {
      if (url) {
        Axios.get(url).then((response) => {
          this.info.cards = response.data.cards;
        });
      }
    }
  },
  props: ['info'],
});
