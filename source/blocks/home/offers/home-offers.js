import cTitle from './../../fonts/title/title';
import cTitleThird from './../../fonts/title/third/title-third';
import cTitleFifth from './../../fonts/title/fifth/title-fifth';
import cText from './../../fonts/text/text';
import cTextLittle from './../../fonts/text/little/text-little';
import cCardSmall from './../../card/small/card-small';
import cTabs from '../../tabs/tabs';
require('./home-offers.scss');

const template = require('./home-offers.pug');

export default template({
  components: {
    cTitle,
    cTitleThird,
    cTitleFifth,
    cText,
    cTextLittle,
    cCardSmall,
    cTabs
  },
  data() {
    return {
      activeTab: this.obj.tabs[0].value,
    }
  },
  methods: {
    changeTab(value) {
      this.activeTab = value;
    }
  },
  props: ['obj'],
});
