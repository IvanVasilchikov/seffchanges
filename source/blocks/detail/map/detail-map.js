import cTitle from '../../fonts/title/title';
import cLabel from '../../core/label/label';
import cMap from '../../map/map';
require('./detail-map.scss');

const template = require('./detail-map.pug');

export default template({
  components: {
    cTitle,
    cMap,
  },
  props: ['info', 'className'],
});
