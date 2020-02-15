require('./loader.scss');

const template = require('./loader.pug');

export default template({
  props: ['className'],
});
