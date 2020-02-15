require('./catalog-list.scss');

const template = require('./catalog-list.pug');

export default template({
  props: ['info', 'className'],
});
