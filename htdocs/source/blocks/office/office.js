import cTitle from '../fonts/title/title';
import cTitleFourth from '../fonts/title/fourth/title-fourth';
import cOfficeItem from './item/office-item';
require('./office.scss');

const template = require('./office.pug');

export default template({
    components: {
      cTitle,
      cTitleFourth,
      cOfficeItem
    },
    props: ['info', 'className'],
});
