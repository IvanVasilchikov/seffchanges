import debounce from 'lodash/debounce';
import cCheckbox from '../../../core/checkbox/checkbox';
import cBtn from '../../../core/btn/btn';
import api from '../../../../base/scripts/api';
import pluralize from '../../../../base/scripts/pluralize';
import popupEvent from '../../../../base/scripts/popupEvent';
import PerfectScrollbar from 'perfect-scrollbar';
import vueBus from '../../../../base/scripts/vue/v-bus';
import vStore from '../../../../base/scripts/vue/v-store';
import catalogConst from '../../../filter/catalog/catalog-const';
require('./popup-area-district.scss');

const template = require('./popup-area-district.pug');
export default (resolve) => {
  resolve(template({
    name: 'popupAreaDistrict',
    data() {
      return {
        info: {},
        offersCount: 0,
        districtsSelect: {},
        search: '',
        getBounceCount: null,
        perfectScrollbar: null,
        shadowView: true,
        hideSticky: false,
        buttonWidth: '100%',
      };
    },
    computed: {
      getOffersCount() {
        return pluralize(this.offersCount, ['Предложение', 'Предложения', 'Предложений']);
      },
      objConst() {
        return catalogConst.fields.reduce((summ, item) => {
          summ[item] = [];
          return summ;
        }, {});
      }
    },
    components: {
      cCheckbox,
      cBtn,
    },
    methods: {
      checkboxClick(name, value, nameList) {
        this.districtToggle(name, value, nameList);
      },
      districtToggle(name, value, nameList) {
        if (!this.districtsSelect[nameList]) this.districtsSelect[nameList] = [];
        if (value && this.districtsSelect[nameList] && !~this.districtsSelect[nameList].indexOf(name)) {
          this.districtsSelect[nameList].push(name);
        } else if (!value && this.districtsSelect[nameList] && ~this.districtsSelect[nameList].indexOf(name)) {
          this.districtsSelect[nameList].splice(this.districtsSelect[nameList].indexOf(name), 1);
          if (this.districtsSelect[nameList] && !this.districtsSelect[nameList].length) delete this.districtsSelect[nameList];
        }
        this.getBounceCount();
      },
      getCount() {
        const formData = Object.assign({
          cnt: 1
        }, vStore.state.mapFilter, this.objConst, this.districtsSelect);
        api.get(window.setting.api.objects, formData).then((responce) => {
          this.offersCount = responce.data.count;
        });
      },
      reset() {
        this.info.forEach((list) => {
          list.inner.forEach((item) => {
            item.checked = false;
          });
        });
        this.districtsSelect = {};
        this.search = '';
        this.getBounceCount();
        vueBus.$emit('setDistrict', this.districtsSelect, 'reset');
      },
      selectAll() {
        this.info.forEach((list) => {
          list.inner.forEach((item) => {
            this.districtToggle(item.value, true, list.listName);
            item.checked = true;
          })
        })
      },
      save() {
        popupEvent.close();
        let count = null;
        Object.keys(this.districtsSelect).forEach((key) => {
          count += this.districtsSelect[`${key}`].length;
        });
        vueBus.$emit('setDistrict', this.districtsSelect, count);
      },
      hiddenCheckbox(checkbox) {
        checkbox.hidden = checkbox.text.toLowerCase().indexOf(this.search.toLowerCase()) === -1;
        return !checkbox.hidden;
      },
      hiddenList(list) {
        const hiddenCheckboxes = [];
        list.inner.forEach((item) => {
          if (item.hidden) hiddenCheckboxes.push(item.hidden);
        });
        list.hidden = hiddenCheckboxes.length === list.inner.length;
        return !list.hidden;
      },
      selectClick(list) {
        const newValue = !this.listAllChecked(list);
        list.inner.forEach((item) => {
          this.districtToggle(item.value, newValue);
          item.checked = newValue;
        });
      },
      listAllChecked(list) {
        const checkedCheckboxes = [];
        list.inner.forEach((item) => {
          if (item.checked) checkedCheckboxes.push(item.checked);
        });
        return checkedCheckboxes.length === list.inner.length;
      }
    },
    props: ['popupData'],
    async created() {
      if (!this.popupData.dataset) {
        this.popupData.dataset = window.setting.api.district;
      }
      const data = await api.get(this.popupData.dataset);
      this.info = data.data;
      const dataFilter = vStore.state.mapFilter;
      this.info.forEach((list) => {
        this.$set(list, 'hidden', false);
        list.inner.forEach((item) => {
          if (dataFilter[list.listName] && (
              (Array.isArray(dataFilter[list.listName]) && dataFilter[list.listName].indexOf(item.value) !== -1) ||
              (!Array.isArray(dataFilter[list.listName]) && dataFilter[list.listName].indexOf(item.value) === 0))) {
            if (this.districtsSelect[list.listName] === undefined) {
              this.$set(this.districtsSelect, list.listName, []);
            }
            this.districtsSelect[list.listName].push(item.value);
            this.$set(item, 'checked', true);
          } else {
            this.$set(item, 'checked', false);
          }
          this.$set(item, 'hidden', false);
        });
      });
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

      this.$refs.scroll.addEventListener('ps-scroll-y', () => {
        if (!this.shadowView) this.shadowView = true;
      });

      this.$refs.scroll.addEventListener('ps-y-reach-end', () => {
        this.shadowView = false;
      });
      this.hideSticky = window.innerWidth >= 768;
      if (this.$refs.submitBtn) this.buttonWidth = this.$refs.submitBtn.$el.offsetWidth;
      this.$parent.$el.addEventListener('scroll', () => {
        if (window.innerWidth <= 767) {
          const stickyBtnPos = this.$refs.stickyBtn.$el.getBoundingClientRect().y;
          const btnPos = this.$refs.submitBtn.$el.getBoundingClientRect().y;
          this.hideSticky = btnPos - 20 <= stickyBtnPos;
        }
      });
      this.getBounceCount();
    },
    updated() {
      this.perfectScrollbar.update();
      if (this.$refs.submitBtn) this.buttonWidth = this.$refs.submitBtn.$el.offsetWidth;
    },
  }));
};
