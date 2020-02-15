import cPopupObjectGallery from './gallery/popup-object-gallery';
import cBtn from '../../core/btn/btn';
import cBannerRequest from '../../banner/request/banner-request';
import VueBus from '../../../base/scripts/vue/v-bus';
require('./popup-object.scss');

const template = require('./popup-object.pug')

export default template({
  name: 'popupObject',
  props: ['info'],
  components: {
    cPopupObjectGallery,
    cBtn,
    cBannerRequest,
  },
  data() {
    return {
      index: this.info.index,
      card: this.info.cards[this.info.index],
    }
  },
  methods: {
    toggleFav() {
      this.card.isFav = !this.card.isFav;
      vStore.commit('toggleFavorite', this.card.id);
      if (!this.card.isFav) this.$emit('removeFav', this.card.id);
    },
    changeIndex(count) {
      setTimeout(() => {
        this.info.index += count;
        this.card = this.info.cards[this.info.index];

        setTimeout(() => {
          VueBus.$emit('restart');
        }, 100);
      }, 1);
    },
  },
  mounted() {
    VueBus.$on('bannerRequestSubmit', () => {
      window.popup_object = this.info;
    });
    if (this.info.request) {
      this.info.request.form.hidden.object_name = this.card.name;
      this.info.request.form.hidden.object_id = this.card.id;
    }
  },
});
