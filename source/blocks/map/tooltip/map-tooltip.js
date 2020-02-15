import cBtn from '../../core/btn/btn';
import cCardGallery from '../../card/gallery/card-gallery';
import vStore from '../../../base/scripts/vue/v-store';
import PerfectScrollbar from 'perfect-scrollbar';
import '../../card/gallery/card-gallery.scss';
import vueBus from '../../../base/scripts/vue/v-bus';
require('./map-tooltip.scss');
const template = require('./map-tooltip.pug');

export default template({
  components: {
    cCardGallery,
    cBtn,
  },
  methods: {
    toggleFav() {
      this.info.isFav = !this.info.isFav;
      vStore.commit('toggleFavorite', this.info.id);
    },
    openLink() {
      window.open(this.info.link);
    },
    open() {
      this.$el.classList.add('map-tooltip--open');
      setTimeout(() => {
        vueBus.$emit('updateSlider');
        setTimeout(() => {
          vueBus.$emit('updateSlider');
        }, 10);
      }, 10);
    },
    close() {
      this.$el.classList.remove('map-tooltip--open');
    },
    initScrollBar(mapWrapper) {
      this.$el.style.maxHeight = `${mapWrapper.offsetHeight - 20}px`;
      this.scrollbar = new PerfectScrollbar(this.$el, {
        suppressScrollX: true,
        wheelSpeed: 0.5,
        wheelPropagation: false,
      });
    }
  },
  mounted() {
    this.info.isFav = (vStore.state.favorite.indexOf(this.info.id) !== -1);
  },
  props: ['info', 'className'],
});
