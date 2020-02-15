require('./title-first.scss');

const template = require('./title-first.pug');

export default template({
  props: ['text', 'className'],
});
