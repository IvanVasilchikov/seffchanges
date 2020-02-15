import URLSearchParams from 'url-search-params';
import vStore from '../../../base/scripts/vue/v-store';
import cFilterRadio from '../radio/filter-radio';
import cFilterRange from '../range/filter-range';
import cSelect from '../../core/select/select';
import filterCommon from '../filterCommon';
import debounce from 'lodash/debounce';
require('./filter-detail.scss');

const template = require('./filter-detail.pug');

export default template({
  components: {
    cFilterRange,
    cFilterRadio,
    cSelect,
  },
  mixins: [filterCommon],
  data() {
    return {
      filter: {}
    }
  },
  watch: {
    filter: {
      handler() {
        this.updateEventDebounce();
      },
      deep: true,
    }
  },
  methods: {
    updateEvent() {
      this.$emit('filterSubmit', '', this.clearFilter);
    },
    setFieldData(val, name) {
      this.$set(this.filter, `${name}`, val);
    },
  },
  created() {
    vStore.commit('saveFilter', {});
    if (this.info.params !== undefined) {
      Object.keys(this.info.params).forEach((key) => {
        this.$set(this.filter, key, this.info.params[key]);
      });
    }
    this.info.fields.forEach((item) => {
      if (item.type !== 'range') {
        if (item.type === 'hidden') {
          this.$set(this.filter, item.name, item.value);
        } else {
          this.updateValue(item);
        }
      }
    });
  },
  mounted() {
    this.updateEventDebounce = debounce(this.updateEvent, 500);
  },
  props: ['info'],
});
