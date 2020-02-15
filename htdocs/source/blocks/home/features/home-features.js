import Swiper from 'swiper/dist/js/swiper.min';
import cTitle from './../../fonts/title/title';
import cTitleFifth from './../../fonts/title/fifth/title-fifth';
import cText from './../../fonts/text/text';
import popupEvent from '../../../base/scripts/popupEvent';
require('./home-features.scss');

const template = require('./home-features.pug');

export default template({
  components: {
    cTitle,
    cTitleFifth,
    cText
  },
  methods: {
    initSlider() {
      const slider = this.$el.querySelector('.home-features__slider');
      const arrowPrev = this.$el.querySelector('.home-features__arrow--prev');
      const arrowNext = this.$el.querySelector('.home-features__arrow--next');

      new Swiper(slider, {
        slidesPerView: 3,
        spaceBetween: 20,
        loop: false,
        speed: 700,
        navigation: {
          prevEl: arrowPrev,
          nextEl: arrowNext,
        },
        breakpoints: {
          1023: {
            slidesPerView: 2,
          },
          767: {
            slidesPerView: 1,
          },
        },
      });
    },
    popupOpen(type, name) {
      popupEvent.open(type, name);
    }
  },
  mounted() {
    this.initSlider();
  },
  props: ['obj'],
});
