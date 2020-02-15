require('./title-fourth.scss');

const template = require('./title-fourth.pug');

export default template({
  props: ['text', 'className', 'isH1'],
});
