import Vue from 'vue';
import cBreadcrumbs from '../core/breadcrumbs/breadcrumbs';
import cMap from '../map/map';
import cTitle from '../fonts/title/title';
import cOffice from '../office/office';
import cFormQuestion from '../form/question/form-question';
require('./contacts.scss');

const template = require('./contacts.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.contacts) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cBreadcrumbs,
        cMap,
        cTitle,
        cOffice,
        cFormQuestion
      },
      data() {
        return {
          info: window.INIT.contacts,
        };
      },
    }));
    app.$mount(rootEl);
  }
};
