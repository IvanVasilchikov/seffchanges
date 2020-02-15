import cPicture from '../../core/picture/picture';
import cTitle from '../../fonts/title/title';
import cTitleFifth from '../../fonts/title/fifth/title-fifth';
require('./banner-home.scss');

const template = require('./banner-home.pug');

export default template({
  components: {
    cPicture,
    cTitle,
    cTitleFifth
  },
  props: ['obj', 'className']
});
