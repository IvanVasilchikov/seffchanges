import cTitle from '../fonts/title/title';
import cBtn from '../core/btn/btn';
import Api from '../../base/scripts/api'
require('./clients.scss');

const template = require('./clients.pug');

export default template({
  components: {
    cTitle,
    cBtn
  },
  data() {
    return {
      loadedClients: [],
      visibleClients: 5,
    }
  },
  methods: {
    loadClients() {
      if (this.visibleClients === 5) {
        this.visibleClients = 6;
      }
      Api.get(this.obj.moreClients).then((response) => {
        this.loadedClients = [...response.data];
      });
    },
    visibleClientsCount() {
      this.visibleClients = window.innerWidth <= 1023 ? 6 : 5;
    },
  },
  mounted() {
    this.visibleClientsCount();
  },
  props: ['obj', 'className', 'itemClass'],
});
