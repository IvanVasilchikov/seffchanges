import debounce from 'lodash/debounce';
import URLSearchParams from 'url-search-params';
import cFilterRadio from '../radio/filter-radio';
import cSelect from '../../core/select/select';
import cFilterRange from '../range/filter-range';
import cLabel from '../../core/label/label';
import cHint from '../../core/hint/hint';
import cFilterAddress from '../address/filter-address';
import cBtn from '../../core/btn/btn';
import cAnimationHeight from '../../core/animation/height/animation-height';
import vStore from '../../../base/scripts/vue/v-store';
import popupEvent from '../../../base/scripts/popupEvent';
import filterCommon from '../filterCommon';
import VueBus from '../../../base/scripts/vue/v-bus';
import catalogConst from './catalog-const';
require('./filter-catalog.scss');

const template = require('./filter-catalog.pug');

export default template({
  components: {
    cFilterRadio,
    cSelect,
    cFilterRange,
    cFilterAddress,
    cAnimationHeight,
    cBtn,
    cLabel,
    cHint
  },
  mixins: [filterCommon],
  data() {
    return {
      submitEventDebounce: '',
      showMore: false,
      filter: {},
      tagsFilter: [],
    }
  },
  watch: {
    filter: {
      handler(newValue) {
        if (this.info.tags && this.info.tags.field) {
          let fieldValue = newValue[this.info.tags.field];
          if (fieldValue !== null && fieldValue !== undefined) {
            fieldValue = Array.isArray(fieldValue) ? [].slice.call(fieldValue) : [fieldValue];
            this.$set(this, 'tagsFilter', fieldValue);
          } else {
            this.$set(this, 'tagsFilter', []);
          }
        }
        // this.$update();
      },
      deep: true,
    }
  },
  computed: {
    fieldsConds() {
      return this.showFields(this.info.fields);
    },
    fieldsCondsMore() {
      return this.showFields(this.info.more);
    },
    visibleButtons() {
      return this.showFields(this.info.popupButtons);
    },
    visibleTags() {
      if (this.info.tags && this.info.tags.list) {
        if (this.info.tags.isDynamic && this.info.tags.field.length > 0) {
          if (this.tagsFilter.length !== 0) {
            const notIncluded = this.info.tags.list.filter(tag => !this.tagsFilter.includes(tag.type));
            if (notIncluded.length !== 0) {
              VueBus.$emit('clearLabel', notIncluded.map(el => el.value));
              notIncluded.forEach((tag) => {
                if (this.filter.tags) {
                  const index = this.filter.tags.indexOf(tag.value);
                  if (index !== -1) this.filter.tags.splice(index, 1);
                }
              });
            }
            return this.info.tags.list.filter(tag => this.tagsFilter.includes(tag.type));
          }
        } else return this.info.tags.list;
      }
      return null;
    },
    special() {
      if (this.info.tags && this.info.tags.special) {
        return this.info.tags.special;
      }
      return null;
    },
  },
  methods: {
    openPopup(popupInfo) {
      vStore.commit('saveFilter', this.clearFilter);
      popupEvent.openAsync('area', Object.assign({}, popupInfo, {
        tabs: this.info.popupButtons
      }), '', 'popup__wrapper--area');
    },
    setTag(tag) {
      if (this.filter.tags === undefined) {
        this.$set(this.filter, 'tags', []);
      }
      const index = this.filter.tags.indexOf(tag.value);
      if (tag.checked) {
        if (index < 0) this.filter.tags.push(tag.value);
      } else {
        if (index !== -1) this.filter.tags.splice(index, 1);
      }
      this.$set(this.filter, 'tags', [].slice.call(this.filter.tags));
    },
    resetFilter() {
      this.tagsFilter = [];
      this.$set(this.filter, 'tags', []);
      this.fields.forEach(item => {
        if (this.filter[item] !== undefined) {
          this.filter[item] = [];
        }
      });
      const fieldsList = [].concat(this.info.fields, this.info.more).map(item => item.name);
      const rangeFields = this.info.fields.find(field => field.range).range;
      if (rangeFields) {
        if (rangeFields.currency) fieldsList.push(rangeFields.currency.name);
        if (rangeFields.range) fieldsList.push(rangeFields.range.name);
      }
      VueBus.$emit('clearField', fieldsList);
      this.$nextTick(() => {
        if (!this.mainFilter) this.submitEventDebounce();
      });
      this.clearPopupButtons();
    },
    submitFilter() {
      vStore.commit('saveFilter', this.clearFilter);
      this.$emit('filterSubmit', this.clearFilter);
    },
    setPopupFields(params) {
      this.fields.forEach((item) => {
        if (params[item]) {
          this.$set(this.filter, item, params[item]);
        } else {
          if (this.visibleButtons.length !== 0) {
            this.visibleButtons.forEach(btn => this.$set(btn, 'count', false));
          }
          this.$delete(this.filter, item);
        }
      });
      vStore.commit('saveFilter', this.clearFilter);
    },
    updateTags() {
      if (this.info.tags) {
        if (this.info.tags.special && this.info.tags.special.length !== 0) {
          this.info.tags.special.forEach((tag) => {
            if (this.filter.tags.includes(tag.value)) {
              this.$set(tag, 'checked', true);
              this.showTags(tag);
            }
          });
        }
        if (this.info.tags.list && this.info.tags.list.length !== 0) {
          this.info.tags.list.forEach((tag) => {
            if (this.filter.tags.includes(tag.value)) {
              this.$set(tag, 'checked', true);
              this.setTag(tag);
            }
          });
        }
      }
    },
    setInitFields(value, name) {
      if (name.indexOf('[]') !== -1) {
        const tmpName = name.substring(0, name.length - 2);
        if (this.filter[tmpName] === undefined) {
          this.$set(this.filter, tmpName, []);
        }
        this.filter[`${tmpName}`].push(value);
        if (tmpName === 'tags') {
          this.updateTags();
        }
      } else {
        this.$set(this.filter, name, value);
      }
    },
    updateButtonCount(type, count) {
      if (this.visibleButtons && this.visibleButtons.length !== 0) {
        const button = this.visibleButtons.find(el => el.popup === type);
        const countText = count === 'reset' ? false : count;
        if (button) this.$set(button, 'count', countText);
      }
      if (count !== 'reset') this.submitFilter();
    },
  },
  created() {
    this.fields = catalogConst.fields;
    if (this.info.popupButtons) {
      this.info.popupButtons.forEach(item => {
        if (item.variable) this.fields.push(item.variable);
      });
    }
    this.submitEventDebounce = debounce(this.submitFilter, 500);
    const params = new URLSearchParams(window.location.search);
    if (params.has('realty_type')) {
      this.activeTab = params.get('realty_type');
    }
    params.forEach((value, name) => {
      this.setInitFields(value, name);
    });
    if (this.info.params !== undefined) {
      Object.keys(this.info.params).forEach((key) => {
        this.setInitFields(this.info.params[key], key);
      });
    }
    vStore.commit('saveFilter', this.clearFilter);
    this.info.fields.forEach((item) => {
      if (item.type !== 'range') {
        if (item.type === 'hidden') {
          this.$set(this.filter, item.name, item.value);
        } else this.updateValue(item);
      }
    });

    if (this.info.more) {
      this.info.more.forEach((item) => {
        if (item.type !== 'range') this.updateValue(item);
      });
    }
    VueBus.$on('setMetro', (params, count) => {
      this.setPopupFields(params);
      this.updateButtonCount('popupAreaMetro', count);
    });
    VueBus.$on('setDistrict', (params, count) => {
      this.setPopupFields(params);
      this.updateButtonCount('popupAreaDistrict', count);
    });
    VueBus.$on('setCountryCity', (params, count) => {
      this.setPopupFields(params);
      this.updateButtonCount('popupCountryCity', count);
    });
    VueBus.$on('resetFilter', () => {
      this.resetFilter();
    });
    VueBus.$on('clearPopupButtons', () => {
      this.clearPopupButtons();
    });
    if (!this.mainFilter) {
      this.$emit('filterSubmit', this.clearFilter, true, true);
      if (this.clearFilter.metro) {
        this.updateButtonCount('popupAreaMetro', this.clearFilter.metro.length);
      }
      if (this.clearFilter.locality || this.clearFilter.transport_ring || this.clearFilter.district) {
        const count = [];
        if (this.clearFilter.locality) count.push(...this.clearFilter.locality);
        if (this.clearFilter.transport_ring) count.push(...this.clearFilter.transport_ring);
        if (this.clearFilter.district) count.push(...this.clearFilter.district);
        this.updateButtonCount('popupAreaDistrict', count.length);
      }
      if (this.clearFilter.country || this.clearFilter.city) {
        const count = [];
        if (this.clearFilter.country) count.push(...this.clearFilter.country);
        if (this.clearFilter.city) count.push(...this.clearFilter.city);
        this.updateButtonCount('popupCountryCity', count.length);
      }
    }
  },
  props: ['info', 'className', 'mainFilter'],
});
