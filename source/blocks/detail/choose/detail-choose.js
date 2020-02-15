import cTitle from '../../fonts/title/title';
import cFilter from '../../filter/filter';
import cFilterDetail from '../../filter/detail/filter-detail';
import cDetailTable from '../table/detail-table';
import api from '../../../base/scripts/api';
import vueBus from '../../../base/scripts/vue/v-bus';
import vStore from '../../../base/scripts/vue/v-store';
import cSelect from '../../core/select/select';
import cCardSmall from '../../card/small/card-small';
import cPagination from '../../core/pagination/pagination';
require('./detail-choose.scss');

const template = require('./detail-choose.pug');

export default template({
  components: {
    cTitle,
    cFilter,
    cSelect,
    cFilterDetail,
    cDetailTable,
    cCardSmall,
    cPagination
  },
  data() {
    return {
      initedComponent: false,
      filter: {},
      order: {},
      currentPage: {}
    }
  },
  methods: {
    load() {
      api.get(window.setting.api.catalog, Object.assign({}, this.filter, this.order, this.currentPage)).then((response) => {
        this.info.cards = response.data.cards;
        if (response.data.pagination) this.info.pagination = response.data.pagination;
        this.info.cards.forEach(item => {
          item.isFav = (vStore.state.favorite.indexOf(item.id) !== -1)
        });
        vueBus.$emit('tableUpdated');
      });
    },
    setPage(page) {
      this.currentPage = Object.assign({}, { page });
      this.load();
    },
    setFilter(action, filter) {
      this.filter = Object.assign({}, filter);
      this.load();
    },
    setOrder(order) {
      this.order = Object.assign({}, order);
      this.load();
    },
    setSelectOrder(value) {
      const option = this.info.sort.values.find(el => el.value === value);
      this.order = Object.assign({}, {
        sortField: option.field,
        sortDirection: option.direction,
      });
      this.load();
    }

  },
  mounted() {
    if (this.info.pagination) this.page = this.info.pagination.current;
    this.$nextTick(() => {
      this.initedComponent = true;
    });
  },
  props: ['info'],
});
