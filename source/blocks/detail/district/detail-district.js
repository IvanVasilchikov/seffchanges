import Vue from 'vue';
import cAnimationFade from '../../core/animation/fade/animation-fade';
import cDetailNav from '../nav/detail-nav';
import cDetailDistrictMain from './main/detail-district-main';
import cDetailDistrictAbout from './about/detail-district-about';
import cDetailInfrastructure from '../infrastructure/detail-infrastructure';
import cDetailMap from '../map/detail-map';
import cBannerRequest from '../../banner/request/banner-request';
import cDetailOffers from '../offers/detail-offers';
import cText from '../../fonts/text/text';
require('./detail-district.scss');

const template = require('./detail-district.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.detailDistrict) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cAnimationFade,
        cDetailNav,
        cDetailDistrictMain,
        cDetailDistrictAbout,
        cDetailInfrastructure,
        cDetailMap,
        cDetailOffers,
        cBannerRequest,
        cText
      },
      data() {
        return {
          info: window.INIT.detailDistrict,
        };
      },
      methods: {
        isElementInViewport(el) {
          const rect = el.getBoundingClientRect();
          return rect.top <= window.innerHeight / 2.7;
        },
        checkScreen() {
          if (this.$refs.nav) {
            const header = document.querySelector('.header');
            this.$refs.nav.fixHeader = window.pageYOffset > (this.screens[0].offsetHeight + header.offsetHeight);
          }

          this.screens.forEach((screen) => {
            if (this.isElementInViewport(screen)) {
              this.$refs.nav.activeAnchor = `#${screen.id}`;
            }
          });
        }
      },
      mounted() {
        this.screens = [].slice.call(this.$el.querySelectorAll('[data-screen]'));

        if (this.screens) {
          this.checkScreen();

          window.onscroll = () => {
            this.checkScreen();
          };
        }
      },
    }));
    app.$mount(rootEl);
  }
};
