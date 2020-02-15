import cBtn from '../../core/btn/btn';
import cCardGallery from './../gallery/card-gallery';
require('./card-table.scss');
import vStore from '../../../base/scripts/vue/v-store';

const template = require('./card-table.pug');

export default template({
  components: {
    cBtn,
    cCardGallery,
  },
  methods: {
    openLink() {
      window.open(this.card.link);
    },
    goToPage(page) {
      window.open(page);
    },
    toggleFav() {
      this.card.isFav = !this.card.isFav;
      vStore.commit('toggleFavorite', this.card.id);
      if (!this.card.isFav) this.$emit('removeFav', this.card.id);
    }
  },
  mounted() {
    this.card.isFav = (vStore.state.favorite.indexOf(this.card.id) !== -1);
  },
  props: ['card', 'className'],
});
