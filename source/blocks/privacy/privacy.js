import Vue from 'vue';
import cBreadcrumbs from '../core/breadcrumbs/breadcrumbs';
import cTitle from '../fonts/title/title';
import cText from '../fonts/text/text';
import cTitleFourth from '../fonts/title/fourth/title-fourth';
import ScrollTo from '../../base/scripts/scrollTo';
require('./privacy.scss');

const template = require('./privacy.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.privacyPolicy) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cBreadcrumbs,
        cTitle,
        cTitleFourth,
        cText,
      },
      data() {
        return {
          info: window.INIT.privacyPolicy,
        };
      },
      methods: {
        scroll(event, id) {
          ScrollTo({
            anchor: `#${id}`
          });
        },
      }
    }));
    app.$mount(rootEl);
  }
};
