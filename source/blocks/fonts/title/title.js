require('./title.scss');

const template = require('./title.pug');

export default template({
  props: ['text', 'className', 'link', 'title'],
});
