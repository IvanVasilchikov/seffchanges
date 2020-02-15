import cTitle from '../../fonts/title/title';
import cText from '../../fonts/text/text';
import cBtn from '../../core/btn/btn';
import cPicture from '../../core/picture/picture';
require('./detail-aboutComplex.scss');

const template = require('./detail-aboutComplex.pug');

export default template({
  components: {
    cTitle,
    cText,
    cPicture,
    cBtn,
  },
  props: ['info'],
});
