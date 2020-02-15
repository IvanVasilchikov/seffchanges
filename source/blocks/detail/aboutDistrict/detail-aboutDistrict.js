import cTitle from '../../fonts/title/title';
import cTitleFourth from '../../fonts/title/fourth/title-fourth';
import cText from '../../fonts/text/text';
import cPicture from '../../core/picture/picture';
require('./detail-aboutDistrict.scss');

const template = require('./detail-aboutDistrict.pug');

export default template({
  components: {
    cPicture,
    cTitle,
    cTitleFourth,
    cText
  },
  props: ['info'],
});
