import cCardGallery from '../gallery/card-gallery';
import popupEvent from '../../../base/scripts/popupEvent';
import Api from '../../../base/scripts/api'
require('./card-visual.scss');

const template = require('./card-visual.pug');

export default template({
  components: {
    cCardGallery,
  },
  props: ['card', 'className'],
});
