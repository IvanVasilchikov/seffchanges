import Vue from 'vue';
import cBreadcrumbs from '../core/breadcrumbs/breadcrumbs';
import cTitle from '../fonts/title/title';
import cTabs from '../tabs/tabs';
import cCard from '../card/card';
import cCardTable from '../card/table/card-table';
import vStore from '../../base/scripts/vue/v-store';
require('./favorite.scss');

const template = require('./favorite.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.favorite) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cBreadcrumbs,
        cTitle,
        cTabs,
        cCard,
        cCardTable,
      },
      data() {
        const elements = [];
        vStore.state.favorite.forEach((item) => {
          elements.push(item.toString());
        });
        return {
          info: window.INIT.favorite,
          activeTab: window.INIT.favorite.tabs[0].value,
          favoriteCard: elements,
        }
      },
      watch: {
        favoriteCard() {
          if (this.tabs.filter(item => item.value === this.activeTab).length === 0) {
            this.activeTab = 'all';
          }
        }
      },
      computed: {
        cards() {
          return this.info.cards.filter(item => (this.favoriteCard.indexOf(item.id) !== -1));
        },
        filteredCards() {
          return this.cards.filter((el) => (this.activeTab !== 'all' ? this.activeTab === el.category : true))
        },
        tabs() {
          return this.info.tabs.map(tab => {
            if (tab.value !== 'all') {
              tab.count = this.cards.filter((card) => {
                return card.category === tab.value;
              }).length;
            } else {
              tab.count = this.cards.length;
            }
            return tab;
          }).filter(item => (item.count > 0));
        }
      },
      methods: {
        printPage() {
          window.print();
        },
        setTab(val) {
          this.activeTab = val;
        },
        removeCard(id) {
          const index = this.favoriteCard.indexOf(id);
          if (index !== -1) {
            this.favoriteCard.splice(index, 1);
          }
        },
        removeAllCards() {
          vStore.commit('removeAllFavorite');
          this.info.cards = [];
        },
        countCards() {
          if (this.info.tabs) {
            this.info.tabs.forEach((tab) => {
              if (tab.value !== 'all') {
                const filteredCards = this.info.cards.filter((card) => {
                  return card.category === tab.value;
                });
                this.$set(tab, 'count', `(${filteredCards.length})`);
              } else {
                this.$set(tab, 'count', `(${this.info.cards.length})`);
              }
            });
          }
        }
      },
      mounted() {
        const ids = this.info.cards.map(item => item.id);
        this.favoriteCard.forEach((item) => {
          if (ids.indexOf(item) === -1) {
            vStore.commit('toggleFavorite', item);
          }
        });
      },
    }));
    app.$mount(rootEl);
  }
};
