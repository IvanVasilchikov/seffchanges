import api from '../../../base/scripts/api';
import popupEvent from '../../../base/scripts/popupEvent';
import cFilterCatalog from '../catalog/filter-catalog';
import cSelect from '../../core/select/select';
import cLabel from '../../core/label/label';
import VueBus from '../../../base/scripts/vue/v-bus';

require('./filter-home.scss');
import filterCommon from '../filterCommon';

const template = require('./filter-home.pug');

export default template({
  components: {
    cSelect,
    cLabel,
    cFilterCatalog
  },
  mixins: [filterCommon],
  data() {
    return {
      filterUrl: '',
      activeTab: '',
      filter: {}
    }
  },
  methods: {
    openPopup(type, name) {
      popupEvent.open(type, name);
    },
    changeTab(val, name, disabled) {
      if (!disabled) {
        this.activeTab = val;

        if (val) {
          this.updateFilter();
          VueBus.$emit('clearPopupButtons');
        }
      }
    },
    openTag(tag) {
      window.location = tag.value;
    },
    submitFilter(filter) {
      api.get(window.setting.api.catalog, filter).then((response) => {
        const {
          url
        } = response.data;
        if (url) {
          window.location.href = url;
        }
      });
    },
  },
  created() {
    const currentTab = this.info.tabs.filter((el) => el.active)[0];
    this.activeTab = currentTab.name;
    this.updateFilter();
  },
  mounted() {},
  props: ['info'],
});
