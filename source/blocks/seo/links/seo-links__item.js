import cAnimationHeight from '../../core/animation/height/animation-height';

const template = require('./seo-links__item.pug');

export default template({
  components: {
    cAnimationHeight,
  },
  data() {
    return {
      isOpen: true,
      activeBtn: false,
      isOpenExtraList: false,
      textBtn: null
    }
  },
  methods: {
    toggleItOpen() {
      this.isOpen = !this.isOpen;
    },
    searchContent() {
      this.contentWrap = this.$el.querySelector('.seo-links__content-wrap');
      this.content = this.$el.querySelector('.seo-links__content');
    },
    checkHeightContent() {
      if (this.content.clientHeight <= this.contentWrap.clientHeight) this.activeBtn = false;
    },
    changeAccordion() {
      this.searchContent();

      if (!this.isOpenExtraList) {
        this.contentWrap.style.maxHeight = `${this.content.clientHeight}px`;
        this.textBtn = 'Скрыть';
        this.isOpenExtraList = true;

        setTimeout(() => {
          this.contentWrap.style.maxHeight = 'auto';
        }, 450);
      } else {
        this.contentWrap.style.maxHeight = `${this.content.clientHeight}px`;
        this.isOpenExtraList = false;
        if (this.activeBtn) this.textBtn = this.item.btnOpen;

        setTimeout(() => {
          this.contentWrap.style.maxHeight = '';
        }, 1);
      }
    }
  },
  mounted() {
    if (this.item.btnOpen) {
      this.textBtn = this.item.btnOpen;
      this.activeBtn = true;
    }
    this.searchContent();
    this.checkHeightContent();
  },
  props: ['item']
});
