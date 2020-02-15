import cText from '../../../fonts/text/text';
import cTitle from '../../../fonts/title/title';

require('./detail-district-about.scss');

const template = require('./detail-district-about.pug');

export default template({
  components: {
    cTitle,
    cText,
  },
  props: ['info'],
});
