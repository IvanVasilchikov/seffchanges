import cAnimationFade from '../core/animation/fade/animation-fade';
require('./share.scss');

const template = require('./share.pug');

export default template({
  components: {
    cAnimationFade,
  },
  data() {
    return {
      showButtons: false,
      btnsWidth: 'auto',
    }
  },
  watch: {
    showButtons() {
      if (this.showButtons) {
        this.$nextTick(() => {
          this.btnsWidth = this.$refs.btns.scrollWidth;
        });
      }
    }
  },
  methods: {
    shareClick(name) {
      if (name === 'vk') {
        this.vkontakte(`${window.location.href}`);
      } else if (name === 'facebook') {
        this.facebook(`${window.location.href}`);
      } else if (name === 'twitter') {
        this.twitter(`${window.location.href}`);
      } else if (name === 'whatsApp') {
        this.whatsApp(`${window.location.href}`);
      } else if (name === 'telegram') {
        this.telegram(`${window.location.href}`);
      } else if (name === 'viber') {
        this.viber(`${window.location.href}`);
      } else if (name === 'email') {
        this.email(`${window.location.href}`);
      }
    },
    email(purl) {
      let url = 'mailto:?Subject=';
      url += `${encodeURIComponent(purl)}`;
      this.popup(url);
    },
    vkontakte(purl) {
      let url = 'http://vkontakte.ru/share.php?';
      url += `url=${encodeURIComponent(purl)}`;
      this.popup(url);
    },
    facebook(purl) {
      let url = 'http://m.facebook.com/sharer.php?';
      url += `u=${encodeURIComponent(purl)}`;
      this.popup(url);
    },
    twitter(purl) {
      let url = 'http://twitter.com/share?';
      url += `&url=${encodeURIComponent(purl)}`;
      this.popup(url);
    },
    whatsApp(purl) {
      const url = `https://wa.me/?text=${encodeURIComponent(purl)}`;
      this.popup(url);
    },
    telegram(purl) {
      const url = `tg://msg?text=${encodeURIComponent(purl)}`;
      this.popup(url);
    },
    viber(purl) {
      const url = `viber://forward?text=${encodeURIComponent(purl)}`;
      this.popup(url);
    },
    popup(url) {
      window.open(url, '', 'toolbar=0,status=0,width=626,height=436');
    },
  },
  props: ['buttons', 'className'],
});
