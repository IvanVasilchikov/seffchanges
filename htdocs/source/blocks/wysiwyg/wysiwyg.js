require('./wysiwyg.scss');

const template = require('./wysiwyg.pug');

export default template({
  name: 'wysiwyg',
  props: ['info', 'className'],
});
