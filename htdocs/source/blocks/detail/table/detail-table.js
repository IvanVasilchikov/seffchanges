import PerfectScrollbar from 'perfect-scrollbar';
import popupEvent from '../../../base/scripts/popupEvent';
import vueBus from '../../../base/scripts/vue/v-bus';
import vStore from '../../../base/scripts/vue/v-store';
require('./detail-table.scss');
const util = require('../../../../util');

const template = require('./detail-table.pug');

export default template({
  data() {
    return {
      scrollbar: null,
      sortField: false,
      sortDirection: 'asc',
      util
    }
  },
  methods: {
    setSort(head) {
      if (head.sorter) {
        const field = head.sortField;
        this.sortField = field;
        if (this.sortField == field) {
          if (this.sortDirection === 'asc') {
            this.sortDirection = 'desc';
          } else {
            this.sortDirection = 'asc';
          }
        } else {
          this.sortDirection = 'asc';
        }
        this.sortField = field;
        this.$emit('setOrder', {
          sortField: field,
          sortDirection: this.sortDirection
        });
      }
    },
    openPopup(id) {
      popupEvent.open('form', 'writeUs', {
        hidden: {
          object_id: id
        }
      });
    },
    goToPage(link, e) {
      const {
        target
      } = e;
      if (!target.classList.contains('detail-table__button') && !target.classList.contains('detail-table__like')) {
        window.open(link);
      }
    },
    toggleFav(item) {
      item.isFav = !item.isFav;
      vStore.commit('toggleFavorite', item.id);
    },
    initScrollBar() {
      this.scrollbar = new PerfectScrollbar(this.tableWrap, {
        suppressScrollX: true,
      });
    }
  },
  mounted() {
    this.info.forEach(item => {
      item.isFav = (vStore.state.favorite.indexOf(item.id) !== -1)
    });
    this.tableWrap = this.$el.querySelector('.detail-table__wrp');
    if (this.tableWrap) {
      this.initScrollBar();

      window.addEventListener('resize', () => {
        if (window.innerWidth <= 1279 && this.scrollbar !== null) {
          this.scrollbar.destroy();
          this.scrollbar = null;
        } else if (window.innerWidth >= 1280 && this.scrollbar === null) {
          this.initScrollBar();
        }
      });

      vueBus.$on('tableUpdated', () => {
        if (this.scrollbar !== null) this.$nextTick(() => this.scrollbar.update());
      });
    }
  },
  props: ['table', 'info', 'className'],
});
