import cTitleFourth from '../../fonts/title/fourth/title-fourth';
import cPicture from '../../core/picture/picture';
import cBtn from '../../core/btn/btn';
import cMap from '../../map/map';
require('./about-location.scss');

const template = require('./about-location.pug');

export default template({
  components: {
    cTitleFourth,
    cPicture,
    cMap,
    cBtn,
  },
  props: ['info'],
});
