import Vue from 'vue';
import cBreadcrumbs from '../core/breadcrumbs/breadcrumbs';
import cFilterCatalog from '../filter/catalog/filter-catalog';
import cLabel from '../core/label/label';
import cSelect from '../core/select/select';
import cTitleFourth from '../fonts/title/fourth/title-fourth';
import cText from '../fonts/text/text';
import cPresentation from '../presentation/presentation';
import cBannerRequest from '../banner/request/banner-request';
import cBannerSend from '../banner/send/banner-send';
import cCatalogList from './list/catalog-list';
import cCard from '../card/card';
import cCardTable from '../card/table/card-table';
import cCardSmall from '../card/small/card-small';
import cPagination from '../core/pagination/pagination';
import cSeoLinks from '../seo/links/seo-links';
import api from '../../base/scripts/api';
import ScrollTo from '../../base/scripts/scrollTo';
import popupEvent from '../../base/scripts/popupEvent';
import cFilterNoResult from '../filter/noResult/filter-noResult';

require('./catalog.scss');

const template = require('./catalog.pug');

const loadType = Object.freeze({
  page: Symbol('page'),
  filter: Symbol('filter'),
  sort: Symbol('sort'),
});

export default function (rootEl) {
  if (window.INIT && window.INIT.catalog) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cBreadcrumbs,
        cFilterCatalog,
        cLabel,
        cSelect,
        cTitleFourth,
        cText,
        cCatalogList,
        cCard,
        cCardTable,
        cCardSmall,
        cFilterNoResult,
        cPresentation,
        cBannerRequest,
        cBannerSend,
        cPagination,
        cSeoLinks
      },
      data() {
        return {
          info: window.INIT.catalog,
          catalogView: 'list',
          activePage: 1
        };
      },
      methods: {
        popupOpen(type, name, typeEstate) {
          const data = {
            initSelectData: {
              typeEstate
            }
          };
          popupEvent.open(type, name, data);
        },
        changeDisplayType(type) {
          this.catalogView = type;
        },
        setPage(page) {
          this.info.requiesData.page = page;
          this.loadNewData(loadType.page, false);
        },
        setSort(val) {
          this.$set(this.info.requiesData, 'order', val);
          this.loadNewData(loadType.page, false);
        },
        loadNewData(filter, filtered = true, init = false) {
          // TODO: fix filter submit
          if (filtered) {
            this.info.requiesData = Object.assign({}, filter, {
              order: this.info.requiesData.order ? this.info.requiesData.order : '',
              page: 1
            });
          } else {
            this.info.requiesData.page = filter !== loadType.page ? 1 : this.info.requiesData.page;
          }
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
          if (!init) {
            api.get(window.setting.api.catalog, this.info.requiesData).then((response) => {
              const {
                pagination,
                cards,
                seo,
                url,
                reload
              } = response.data;
              if (url) {
                if (reload) {
                  window.location.href = url;
                  return;
                } else {
                  window.history.pushState('', '', url);
                }
              } else {
                window.history.pushState('', '', filterString);
              }
              this.info.pagination = pagination;
              this.info.cards = cards;
              if (seo) {
                this.info.title = seo.title_page;
                document.title = seo.title;
                if (this.info.seo) this.info.seo.items = seo.items;
              }
              ScrollTo({
                anchor: '#catalog'
              });
            });
          }
        },
      },
      mounted() {
        this.catalogView = window.innerWidth <= 767 ? 'tiles' : 'list';
        window.addEventListener('resize', () => {
          this.catalogView = window.innerWidth <= 767 ? 'tiles' : 'list';
        });
        this.$set(this.info.requiesData, 'order', this.info.sort.values.filter(el => el.selected)[0].value);
      }
    }));
    app.$mount(rootEl);
  }
};
