import cBtn from '../core/btn/btn';
import vStore from '../../base/scripts/vue/v-store';
import cCardGallery from './gallery/card-gallery';
import popupEvent from '../../base/scripts/popupEvent';
require('./card.scss');

const template = require('./card.pug');

export default template({
  components: {
    cBtn,
    cCardGallery,
  },
  methods: {
    openLink() {
      window.open(this.card.link);
    },
    toggleFav() {
      this.card.isFav = !this.card.isFav;
      vStore.commit('toggleFavorite', this.card.id);
      if (!this.card.isFav) this.$emit('removeFav', this.card.id);
    },
    popupOpen(type, name) {
      popupEvent.open(type, name, {
        hidden: {
          object: this.card.id,
          page: window.location.pathname
        },
      });
    },
  },
  mounted() {
    this.card.isFav = (vStore.state.favorite.indexOf(this.card.id) !== -1);
  },
  props: ['card', 'className'],
});
