import vStore from '../../../base/scripts/vue/v-store';
import api from '../../../base/scripts/api';
import cFilter from '../../filter/filter';
import popupEvent from '../../../base/scripts/popupEvent';
import cTitle from '../../fonts/title/title';
import cCatalogList from '../../catalog/list/catalog-list';
import cCardSmall from '../../card/small/card-small';
import cFilterNoResult from '../../filter/noResult/filter-noResult';
import cPagination from '../../core/pagination/pagination';
import ScrollTo from '../../../base/scripts/scrollTo';

require('./detail-offers.scss');

const template = require('./detail-offers.pug');

const loadType = Object.freeze({
  page: Symbol('page'),
  filter: Symbol('filter'),
  sort: Symbol('sort'),
});

export default template({
  components: {
    cTitle,
    cFilter,
    cCatalogList,
    cCardSmall,
    cPagination,
    cFilterNoResult,
  },
  data() {
    return {}
  },
  methods: {
    openPopup(name) {
      popupEvent.openAsync('area', name);
    },
    setPage(page) {
      this.info.requiesData.page = page;
      this.info.pagination.current = page;
      this.submitFilter(this.info.filter.action, loadType.page, false);
    },
    submitFilter(action, data, filtered = true, init = false) {
      if (filtered) {
        this.info.requiesData = Object.assign({}, data, {
          page: 1
        });
      } else {
        this.info.requiesData.page = data !== loadType.page ? 1 : this.info.requiesData.page;
      }

      if (!init) {
        api.get(action, this.info.requiesData).then((response) => {
          const { pagination, cards } = response.data;
          this.info.pagination = pagination;
          this.info.cards = cards;

          let filterString = '?';
          Object.keys(this.info.requiesData).forEach((key) => {
            if (Array.isArray(this.info.requiesData[`${key}`])) {
              this.info.requiesData[`${key}`].forEach((subitem) => {
                filterString += `${key}[]=${subitem}&`;
              });
            } else {
              filterString += `${key}=${this.info.requiesData[`${key}`]}&`;
            }
          });

          if (filterString[filterString.length - 1] === '&') {
            filterString = filterString.slice(0, -1);
          }

          window.history.pushState('', '', filterString);
          vStore.commit('saveFilter', data);

          ScrollTo({
            anchor: '#offers'
          });
        });
      }
    },
  },
  props: ['info'],
});
