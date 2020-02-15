import Vue from 'vue';
import cFirstTitle from '../fonts/first-title/first-title';
import cBreadcrumbs from '../core/breadcrumbs/breadcrumbs';
require('./sitemap.scss');

const template = require('./sitemap.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.sitemap) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cBreadcrumbs,
        cFirstTitle,
      },
      data() {
        return {
          info: window.INIT.sitemap,
        }
      },
    }));
    app.$mount(rootEl);
  }
};
