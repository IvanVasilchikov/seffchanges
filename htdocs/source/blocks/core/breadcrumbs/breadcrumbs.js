require('./breadcrumbs.scss');

const template = require('./breadcrumbs.pug');

export default template({
  props: ['links', 'className'],
});
