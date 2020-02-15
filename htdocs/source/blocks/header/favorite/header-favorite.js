import URLSearchParams from 'url-search-params';

const template = require('./header-favorite.pug');
import vStore from '../../../base/scripts/vue/v-store';
export default template({
	data() {
		return {
			countData: vStore.state.favorite,
		}
	},
	watch: {
		countData() {
		}
	},
	computed: {
		count() {
			return this.countData.length;
		}
	},
	methods: {
		send() {
			if (this.count > 0) {
				const url = new URLSearchParams();
				this.countData.forEach((item) => {
					url.append('ids[]', item);
				});
				window.location.href = '/favorite/?'+url.toString();
			}
		}
	}
});
