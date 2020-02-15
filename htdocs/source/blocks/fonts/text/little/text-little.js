require('./text-little.scss');

const template = require('./text-little.pug');

export default template({
  props: ['text', 'className'],
});
