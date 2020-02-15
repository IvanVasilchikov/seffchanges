import debounce from 'lodash/debounce';
import cCoreCheckboxWithCircle from '../../../core/checkbox/with-circle/core-checkbox-with-circle';
import cBtn from '../../../core/btn/btn';
import api from '../../../../base/scripts/api';
import pluralize from '../../../../base/scripts/pluralize';
import vueBus from '../../../../base/scripts/vue/v-bus';
import vStore from '../../../../base/scripts/vue/v-store';
import PerfectScrollbar from 'perfect-scrollbar';
import catalogConst from '../../../filter/catalog/catalog-const';
require('./popup-area-metro-svg.scss');
require('./popup-area-metro.scss');

const template = require('./popup-area-metro.pug');

export default (resolve) => {
  api.get(window.setting.api.metro).then((responce) => {
    resolve(template({
      name: 'popupAreaMetro',
      data() {
        return {
          info: {
            metro: responce.data,
          },
          selectedStations: {},
          selectStation: [],
          offersCount: 0,
          search: '',
          getBounceCount: null,
          perfectScrollbar: null,
          dictionaryStationName: {},
          hideSticky: false,
          buttonWidth: '100%',
        };
      },
      computed: {
        objConst() {
          return catalogConst.fields.reduce((summ, item) => {
            summ[item] = [];
            return summ;
          }, {});
        },
        metroSid() {
          return this.info.metro.reduce((summ, item) => {
            summ[item.sid] = item.dbId;
            return summ;
          }, {});
        },
        getOffersCount() {
          return pluralize(this.offersCount, ['Предложение', 'Предложения', 'Предложений']);
        },
      },
      components: {
        cCoreCheckboxWithCircle,
        cBtn,
      },
      watch: {
        selectedStations: {
          handler(newValue) {
            const values = Object.keys(newValue);
            Array.from(this.$refs.svg_map.querySelectorAll('.metro-station--active')).forEach((item) => {
              item.classList.remove('metro-station--active');
            });
            this.info.metro.filter(item => values.indexOf(`${item.dbId}`) !== -1).forEach((item) => {
              if (newValue[item.dbId] === true) {
                if (this.$refs.svg_map.querySelector(`#${item.sid}`).parentElement.classList.contains('metro-station')) {
                  Array.from(this.$refs.svg_map.querySelector(`#${item.sid}`).parentElement.querySelectorAll('.metro-station')).forEach(item => item.classList.add('metro-station--active'));
                } else {
                  this.$refs.svg_map.querySelector(`#${item.sid}`).classList.add('metro-station--active');
                }
              } else {
                this.$refs.svg_map.querySelector(`#${item.sid}`).classList.remove('metro-station--active');
              }
            });
            this.getBounceCount();
          },
          deep: true,
        },
      },
      methods: {
        postParams() {
          return {
            metro: Object.keys(this.selectedStations)
              .filter(item => (item !== 'undefined') && this.selectedStations[item])
          };
        },
        getCount() {
          api.get(window.setting.api.objects, Object.assign({
            cnt: 1,
          }, vStore.state.mapFilter, this.objConst, this.postParams())).then((responce) => {
            this.offersCount = responce.data.count;
          });
        },
        save() {
          if (this.offersCount > 0) {
            this.$parent.$parent.close();
            vueBus.$emit('setMetro', this.postParams(), this.postParams().metro.length);
          }
        },
        svgMapClick(event) {
          let stationId = event.srcElement.parentElement.id;
          const eventParent = event.srcElement.parentElement;
          const stationParent = event.srcElement.parentElement.parentElement;
          if (eventParent.querySelector('g')) {
            stationId = eventParent.querySelector('g').id;
          } else {
            stationId = eventParent.id;
          }
          if (stationParent.classList.contains('metro-station')) {
            stationId = Array.from(stationParent.querySelectorAll('.metro-station')).map((item) => item.id);
          }
          if (Array.isArray(stationId)) {
            stationId.forEach((item) => {
              const dbId = this.metroSid[item];
              if (this.selectedStations[dbId]) {
                this.$delete(this.selectedStations, dbId);
              } else {
                this.$set(this.selectedStations, dbId, true);
              }
            });
          } else {
            const dbId = this.metroSid[stationId];
            if (this.selectedStations[dbId]) {
              this.$delete(this.selectedStations, dbId);
            } else {
              this.$set(this.selectedStations, dbId, true);
            }
          }
        },
        reset() {
          this.selectedStations = {};
          this.selectStation = [];
          vueBus.$emit('setMetro', this.postParams(), 'reset');
        },
        selectStations(type) {
          /* FIXME: Алгоритм на переосмысление. Тупой алгоритм.
           Много исключений. Надо переделать на понятный. */
          const index = this.selectStation.indexOf(type);
          if (index !== -1) {
            this.selectStation.splice(index, 1);
          } else if (type === 'all') {
            this.selectStation = ['all'];
          } else {
            this.selectStation.push(type);
            const indexAll = this.selectStation.indexOf('all');
            if (indexAll !== -1) {
              this.selectStation.splice(indexAll, 1);
              type = 'all';
            }
          }
          this.info.metro.filter((item) => {
            let result = false;
            if (this.selectStation.indexOf('all') !== -1 || type === 'all') {
              result = true;
              if (this.selectStation.indexOf('all') === -1 && result) {
                item.remove = true;
              }
            }
            if (this.selectStation.indexOf('inside') !== -1 || type === 'inside') {
              if (item.inside === true) {
                result = true;
                if (this.selectStation.indexOf('inside') === -1 && result) {
                  item.remove = true;
                } else {
                  item.remove = false;
                }
              }
            }
            if (this.selectStation.indexOf('ring') !== -1 || type === 'ring') {
              if (item.isRing === true) {
                result = true;
                if (this.selectStation.indexOf('ring') === -1) {
                  item.remove = true;
                } else {
                  item.remove = false;
                }
              }
            }
            return result;
          }).forEach((item) => {
            if (item.remove === true) {
              item.remove = false;
              this.$set(this.selectedStations, item.dbId, false);
            } else {
              this.$set(this.selectedStations, item.dbId, true);
            }
          });
        },
        ucFirst(str) {
          if (!str) return str;
          return str[0].toUpperCase() + str.slice(1).toLowerCase();
        },
        viewStation(station) {
          return (station.dbName.indexOf(this.ucFirst(this.search.trim())) !== -1);
        },
      },
      created() {
        this.dictionaryStationName = this.info.metro.reduce((dictionaryStationName, item) => {
          if (!dictionaryStationName[item.dbId]) dictionaryStationName[item.dbId] = item.dbName;
          return dictionaryStationName;
        }, []);
        const dataMetro = vStore.state.mapFilter.metro;
        if (dataMetro) {
          this.selectedStations = dataMetro.reduce((summ, item) => {
            summ[item] = true;
            return summ;
          }, {});
        }
      },
      mounted() {
        this.getBounceCount = debounce(this.getCount, 300);
        this.perfectScrollbar = new PerfectScrollbar(this.$refs.scroll, {
          suppressScrollX: true,
          wheelSpeed: 0.5,
          minScrollbarLength: 100,
          maxScrollbarLength: 210,
          wheelPropagation: true,
        });
        this.getBounceCount();
        this.hideSticky = window.innerWidth >= 768;
        if (this.$refs.submitBtn) this.buttonWidth = this.$refs.submitBtn.$el.offsetWidth;
        this.$parent.$el.addEventListener('scroll', () => {
          if (window.innerWidth <= 767) {
            const stickyBtnPos = this.$refs.stickyBtn.$el.getBoundingClientRect().y;
            const btnPos = this.$refs.submitBtn.$el.getBoundingClientRect().y;
            this.hideSticky = btnPos <= stickyBtnPos;
          }
        });
      },
      updated() {
        this.perfectScrollbar.update();
        if (this.$refs.submitBtn) this.buttonWidth = this.$refs.submitBtn.$el.offsetWidth;
      },
    }));
  });
};
