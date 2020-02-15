import Swiper from 'swiper/dist/js/swiper.min';
import cTitle from '../../fonts/title/title';
import cText from '../../fonts/text/text';
import cPicture from '../../core/picture/picture';
import popupEvent from '../../../base/scripts/popupEvent';
require('./detail-about.scss');

const template = require('./detail-about.pug');

export default template({
  components: {
    cTitle,
    cText,
    cPicture,
  },
  methods: {
    popupOpen(type, name) {
      popupEvent.open(type, name);
    },
  },
  mounted() {
    const slider = this.$el.querySelector('.detail-about__slider');

    if (slider && this.info.slider.length > 1) {
      this.slider = new Swiper(slider, {
        slidesPerView: 1,
        preloadImages: false,
        spaceBetween: 20,
        loop: true,
        lazy: {
          loadOnTransitionStart: true,
        },
      });
    }
  },
  props: ['info'],
});
