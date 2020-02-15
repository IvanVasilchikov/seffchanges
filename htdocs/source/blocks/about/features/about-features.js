import cTitle from '../../fonts/title/title';
import cTitleFifth from '../../fonts/title/fifth/title-fifth';
import cFeature from '../../feature/feature';
require('./about-features.scss');

const template = require('./about-features.pug');

export default template({
  components: {
    cTitle,
    cTitleFifth,
    cFeature,
  },
  props: ['info'],
});
