import cCardGallery from '../gallery/card-gallery';
require('./card-small.scss');
import vStore from '../../../base/scripts/vue/v-store';

const template = require('./card-small.pug');

export default template({
  components: {
    cCardGallery,
  },
  props: ['card', 'className'],
  methods: {
    toggleFav() {
      this.card.isFav = !this.card.isFav;
      vStore.commit('toggleFavorite', this.card.id);
      if (!this.card.isFav) this.$emit('removeFav', this.card.id);
    }
  },
  mounted() {
    this.card.isFav = (vStore.state.favorite.indexOf(this.card.id) !== -1);
  },
});
