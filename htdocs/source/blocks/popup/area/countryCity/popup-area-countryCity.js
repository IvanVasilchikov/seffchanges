import cCheckbox from '../../../core/checkbox/checkbox';
import cSelect from '../../../core/select/select';
import cBtn from '../../../core/btn/btn';
import api from '../../../../base/scripts/api';
import popupEvent from '../../../../base/scripts/popupEvent';
import PerfectScrollbar from 'perfect-scrollbar';
import vueBus from '../../../../base/scripts/vue/v-bus';
import vStore from 'app/base/scripts/vue/v-store';
import pluralize from 'app/base/scripts/pluralize';
import catalogConst from 'app/blocks/filter/catalog/catalog-const';
import debounce from 'lodash/debounce';
require('./popup-area-countryCity.scss');

const template = require('./popup-area-countryCity.pug');
export default (resolve) => {
	resolve(template({
		name: 'popupCountryCity',
		data() {
			return {
				info: {},
				selected: {
					city: [],
					country: []
				},
				perfectScrollbar: null,
				shadowView: true,
				search: '',
				offersCount: 0,
				hideSticky: false,
				buttonWidth: '100%',
			};
		},
		components: {
			cSelect,
			cCheckbox,
			cBtn,
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
		methods: {
			getCount() {
				const formatSelected = {};
				Object.keys(this.selected).map((key) => {
					if (this.selected[`${key}`].length !== 0) formatSelected[`${key}`] = this.selected[`${key}`];
				});
				const formData = Object.assign({
					cnt: 1
				}, vStore.state.mapFilter, this.objConst, formatSelected);
				api.get(window.setting.api.objects, formData).then((response) => {
					this.offersCount = response.data.count;
				});
			},
			reset() {
				this.info.forEach((list) => {
					list.inner.forEach((item) => {
						item.checked = false;
					});
				});
				this.selected.city = [];
				this.selected.country = [];
				this.search = '';
				this.getBounceCount();

				vueBus.$emit('setCountryCity', this.selected, 'reset');
			},
			save() {
				popupEvent.close();
				const count = this.selected.city.length + this.selected.country.length;
				vueBus.$emit('setCountryCity', this.selected, count);
			},
			checkboxClick(checkbox, list) {
				if (list && list.listName === 'country') {
					if (!checkbox.checked) {
						const index = this.selected.country.indexOf(checkbox.value);
						if (index !== -1) this.selected.country.splice(index, 1);
					} else this.selected.country.push(checkbox.value);
				} else {
					if (!checkbox.checked) {
						const index = this.selected.city.indexOf(checkbox.value);
						if (index !== -1) this.selected.city.splice(index, 1);
					} else this.selected.city.push(checkbox.value);
				}
				this.getBounceCount();
			},
			hiddenCheckbox(checkbox, checkboxes) {
				const listName = checkboxes.name.toLowerCase().indexOf(this.search.toLowerCase()) === -1;
				const checkboxText = checkbox.text.toLowerCase().indexOf(this.search.toLowerCase()) === -1;
				if (!listName) {
					this.$set(checkbox, 'hidden', listName);
					return !checkbox.hidden;
				}
				this.$set(checkbox, 'hidden', checkboxText);
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
		},
		props: ['popupData'],
		async created() {
			if (!this.popupData.dataset) {
				this.popupData.dataset = window.setting.api.countryCity;
			}
			const data = await api.get(this.popupData.dataset);
			this.info = data.data;
			const dataFilter = vStore.state.mapFilter;
			this.info.forEach((list) => {
				this.$set(list, 'hidden', false);
				list.inner.forEach((item) => {
					let type = 'city';
					if (list.listName === 'country') type = 'country';
					if (dataFilter && dataFilter[`${type}`] && (dataFilter[`${type}`].indexOf(item.value) !== -1)) {
						this.selected[`${type}`].push(item.value);
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
