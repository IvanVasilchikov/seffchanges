import Vue from 'vue';
import cAboutMain from './main/about-main';
import cAboutFeatures from './features/about-features';
import cAboutLocation from './location/about-location';
import cAboutServices from './services/about-services';
import cAboutLeadership from './leadership/about-leadership';
import cAboutAwards from './awards/about-awards';
import cClients from './../clients/clients';
require('./about.scss');

const template = require('./about.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.about) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cAboutMain,
        cAboutFeatures,
        cAboutLocation,
        cAboutServices,
        cAboutLeadership,
        cAboutAwards,
        cClients,
      },
      data() {
        return {
          info: window.INIT.about,
        };
      },
    }));
    app.$mount(rootEl);
  }
};
