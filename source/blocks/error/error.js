import Vue from 'vue';
import cPicture from '../core/picture/picture'
require('./error.scss');

const template = require('./error.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.errorPage) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cPicture
      },
      data() {
        return {
          info: window.INIT.errorPage,
        }
      },
    }));
    app.$mount(rootEl);
  }
};
