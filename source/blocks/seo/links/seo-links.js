import cSeoLinksItem from './seo-links__item';
require('./seo-links.scss');

const template = require('./seo-links.pug');

export default template({
  components: {
    cSeoLinksItem,
  },
  data() {
    return {
      isOpen: true,
    }
  },
  props: ['obj', 'className']
});
