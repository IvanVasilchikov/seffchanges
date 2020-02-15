const template = require('./core-checkbox-with-circle.pug');

require('./core-checkbox-with-circle.scss');

export default template({
  model: {
    prop: 'checked',
    event: 'change',
  },
  props: ['id', 'name', 'text', 'className', 'attributes', 'checked', 'colorCircle'],
});
