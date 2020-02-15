import Vue from 'vue';
import cBannerVisual from '../banner/visual/banner-visual';
import cFilterVisual from '../filter/visual/filter-visual'
import cBannerRequest from '../banner/request/banner-request';
import cSeoLinks from '../seo/links/seo-links';
import cTitleFourth from '../fonts/title/fourth/title-fourth';
import cText from '../fonts/text/text';
import cCardVisual from '../card/visual/card-visual';
import cLoader from '../core/loader/loader';
import api from '../../base/scripts/api';
import ScrollTo from '../../base/scripts/scrollTo';
import popupEvent from '../../base/scripts/popupEvent';
import cFilterNoResult from '../filter/noResult/filter-noResult';
require('./visual.scss');

const template = require('./visual.pug');

const loadType = Object.freeze({
  page: Symbol('page'),
  filter: Symbol('filter'),
});

export default function (rootEl) {
  if (window.INIT && window.INIT.visualSearchPage) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cBannerVisual,
        cFilterVisual,
        cBannerRequest,
        cSeoLinks,
        cTitleFourth,
        cText,
        cCardVisual,
        cLoader,
        cFilterNoResult,
      },
      data() {
        return {
          info: window.INIT.visualSearchPage,
          visibleLoader: false,
          pauseLoader: false,
          activePage: 1
        };
      },
      methods: {
        openObjectPopup(index) {
          const data = { index };
          data.cards = this.info.cards;
          data.request = this.info.cards_request;

          popupEvent.openAsync('object', data, 'popup__content--object');
        },
        setPage(page) {
          this.info.requiesData.page = page;
          this.loadNewData(loadType.page, false, false, false);
        },
        loadNewData(filter, filtered = true, init = false, scroll = true) {
          // TODO: fix filter submit
          if (filtered) {
            this.info.requiesData.page = 1;
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
            api.get(window.setting.api.visualSearch, this.info.requiesData).then((response) => {
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
              }
              if (scroll) {
                ScrollTo({
                  anchor: '#filter-visual'
                });
              }
              this.changeVisibleLoader();
            });
          }
        },
        changeVisibleLoader() {
          this.visibleLoader = this.info.requiesData.page < this.info.pagination.count ? true : false;
        },
        visible(target) {
          const targetPosition = {
            top: window.pageYOffset + target.getBoundingClientRect().top,
            bottom: window.pageYOffset + target.getBoundingClientRect().bottom
          };
          const windowPosition = {
            top: window.pageYOffset,
            bottom: window.pageYOffset + document.documentElement.clientHeight
          };

          if (targetPosition.bottom > windowPosition.top && targetPosition.top < windowPosition.bottom) {
            this.pauseLoader = true;
            setTimeout(() => {
              this.setPage(this.info.requiesData.page + 1);
              this.pauseLoader = false;
            }, 600);
          }
        },
      },
      mounted() {
        this.changeVisibleLoader();

        window.addEventListener('scroll', () => {
          const btnLoader = this.$el.querySelector('.visual__cards-btn-loader');
          this.visibleLoader && btnLoader && !this.pauseLoader && this.visible(btnLoader);
        });
      },
    }));
    app.$mount(rootEl);
  }
};
