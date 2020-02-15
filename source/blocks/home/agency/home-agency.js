import Swiper from 'swiper/dist/js/swiper.min';

import cPicture from './../../core/picture/picture';
import cTitleFifth from './../../fonts/title/fifth/title-fifth';
import cText from './../../fonts/text/text';
require('./home-agency.scss');

const template = require('./home-agency.pug');

export default template({
  components: {
    cPicture,
    cTitleFifth,
    cText
  },
  methods: {
    initSlider() {
      const mainSlider = this.sliderWrap.querySelector('.home-agency__slider');
      const slider = this.sliderWrap.querySelector('.home-agency__slider-description');
      const pag = this.sliderWrap.querySelector('.home-agency__pag');
      const arrowPrev = this.sliderWrap.querySelector('.home-agency__arrow--prev');
      const arrowNext = this.sliderWrap.querySelector('.home-agency__arrow--next');

      const apiMainSlider = new Swiper(mainSlider, {
        slidesPerView: 1,
        loopAdditionalSlides: 10,
        loop: true,
        speed: 700,
        allowTouchMove: false,
        navigation: {
          prevEl: arrowPrev,
          nextEl: arrowNext,
        },
        pagination: {
          el: pag,
          type: 'fraction',
        },
      });

      const apiSlider = new Swiper(slider, {
        slidesPerView: 1,
        loopAdditionalSlides: 10,
        loop: true,
        speed: 700,
        allowTouchMove: false,
      });

      apiMainSlider.on('slideChange', () => {
        if (apiMainSlider.realIndex !== apiSlider.realIndex) {
          apiSlider.slideTo(apiMainSlider.realIndex, 0, false);
        }
      });
    }
  },
  mounted() {
    this.sliderWrap = this.$el.querySelector('.home-agency__slider-wrap');

    if (this.sliderWrap) this.initSlider();
  },
  props: ['obj'],
});
