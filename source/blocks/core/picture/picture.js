require('./picture.scss');

const template = require('./picture.pug');

export default template({
  props: ['data', 'className', 'optimize'],
});
