import Swiper from 'swiper/dist/js/swiper.min';
import cTitle from '../../fonts/title/title';
import cTitleFourth from '../../fonts/title/fourth/title-fourth';
import cTitleSecond from '../../fonts/title/second/title-second';
import cPicture from '../../core/picture/picture';
import cTabs from '../../tabs/tabs';
require('./about-awards.scss');

const template = require('./about-awards.pug');

export default template({
  components: {
    cTitle,
    cTitleFourth,
    cTitleSecond,
    cPicture,
    cTabs,
  },
  data() {
    return {
      activeTab: this.info.sliders[0].year,
      currentSlide: 1,
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
      const self = this;
      const slider = this.$el.querySelector('.about-awards__slider');
      const slides = slider.querySelectorAll('.about-awards__slide');
      if (slides.length > 1) {
        this.swiper = new Swiper(slider, {
          slidesPerView: 1,
          preloadImages: false,
          spaceBetween: 30,
          lazy: {
            loadPrevNext: true,
          },
          loop: true,
          on: {
            slideChange() {
              self.currentSlide = this.realIndex + 1;
            },
          },
        });
      }
    },
  },
  mounted() {
    this.initSlider();
  },
  props: ['info'],
});
