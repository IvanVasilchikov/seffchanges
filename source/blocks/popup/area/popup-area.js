import cTitleFourth from '../../fonts/title/fourth/title-fourth.js';
import popupAreaDistrict from './district/popup-area-district';
import popupAreaMetro from './metro/popup-area-metro';
import popupCountryCity from './countryCity/popup-area-countryCity';
require('./popup-area.scss');

const template = require('./popup-area.pug');

export default template({
  name: 'popupArea',
  data() {
    return {
      sendData: {},
      districtTab: this.info.popup,
    };
  },
  computed: {
    tabs() {
      return this.info.tabs;
    }
  },
  components: {
    cTitleFourth,
    popupAreaDistrict,
    popupAreaMetro,
    popupCountryCity,
  },
  props: ['info'],
});
