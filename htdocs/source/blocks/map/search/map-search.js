import Vue from 'vue';
import vStore from '../../../base/scripts/vue/v-store';
import cBreadcrumbs from '../../core/breadcrumbs/breadcrumbs';
import cMap from '../map';
import cFilter from '../../filter/filter';
import api from '../../../base/scripts/api';
require('./map-search.scss');

const template = require('./map-search.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.mapSearch) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cBreadcrumbs,
        cFilter,
        cMap,
      },
      data() {
        return {
          info: window.INIT.mapSearch,
          markers: []
        };
      },
      methods: {
        async updateMap(action, data) {
          const passData = Object.assign({}, data);
          this.markers = [];
          let needLoad = false;
          do {
            const response = await api.get(action, passData);
            const processData = response.data.cards.filter(item => item.map_coords).map(item => {
              return {
                "coords": item.map_coords,
                "icon": "/assets/svg/map-pin.svg",
                "iconActive": "/assets/svg/map-pin-active.svg",
                "type": "default",
                "tooltip": item
              }
            });
            if (response.data.breadcrumbs) {
              this.info.breadcrumbs = response.data.breadcrumbs;
            }
            this.markers = this.markers.concat(processData);
            if (response && response.data && response.data.pagination) {
              passData.page = response.data.pagination.current + 1;
              needLoad = (response.data.pagination.current < response.data.pagination.count);
            }
          } while (needLoad);
          if (this.$refs.map) this.$refs.map.updateMarkers(this.markers);
          vStore.commit('saveFilter', data);
        }
      },
    }));
    app.$mount(rootEl);
  }
};
