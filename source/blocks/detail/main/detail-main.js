import Swiper from 'swiper/dist/js/swiper.min';
import vStore from '../../../base/scripts/vue/v-store';
import popupEvent from '../../../base/scripts/popupEvent';
import cBtn from '../../core/btn/btn';
import cPicture from '../../core/picture/picture';
import cBreadcrumbs from '../../core/breadcrumbs/breadcrumbs';
import ScrollTo from '../../../base/scripts/scrollTo';
import bodyFixed from '../../../base/scripts/body-fixed';
require('./detail-main.scss');

const template = require('./detail-main.pug');

export default template({
  components: {
    cPicture,
    cBtn,
    cBreadcrumbs,
  },
  data() {
    return {
      showHeader: false,
      currency: 'rub',
      fullGallery: false,
      fullSlider: false,
      activeAnchor: '#main',
    }
  },
  watch: {
    currency() {
      if (this.info.price && this.info.price.selected) {
        if (this.info.price.meters) this.info.price.selected.meters = this.info.price.meters[`${this.currency}`];
        if (this.info.price.total) {
          this.info.price.selected.total = this.info.price.total[`${this.currency}`];
          if (this.$parent.$refs.nav) this.$parent.$refs.nav.nav.price = this.info.price.selected.total;
        }
      }
    },
  },
  methods: {
    toggleFav() {
      this.info.isFav = !this.info.isFav;
      vStore.commit('toggleFavorite', this.info.id);
      if (!this.info.isFav) this.$emit('removeFav', this.info.id);
    },
    scrollTo(anchor) {
      let offset = 0;
      if (window.innerWidth >= 1280) {
        offset = 78;
      }

      ScrollTo({
        anchor,
        offset,
      });
    },
    closeFullscreen() {
      this.fullGallery = false;
      bodyFixed.unFixed();
    },
    popupOpen(type, name) {
      popupEvent.open(type, name, {
        hidden: {
          object: this.info.id,
          page: window.location.pathname
        },
      });
    },
  },
  mounted() {
    this.info.isFav = (vStore.state.favorite.indexOf(this.info.id) !== -1);
    if (this.info.images.length > 1) {
      const mainSlider = this.$el.querySelector('.detail-main__slider');
      const thumbSlider = this.$el.querySelector('.detail-main__thumb-slider');
      const thumb = new Swiper(thumbSlider, {
        watchSlidesVisibility: true,
        watchSlidesProgress: true,
        resistance: true,
        resistanceRatio: 0,
        spaceBetween: 10,
        slidesPerView: 'auto'
      });

      this.mainSlider = new Swiper(mainSlider, {
        slidesPerView: 1,
        resistance: true,
        resistanceRatio: 0,
        preloadImages: false,
        loop: true,
        lazy: {
          loadOnTransitionStart: true,
        },
        thumbs: {
          swiper: thumb,
        },
      });
      document.addEventListener("keydown", (e) => {
        if (e.keyCode == 27) {
          this.closeFullscreen();
        }
      }, false);
      mainSlider.addEventListener('click', () => {
        this.fullGallery = true;
        this.$nextTick(() => {
          const fullSlider = this.$el.querySelector('.detail-main__slider-wrp--full .detail-main__slider');
          bodyFixed.fixed(fullSlider);
          this.fullSlider = new Swiper(fullSlider, {
            slidesPerView: 1,
            resistance: true,
            resistanceRatio: 0,
            loop: true,
            lazy: {
              loadPrevNext: true,
              loadPrevNextAmount: 4,
            },
          });
          this.fullSlider.slideTo(this.mainSlider.activeIndex, 0);
          this.fullSlider.on('slideChange', () => {
            this.mainSlider.slideTo(this.fullSlider.activeIndex, 0);
          });
        })
      });
    }
  },
  props: ['info'],
});
