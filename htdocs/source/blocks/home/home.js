import Vue from 'vue';
import cBannerHome from '../banner/home/banner-home';
import cFilterHome from '../filter/home/filter-home';
import cHomeTypes from './types/home-types';
import cHomeHow from './how/home-how';
import cHomeExperience from './experience/home-experience';
import cHomeServices from './services/home-services';
import cHomeAgency from './agency/home-agency';
import cHomeOffers from './offers/home-offers';
import cBannerRequest from '../banner/request/banner-request';
import cHomeFeatures from './features/home-features';
import cClients from '../clients/clients';
import cPresentation from '../presentation/presentation';
import cSeoLinks from '../seo/links/seo-links';
import api from '../../base/scripts/api';
require('./home.scss');

const template = require('./home.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.indexPage) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cBannerHome,
        cFilterHome,
        cHomeTypes,
        cHomeHow,
        cHomeExperience,
        cHomeServices,
        cHomeAgency,
        cHomeOffers,
        cBannerRequest,
        cHomeFeatures,
        cClients,
        cPresentation,
        cSeoLinks,
      },
      data() {
        return {
          info: window.INIT.indexPage
        };
      },
    }));
    app.$mount(rootEl);
  }
};
