require('./first-title.scss');

const template = require('./first-title.pug');

export default template({
  props: ['text', 'className'],
});
