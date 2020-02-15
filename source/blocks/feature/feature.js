import cText from '../fonts/text/text';
import cTitleFifth from '../fonts/title/fifth/title-fifth';
require('./feature.scss');

const template = require('./feature.pug');

export default template({
  components: {
    cTitleFifth,
    cText,
  },
  props: ['info', 'className'],
});
