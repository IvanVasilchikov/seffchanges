import Vue from 'vue';
import cAnimationFade from '../core/animation/fade/animation-fade';
import cDetailNav from './nav/detail-nav';
import cDetailMain from './main/detail-main';
import cDetailCharacteristics from './characteristics/detail-characteristics';
import cBannerDetail from '../banner/detail/banner-detail';
import cDetailAboutComplex from './aboutComplex/detail-aboutComplex';
import cDetailInfrastructure from './infrastructure/detail-infrastructure';
import cDetailMap from './map/detail-map';
import cDetailAboutDistrict from './aboutDistrict/detail-aboutDistrict';
import cDetailSimilar from './similar/detail-similar';
require('./detail.scss');

const template = require('./detail.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.detailObject) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cAnimationFade,
        cDetailNav,
        cDetailMain,
        cDetailCharacteristics,
        cBannerDetail,
        cDetailAboutComplex,
        cDetailInfrastructure,
        cDetailMap,
        cDetailAboutDistrict,
        cDetailSimilar
      },
      data() {
        return {
          info: window.INIT.detailObject,
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
        if (this.$refs.main && this.$refs.main.info.price && this.$refs.main.info.price.total) {
          this.$refs.nav.price = this.$refs.main.info.price.total.rub;
        }
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
