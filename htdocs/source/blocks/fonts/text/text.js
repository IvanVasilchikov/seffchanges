require('./text.scss');

const template = require('./text.pug');

export default template({
  props: ['text', 'className'],
});
