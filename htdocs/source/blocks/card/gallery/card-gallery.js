import Swiper from 'swiper/dist/js/swiper.min';
import vueBus from '../../../base/scripts/vue/v-bus';
require('./card-gallery.scss');
const template = require('./card-gallery.pug');

export default template({
  methods: {
    next() {
      this.slider.slideNext();
    },
    prev() {
      this.slider.slidePrev();
    }
  },
  mounted() {
    const slider = this.$el;
    const slides = this.$el.querySelectorAll('.card-gallery__slide');
    if (slides.length > 1) {
      this.slider = new Swiper(slider, {
        slidesPerView: 1,
        preloadImages: true,
        spaceBetween: 0,
        loop: {
          loadPrevNext: true,
        },
        simulateTouch: false,
        pagination: {
          el: slider.querySelector('.card-gallery__pagination'),
          bulletClass: 'card-gallery__pagination-el',
          bulletActiveClass: 'card-gallery__pagination-el--active',
          clickable: true,
          renderBullet(index, className) {
            return `<span class="${className}" style="width: calc(${100 / (this.slides.length - 2)}% - 4px)">${index}</span>`;
          },
        }
      });
      if (window.innerWidth >= 1280) {
        const pagination = [].slice.call(slider.querySelectorAll('.card-gallery__pagination-el'));
        pagination.forEach((el, index) => {
          el.addEventListener('mouseover', () => {
            this.slider.slideToLoop(index);
          });
        });
      }
      vueBus.$on('updateSlider', () => {
        this.slider.update();
        this.slider.slideReset(0);
      });
      this.$nextTick(() => {
        this.slider.slideReset(0);
      });
    }
  },
  props: ['slides', 'className', 'paginationClass', 'isPrev'],
});
