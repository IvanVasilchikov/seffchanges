import cTitleFourthM from './../../fonts/title/fourth/m/title-fourth-m.pug';
import cTitle from './../../fonts/title/title';
import cText from './../../fonts/text/text';
import cPicture from './../../core/picture/picture';
import cBtn from './../../core/btn/btn';
require('./home-experience.scss');

const template = require('./home-experience.pug');

export default template({
  components: {
    cPicture,
    cTitleFourthM,
    cTitle,
    cText,
    cBtn
  },
  props: ['obj'],
});
