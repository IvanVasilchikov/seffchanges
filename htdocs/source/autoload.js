import '@babel/polyfill';
import 'promise-polyfill/src/polyfill';
import 'custom-event-polyfill';
import 'svgxuse';

import ObjectFitImages from 'object-fit-images';
import Header from './blocks/header/header';
import Footer from './blocks/footer/footer';
import Cookies from './blocks/cookies/cookies';
import errorPage from './blocks/error/error';
import popup from './blocks/popup/popup';

require('es6-object-assign').polyfill();
require('lazysizes');
require('./autoload.scss');

ObjectFitImages(null, { watchMQ: true });

window.lazySizesConfig = window.lazySizesConfig || {};
window.lazySizesConfig.customMedia = {
  '--small': '(max-width: 767px)',
  '--medium': '(min-width: 768px) and (max-width: 1279px)',
  '--large': '(min-width: 1280px)',
};
window.lazySizesConfig.preloadAfterLoad = true;
window.lazySizesConfig.expand = 600;
window.lazySizesConfig.expFactor = 1;

new Header(document.querySelector('.header'));
new Footer(document.querySelector('.footer'));

const cookiesBlock = document.querySelector('.cookies');
if (cookiesBlock) {
	new Cookies(cookiesBlock);
}

errorPage(document.querySelector('.error'));
popup(document.querySelector('.popup'));
