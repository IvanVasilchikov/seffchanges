import cPicture from '../../core/picture/picture';
import cTitle from '../../fonts/title/title';
import cTitleFifth from '../../fonts/title/fifth/title-fifth';
require('./banner-visual.scss');

const template = require('./banner-visual.pug');

export default template({
  components: {
    cPicture,
    cTitle
  },
  props: ['obj', 'className']
});
