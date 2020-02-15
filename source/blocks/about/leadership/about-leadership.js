import Swiper from 'swiper/dist/js/swiper.min';
import cTitle from '../../fonts/title/title';
import cText from '../../fonts/text/text';
import cTitleFourth from '../../fonts/title/fourth/title-fourth';
import cPicture from '../../core/picture/picture';
require('./about-leadership.scss');

const template = require('./about-leadership.pug');

export default template({
  components: {
    cTitle,
    cTitleFourth,
    cText,
    cPicture,
  },
  mounted() {
    if (this.info.slides.length > 1) {
      const slider = this.$el.querySelector('.about-leadership__slider');
      this.slider = new Swiper(slider, {
        slidesPerView: 1,
        preloadImages: false,
        autoHeight: true,
        spaceBetween: 30,
        lazy: {
          loadPrevNext: true,
        },
        loop: true,
      });
    }
  },
  props: ['info'],
});
