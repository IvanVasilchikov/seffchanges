import Swiper from 'swiper/dist/js/swiper.min';
import vueBus from '../../../../base/scripts/vue/v-bus';
require('./popup-object-gallery.scss');

const template = require('./popup-object-gallery.pug');

export default template({
  methods: {
    initSlider() {
      const slider = this.$el;
      const slides = this.slides;

      if (slides.length > 1) {
        this.slider = new Swiper(slider, {
          slidesPerView: 1,
          preloadImages: false,
          spaceBetween: 10,
          loop: {
            loadPrevNext: true,
          },
          navigation: {
            prevEl: this.$el.querySelector('.popup-object-gallery__arrow--prev'),
            nextEl: this.$el.querySelector('.popup-object-gallery__arrow--next'),
          },
          pagination: {
            el: slider.querySelector('.popup-object-gallery__pag'),
            bulletClass: 'popup-object-gallery__pag-item',
            bulletActiveClass: 'popup-object-gallery__pag-item--active',
            type: 'bullets',
            clickable: true,
          },
        });
      }
    }
  },
  mounted() {
    this.initSlider();

    vueBus.$on('restart', () => {
      if (this.slider) this.slider.destroy();
      setTimeout(() => {
        this.initSlider();
      }, 100);
    });
  },
  props: ['slides', 'className', 'paginationClass'],
});
