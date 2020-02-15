require('./title-third.scss');

const template = require('./title-third.pug');

export default template({
  props: ['text', 'className'],
});
