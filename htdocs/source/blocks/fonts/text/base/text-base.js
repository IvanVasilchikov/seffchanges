require('./text-base.scss');

const template = require('./text-base.pug');

export default template({
  props: ['text', 'className'],
});
