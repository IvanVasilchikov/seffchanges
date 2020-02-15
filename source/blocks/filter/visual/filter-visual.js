import debounce from 'lodash/debounce';
import cLabel from './../../core/label/label';
import cHint from '../../core/hint/hint';
import cFilterAddress from '../address/filter-address';
import vStore from '../../../base/scripts/vue/v-store';
import popupEvent from '../../../base/scripts/popupEvent';
import ScrollTo from '../../../base/scripts/scrollTo';
import api from '../../../base/scripts/api';
import filterCommon from '../filterCommon';
import VueBus from '../../../base/scripts/vue/v-bus';
import catalogConst from './catalog-const';
require('./filter-visual.scss');

const template = require('./filter-visual.pug');

export default template({
  components: {
    cLabel,
    cHint,
    cFilterAddress,
  },
  mixins: [filterCommon],
  data() {
    return {
      submitEventDebounce: '',
      activeTabsBtn: true,
      isOpenTabsList: false,
      textTabsBtn: 'Показать все',
      filter: {
      }
    }
  },
  methods: {
    popupOpen(type, name) {
      popupEvent.open(type, name);
    },
    openAreaPopup(popupInfo) {
      popupEvent.openAsync('area', Object.assign({}, popupInfo, {
        tabs: this.info.popupButtons
      }));
    },
    searchTabs() {
      this.tabsWrap = this.$el.querySelector('.filter-visual__tags');
      this.tabs = this.$el.querySelector('.filter-visual__tags-items');
    },
    checkHeightTabs() {
      if (this.tabs.clientHeight <= this.tabsWrap.clientHeight) this.activeTabsBtn = false;
    },
    changeHint(value, name) {
      this.setFieldData(value, name);
      this.submitEventDebounce();
    },
    changeTabsAccordion() {
      this.searchTabs();

      if (!this.isOpenTabsList) {
        this.tabsWrap.style.maxHeight = `${this.tabs.clientHeight}px`;
        this.textTabsBtn = 'Скрыть';
        this.isOpenTabsList = true;

        setTimeout(() => {
          this.tabsWrap.style.maxHeight = 'auto';
        }, 450);
      } else {
        this.tabsWrap.style.maxHeight = `${this.tabs.clientHeight}px`;
        this.isOpenTabsList = false;
        this.textTabsBtn = 'Показать все';

        setTimeout(() => {
          this.tabsWrap.style.maxHeight = '';
        }, 1);
      }
    },
    setTag(tag) {
      if (this.filter.tags === undefined) {
        this.$set(this.filter, 'tags', []);
      }
      if (tag.checked) {
        this.filter.tags.push(tag.value);
      } else {
        const index = this.filter.tags.indexOf(tag.value);
        this.filter.tags.splice(index, 1);
      }

      this.submitEventDebounce();
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
          this.$delete(this.filter, item);
        }
      });
      vStore.commit('saveFilter', this.clearFilter);
    },
    setInitFields(value, name) {
      if (name.search(/\[\d+\]/g) !== -1) {
        const tmpName = name.replace(/\[\d+\]/g, '');
        if (this.filter[tmpName] === undefined) {
          this.$set(this.filter, tmpName, []);
        }
        this.filter[tmpName].push(value);
      } else {
        this.$set(this.filter, name, value);
      }
    },
  },
  created() {
    this.fields = catalogConst.fields;
    this.info.popupButtons.forEach(item => {
      if (item.variable) {
        this.fields.push(item.variable);
      }
    });
    this.submitEventDebounce = debounce(this.submitFilter, 500);
    const params = new URLSearchParams(window.location.search);
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
      if (item.type === 'hidden') {
        this.$set(this.filter, item.name, item.value);
      } else {
        this.updateValue(item);
      }
    });
    VueBus.$on('setMetro', (params) => {
      this.setPopupFields(params);
      this.submitEventDebounce();
    });
    VueBus.$on('setDistrict', (params) => {
      this.setPopupFields(params);
      this.submitEventDebounce();
    });
    this.$emit('filterSubmit', this.clearFilter, true, true);
  },
  mounted() {
    this.searchTabs();
    this.checkHeightTabs();
  },
  props: ['info', 'pagination', 'className']
});
