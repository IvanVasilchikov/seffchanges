import Swiper from 'swiper/dist/js/swiper.min';

import cTitle from './../../fonts/title/title';
import cTitleFourth from './../../fonts/title/fourth/title-fourth';
import cText from './../../fonts/text/text';
import cServicesItem from '../../services/item/services-item';
import cTabs from '../../tabs/tabs';
import cBtn from './../../core/btn/btn';
require('./home-services.scss');

const template = require('./home-services.pug');

export default template({
  components: {
    cTitle,
    cTitleFourth,
    cText,
    cServicesItem,
    cTabs,
    cBtn
  },
  data() {
    return {
      activeTab: this.obj.tabs[0].value,
      isBeginning: true,
      isEnd: true,
    }
  },
  methods: {
    changeTab(value) {
      this.activeTab = value;
      this.$nextTick(() => {
        this.initSlider();
      });
    },
    initSlider() {
      const slider = this.$el.querySelector('.home-services__slider');
      const self = this;
      this.slider = new Swiper(slider, {
        slidesPerView: 3,
        spaceBetween: 16,
        loop: false,
        speed: 700,
        breakpoints: {
          1279: {
            slidesPerView: 3,
          },
          1023: {
            slidesPerView: 2,
          },
          767: {
            slidesPerView: 1,
            spaceBetween: 14,
          },
        },
        on: {
          slideChange() {
            self.checkArrows();
          },
        },
      });

      this.checkArrows();
    },
    checkArrows() {
      this.isBeginning = this.slider.isBeginning;
      this.isEnd = this.slider.isEnd;
    }
  },
  mounted() {
    this.initSlider();
  },
  props: ['obj'],
});
