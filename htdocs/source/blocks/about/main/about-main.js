import cBreadcrumbs from '../../core/breadcrumbs/breadcrumbs';
import cPicture from '../../core/picture/picture';
import cTitleFourth from '../../fonts/title/fourth/title-fourth';
require('./about-main.scss');

const template = require('./about-main.pug');

export default template({
  components: {
    cBreadcrumbs,
    cPicture,
    cTitleFourth,
  },
  props: ['info'],
});
