import Cookie from 'js-cookie';

export default class Cookies {
	constructor(parent) {
		this.parent = parent;

		if (this.parent) {
			this.button = parent.querySelector('.cookies__button');

			if (!Cookie.get('cookieAccepted')) {
				this.parent.classList.add('cookies--visible');
				this.button.addEventListener('click', () => {
					Cookie.set('cookieAccepted', true);
					this.parent.classList.remove('cookies--visible');
				});
			}
		}
	}
}
