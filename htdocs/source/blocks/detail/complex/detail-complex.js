import Vue from 'vue';
import cAnimationFade from '../../core/animation/fade/animation-fade';
import cDetailNav from '../nav/detail-nav';
import cDetailMain from '../main/detail-main';
import cDetailCharacteristics from '../characteristics/detail-characteristics';
import cBannerDetail from '../../banner/detail/banner-detail';
import cDetailAbout from '../about/detail-about';
import cDetailChoose from '../choose/detail-choose';
import cDetailInfrastructure from '../infrastructure/detail-infrastructure';
import cDetailMap from '../map/detail-map';
import cDetailAboutDistrict from '../aboutDistrict/detail-aboutDistrict';
import cDetailSimilar from '../similar/detail-similar';
import '../detail.scss';

const template = require('./detail-complex.pug');

export default function (rootEl) {
  if (window.INIT && window.INIT.detailComplex) {
    const app = new Vue(template({
      name: 'app',
      components: {
        cAnimationFade,
        cDetailNav,
        cDetailMain,
        cDetailCharacteristics,
        cBannerDetail,
        cDetailAbout,
        cDetailChoose,
        cDetailInfrastructure,
        cDetailMap,
        cDetailAboutDistrict,
        cDetailSimilar
      },
      data() {
        return {
          info: window.INIT.detailComplex,
        };
      },
      methods: {
        isElementInViewport(el) {
          const rect = el.getBoundingClientRect();
          return rect.top <= window.innerHeight / 2.7;
        },
      },
      mounted() {
        if (this.$refs.main && this.$refs.main.info.price && this.$refs.main.info.price.total) {
          this.$refs.nav.price = this.$refs.main.info.price.total.rub;
        }
        const screens = [].slice.call(this.$el.querySelectorAll('[data-screen]'));

        window.onscroll = () => {
          if (this.$refs.nav) {
            const header = document.querySelector('.header');
            this.$refs.nav.fixHeader = window.pageYOffset > (screens[0].offsetHeight + header.offsetHeight);
          }

          screens.forEach((screen) => {
            if (this.isElementInViewport(screen)) {
              this.$refs.nav.activeAnchor = `#${screen.id}`;
            }
          });
        };
      },
    }));
    app.$mount(rootEl);
  }
};
