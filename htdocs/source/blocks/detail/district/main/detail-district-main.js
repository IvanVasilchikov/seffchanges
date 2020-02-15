import cAnimationFade from '../../../core/animation/fade/animation-fade';
import cPicture from '../../../core/picture/picture';
import cBreadcrumbs from '../../../core/breadcrumbs/breadcrumbs';
import cBtn from '../../../core/btn/btn';
import ScrollTo from '../../../../base/scripts/scrollTo';

require('./detail-district-main.scss');

const template = require('./detail-district-main.pug');

export default template({
  components: {
    cAnimationFade,
    cBreadcrumbs,
    cPicture,
    cBtn
  },
  methods: {
    scrollTo(anchor) {
      ScrollTo({
        anchor,
      });
    },
  },
  props: ['info'],
});
