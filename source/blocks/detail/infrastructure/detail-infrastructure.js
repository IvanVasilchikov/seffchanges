import cAnimationFade from '../../core/animation/fade/animation-fade';
import cTitle from '../../fonts/title/title';
import cPicture from '../../core/picture/picture';
require('./detail-infrastructure.scss');

const template = require('./detail-infrastructure.pug');

export default template({
  components: {
    cTitle,
    cAnimationFade,
    cPicture,
  },
  data() {
    return {
      activeTab: this.info.tabs[0].button.value,
    }
  },
  props: ['info'],
});
