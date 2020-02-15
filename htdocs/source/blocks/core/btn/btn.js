require('./btn.scss');

const template = require('./btn.pug');

export default template({
  props: ['tag', 'text', 'className', 'disabled'],
});
